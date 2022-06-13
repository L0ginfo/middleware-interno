<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use App\Util\DateUtil;
use App\Util\UniversalCodigoUtil;
use App\Util\EntityUtil;
use App\Model\Entity\OrdemServico;
use App\Model\Entity\DocumentosMercadoria;
use App\RegraNegocio\AutoExecucaoOrdemServico\ExecuteCarga;
use App\RegraNegocio\Faturamento\FaturamentoBaixasManager;
use App\Util\DoubleUtil;
use App\Util\FlashUtil;
use Cake\ORM\Table;
use App\Util\LgDbUtil;
use App\Util\ObjectUtil;
use App\Util\ResponseUtil;
use Cake\Cache\Engine\NullEngine;
use Cake\ORM\TableRegistry;
use ParametroGerais;

/**
 * Resv Entity
 *
 * @property int $id
 * @property string $resv_codigo
 * @property \Cake\I18n\Time|null $data_hora_chegada
 * @property \Cake\I18n\Time|null $data_hora_entrada
 * @property \Cake\I18n\Time|null $data_hora_saida
 * @property int $operacao_id
 * @property int $veiculo_id
 * @property int $transportador_id
 * @property int $pessoa_id
 * @property int $modal_id
 * @property int $portaria_id
 * @property int $empresa_id
 *
 * @property \App\Model\Entity\Operacao $operacao
 * @property \App\Model\Entity\Veiculo[] $veiculos
 * @property \App\Model\Entity\Transportadora $transportadora
 * @property \App\Model\Entity\Pessoa $pessoa
 * @property \App\Model\Entity\Modal $modal
 * @property \App\Model\Entity\Portaria $portaria
 * @property \App\Model\Entity\Empresa $empresa
 * @property \App\Model\Entity\OrdemServico $OrdemServico
 */
class Resv extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     * 
     * default fields
     * 
     *  'resv_codigo' => true,
     *  'data_hora_chegada' => true,
     *  'data_hora_entrada' => true,
     *  'data_hora_saida' => true,
     *  'retroativo' => true,
     *  'operacao_id' => true,
     *  'veiculo_id' => true,
     *  'transportador_id' => true,
     *  'pessoa_id' => true,
     *  'modal_id' => true,
     *  'portaria_id' => true,
     *  'empresa_id' => true,
     *  'operacao' => true,
     *  'veiculos' => true,
     *  'transportadora' => true,
     *  'pessoa' => true,
     *  'modal' => true,
     *  'portaria' => true,
     *  'empresa' => true,
     *  'ordem_servico' => true,
     *  'observacao'=> true,
     *  '*'
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    private static function getOrSave($oEntityResv)
    {
        
    }

    public function saveResvs( $that, $aPost, $sTipo = 'descarga' )
    {

        if ($sTipo == 'descarga') {
            return $this->saveResvsDescarga($that, $aPost);
        }else if ($sTipo == 'carga' ){
            return $this->saveResvsCarga($that, $aPost);
        }else {
            return new \Exception('Não existe vínculo com esse tipo ('.$sTipo.') de operação para salvar a R.E.S.V.!', 1);
        }        
    }

    private function saveResvsCarga($that, $aPost) 
    {
        $aResv = $aPost['resvs'];
        $aLiberacaoDocumentalIDs = $aPost['documentos']['liberacao_documental_id'];

        $aResv['empresa_id']        = $that->getEmpresaAtual();
        $aResv['resv_codigo']       = (isset($aResv['resv_codigo'])) ? $aResv['resv_codigo'] : 0;
        $aResv['data_hora_chegada'] = (isset($aResv['data_hora_chegada']) ) ? DateUtil::dateTimeToDB($aResv['data_hora_chegada']) : null;
        $aResv['data_hora_entrada'] =  $aResv['data_hora_chegada'];
        $aResv['data_hora_saida']   = (isset($aResv['data_hora_saida']) ) ? DateUtil::dateTimeToDB($aResv['data_hora_saida']) : null;
        $aReboques                  = (isset($aResv['reboque'])) ? $aResv['reboque'] : array();
        
        $oResvs = $that->setEntity('Resvs', $aResv , ['contain' => 'AcessosPessoas']);
        $isNew  = $oResvs->isNew();
        $oResvs = $that->Resvs->patchEntity($oResvs, $aResv);
        
        $iResvsID = null;
        
        if (!$iResvsID = $that->Resvs->save($oResvs)) {            
            $this->Flash->error( __('Houve algum problema ao salvar o Registro de Entrada/Saída! ' . EntityUtil::dumpErrors($oResvs)) );
            return $that->redirect( $that->referer() );
        }

        $oResvs->saveAcessoPessoaResv($that);

        if ($isNew)
            $this->updateResvsCodigo($iResvsID->id, $that);

        $this->insertReboques($aReboques, $iResvsID->id, $that);

        if ($isNew)
            $this->insertResvsLiberacoesDocumentais($aLiberacaoDocumentalIDs, $iResvsID->id, $that);
        
        //Adiciona OS quando insere uma chegada, ou se editar a chegada e mandar re-gerar OS
        $aReturnOS = $this->manageOsGenerator($that, $isNew, $aResv, $oResvs, $aLiberacaoDocumentalIDs, 'carga');
        
        if ($isNew || (isset($aResv['regerar_os']) && $aResv['regerar_os'])) {
            return $aReturnOS;
        }

        return true;
    }

    private function insertResvsLiberacoesDocumentais($aLiberacaoDocumentalIDs, $iResvsID, $that)
    {
        foreach ($aLiberacaoDocumentalIDs as $key => $aLiberacaoDocumentalID) {

            $oResvsLiberacoesDocumentais = $that->ResvsLiberacoesDocumentais->newEntity();
            
            $aData = array(
                'resv_id'                 => $iResvsID,
                'liberacao_documental_id' => $aLiberacaoDocumentalID
            );

            $oResvsLiberacoesDocumentais = $that->ResvsLiberacoesDocumentais->patchEntity($oResvsLiberacoesDocumentais, $aData);

            if (!$that->ResvsLiberacoesDocumentais->save($oResvsLiberacoesDocumentais)) {
                $that->Flash->error( __('Não foi possível salvar o Registro de Entrada/Saída! ' . EntityUtil::dumpErrors($oResvsLiberacoesDocumentais) ) );
            }

        }
    }

    private function saveResvsDescarga($that, $aPost)
    {
        $aResv = $aPost['resvs'];
        $aTransporte = $aPost['transporte'];

        $aResv['empresa_id']        = $that->getEmpresaAtual();
        $aResv['resv_codigo']       = (isset($aResv['resv_codigo']))?$aResv['resv_codigo']:0;
        $aResv['data_hora_chegada'] = DateUtil::dateTimeToDB($aResv['data_hora_chegada']);
        $aResv['data_hora_entrada'] =  $aResv['data_hora_chegada'];
        $aReboques                  = (isset($aResv['reboque'])) ? $aResv['reboque'] : array();

        $oResvs = $that->setEntity('Resvs', $aResv , ['contain'=>'AcessosPessoas']);
        $isNew  = $oResvs->isNew();
        $oResvs = $that->Resvs->patchEntity($oResvs, $aResv);
        
        $iResvsID = null;
        
        if (!$iResvsID = $that->Resvs->save($oResvs)) {            
            $this->Flash->error( __('Houve algum problema ao salvar o Registro de Entrada/Saída! ' . EntityUtil::dumpErrors($oResvs)) );
            return $that->redirect( $that->referer() );
        }

        $oResvs->saveAcessoPessoaResv($that);

        if ($isNew)
            $this->updateResvsCodigo($iResvsID->id, $that);

        $this->insertReboques($aReboques, $iResvsID->id, $that);

        if ($isNew)
            $this->insertResvsDocumentosTrasportes($aTransporte['id'], $iResvsID->id, $that);

        //Adiciona OS quando insere uma chegada, ou se editar a chegada e mandar re-gerar OS
        $aReturnOS = $this->manageOsGenerator($that, $isNew, $aResv, $oResvs, $aTransporte['id'], 'descarga');
        
        if ($isNew || (isset($aResv['regerar_os']) && $aResv['regerar_os'])) {
            return $aReturnOS;
        }

        return true;
    }

    private function manageOsGeneratorDescarga($that, $isNew, $aResv, $oResvs, $iVinculoID = null, $sType = '', $bReturnResponse, $iContainerID = null, $sResvOperacaoDescricao = null)
    {
        $iDocTransID = $iVinculoID;
        $oDocumentosMercadoria = new DocumentosMercadoria;
        $oResponse = new ResponseUtil();

        if ($isNew || (isset($aResv['regerar_os']) && $aResv['regerar_os'])) {
            $aRetornoOS = array();

            $iOperacaoID = null;

            if (Resv::isDesova($oResvs)) {
                if (!$sResvOperacaoDescricao) {
                    $oOperacao = LgDbUtil::getByID('Operacoes', $oResvs->operacao_id);
                    $sResvOperacaoDescricao = $oOperacao->descricao;
                }
                $iOperacaoID = EntityUtil::getIdByParams('OrdemServicoTipos', 'descricao', $sResvOperacaoDescricao);
            } elseif (Resv::isDescarga($oResvs)) {
                $iOperacaoID = 1;
            }elseif (Resv::isCarga($oResvs)) {
                $iOperacaoID = 2;
            }else {
                $iOperacaoID = $oResvs->operacao_id;
            }

            $aData = array(
                'resv_id'                => $oResvs->id,
                'ordem_servico_tipo_id'  => Resv::isDescargaCarga($oResvs) ? 1 : $iOperacaoID,
                'retroativo'             => $aResv['retroativo'],
                'initiated_by_id'        => $that->getRequest()->getSession()->read('Auth.User.id'),
                'container_exclusivo_id IS' => $iContainerID
            );

            $aGradeGeraOsCntIguais = json_decode(
                ParametroGeral::getParametroWithValue('PARAM_GRADE_OS_MESMO_CONTAINER'), true);
    
            $aGradeGeraOsCntIguais = @$aGradeGeraOsCntIguais['grades'] ?: [];
            $bValidaGradeGeraCntIgual = !in_array(@$aResv['grade_horario_id'], $aGradeGeraOsCntIguais);

            $oOrdemServicoCheck = null;
            $oOrdemServico = new OrdemServico();
            if (!$bValidaGradeGeraCntIgual || !@$aResv['grade_horario_id']) {
    
                $oOrdemServicoCheck = $oOrdemServico->checkExistsOS( $that, $aData );
            }

            if ($oOrdemServicoCheck && isset($aResv['regerar_os']) && $aResv['regerar_os']) {
                $oOrdemServico->deleteOS( $that, $oOrdemServicoCheck );
                $aRetornoOS = $oOrdemServico->gerarOS( $that, $aData );
            }elseif (isset($oResvs->id) && isset($oResvs->operacao_id)) {
                $aRetornoOS = $oOrdemServico->gerarOS( $that, $aData, false, $oOrdemServicoCheck, $iContainerID );
            }

            if($iVinculoID){
                if (is_array($iVinculoID)) {
                    foreach ($iVinculoID as $iId) {
                        $oDocumentosMercadoria->generateLoteCodigo( $that, $iId );
                    }
                } else {
                    $oDocumentosMercadoria->generateLoteCodigo( $that, $iDocTransID );
                }
            }

            if ($bReturnResponse) {
                $oResponse = new ResponseUtil();
                return $oResponse->setMessage($aRetornoOS['message'])
                    ->setStatus($aRetornoOS['status'] ? 200 : 400);
            }

            if ($aRetornoOS && $aRetornoOS['status']) {
                $that->Flash->success( __('Sucesso!'), [
                    'params' => [
                        'html' => $aRetornoOS['message']
                    ]
                ] );
            } elseif ($aRetornoOS && !$aRetornoOS['status']) {
                $that->Flash->error( __('Ops!'), [
                    'params' => [
                        'html' => $aRetornoOS['message']
                    ]
                ] );
            }  

            return $aRetornoOS;
        }

        if ($bReturnResponse)
            return $oResponse
                ->setStatus(200)
                ->setMessage('Já existe OS.');
    }

    private function manageOsGeneratorCarga($that, $isNew, $aResv, $oResvs, $sType, $bReturnResponse)
    {
        $oResponse = new ResponseUtil();
        if ($isNew || (isset($aResv['regerar_os']) && $aResv['regerar_os'])) {
            $aRetornoOS = array();

            $iOperacaoID = null;

            if (Resv::isDescarga($oResvs)) {
                $iOperacaoID = 1;
            }elseif (Resv::isCarga($oResvs)) {
                $iOperacaoID = 2;
            }else {
                $iOperacaoID = $oResvs->operacao_id;
            }

            $aData = array(
                'resv_id'                => $oResvs->id,
                'ordem_servico_tipo_id'  => Resv::isDescargaCarga($oResvs) ? 2 : $iOperacaoID,
                'retroativo'             => $aResv['retroativo'],
                'initiated_by_id'        => $that->getRequest()->getSession()->read('Auth.User.id')
            );
            
            $oOrdemServico = new OrdemServico();

            $oOrdemServicoCheck = $oOrdemServico->checkExistsOS( $that, $aData );

            if ($oOrdemServicoCheck && isset($aResv['regerar_os']) && $aResv['regerar_os']) {
                $oOrdemServico->deleteOS( $that, $oOrdemServicoCheck );
                $aRetornoOS = $oOrdemServico->gerarOS( $that, $aData );
            }elseif (isset($oResvs->id) && isset($oResvs->operacao_id)) {
                $aRetornoOS = $oOrdemServico->gerarOS( $that, $aData, false, $oOrdemServicoCheck );
            }

            if ($bReturnResponse) {
                $oResponse = new ResponseUtil();
                return $oResponse->setMessage($aRetornoOS['message'])
                    ->setStatus($aRetornoOS['status'] ? 200 : 400);
            }
            
            if ($aRetornoOS && $aRetornoOS['status']) {
                $that->Flash->success( __('Sucesso!'), [
                    'params' => [
                        'html' => $aRetornoOS['message']
                    ]
                ] );
            }elseif ($aRetornoOS && !$aRetornoOS['status']) {
                $that->Flash->error( __('Ops!'), [
                    'params' => [
                        'html' => $aRetornoOS['message']
                    ]
                ] );
            }  

            return $aRetornoOS;
        }

        if ($bReturnResponse)
            return $oResponse
                ->setStatus(200)
                ->setMessage('Já existe OS.');
    }

    private function manageOsGenerator($that, $isNew, $aResv, $oResvs, $iVinculoID, $sType, $bReturnResponse = false, $iContainerID = null, $sResvOperacaoDescricao = null)
    {  
        if ($sType == 'descarga') {
            return $this->manageOsGeneratorDescarga($that, $isNew, $aResv, $oResvs, $iVinculoID, $sType, $bReturnResponse, $iContainerID, $sResvOperacaoDescricao);
        }else if ($sType == 'carga') {
            return $this->manageOsGeneratorCarga($that, $isNew, $aResv, $oResvs, $sType, $bReturnResponse);
        } else if ($sType == 'descarga_carga') {
            $this->manageOsGeneratorDescarga($that, $isNew, $aResv, $oResvs, $iVinculoID, $sType, $bReturnResponse);
            return $this->manageOsGeneratorCarga($that, $isNew, $aResv, $oResvs, $sType, $bReturnResponse);
        }

        return false;
    }

    private function insertResvsDocumentosTrasportes($iTransporteID, $iResvsID, $that)
    {        
        $oResvsDocumentosTransportes = $that->ResvsDocumentosTransportes->newEntity();
        
        $aData = array(
            'resv_id'                => $iResvsID,
            'documento_transporte_id' => $iTransporteID
        );

        $oResvsDocumentosTransportes = $that->ResvsDocumentosTransportes->patchEntity($oResvsDocumentosTransportes, $aData);

        if (!$that->ResvsDocumentosTransportes->save($oResvsDocumentosTransportes)) {
            $that->Flash->error( __('Não foi possível salvar o Registro de Entrada/Saída! ' . EntityUtil::dumpErrors($oResvsDocumentosTransportes) ) );
        }
    }

    private function insertReboques($aReboques, $iResvsID, $that, $bReturnResponse = false) 
    {
        $i = 1;
        $oResponse = new ResponseUtil();
        
        if ($aReboques) {
            foreach ($aReboques as $aReboque) {
                
                if ($aReboque['veiculo_id']) {
                    
                    $aDataReboque = array(
                        'sequencia_veiculo' => $i++,
                        'veiculo_id'        => $aReboque['veiculo_id'],
                        'resv_id'           => $iResvsID
                    );
                    
                    $aDataReboque = (isset($aReboque['id'])) ? $aDataReboque + ['id' => $aReboque['id'] ] : $aDataReboque; 
                    $oReboque = $that->setEntity('ResvsVeiculos', $aDataReboque );
        
                    $oReboque = $that->ResvsVeiculos->patchEntity($oReboque, $aDataReboque);
                    
                    if (!$that->ResvsVeiculos->save($oReboque)) {
                        if ($bReturnResponse) {
                            return $oResponse
                                ->setMessage('Não foi possível salvar o(s) Reboque(s)! ' . EntityUtil::dumpErrors($oReboque));
                        } else {
                            $that->Flash->error( __('Não foi possível salvar o(s) Reboque(s)! ' . EntityUtil::dumpErrors($oReboque) ) );
                        }
                    }

                }
            }
        }
            
        if ($bReturnResponse)
            return $oResponse
                ->setStatus(200)
                ->setMessage('Reboques gerados.');
        
    }

    private function updateResvsCodigo($iResvsID, $that, $bReturnResponse = false)
    {
        $aResv = array();
        $aResv['resv_codigo'] = UniversalCodigoUtil::codigoResvs($iResvsID);
        
        $oResvs = $that->Resvs->get($iResvsID);
        $oResvs = $that->Resvs->patchEntity($oResvs, $aResv);

        $oResponse = new ResponseUtil();
        if (!$that->Resvs->save($oResvs)) {
            if ($bReturnResponse) {
                return $oResponse
                    ->setMessage('Não foi possível salvar o código RESVS! ' . EntityUtil::dumpErrors($oResvs));
            } else {
                $that->Flash->error( __('Não foi possível salvar o código RESVS! ' . EntityUtil::dumpErrors($oResvs) ) );
                return $that->redirect( $that->referer() );
            }
        }

        if ($bReturnResponse)
            return $oResponse
                ->setStatus(200)
                ->setMessage('Código de RESV gerado com sucesso.');
    }

    public function informarSaida($that, $aData)
    {
        $iOSID = $aData['resvs']['id'];
        $oResv = $that->Resvs->get($iOSID, ['contain'=>'AcessosPessoas']);
        $oResv->data_hora_saida = DateUtil::dateTimeToDB($aData['resvs']['data_hora_saida']);
        
        if ($result = $that->Resvs->save($oResv))
            $oResv->saveAcessoPessoaResv($that);
            return [
                'message' => __('OK'),
                'status'  => 200
            ];

        return [
            'message' => EntityUtil::dumpErrors($oResv),
            'status'  => 406
        ];
    }

    public function saveResvsGeneric($that, $aPost, $bReturnResponse = false)
    {
        $oResponse = new ResponseUtil();
        $aResv = $aPost['resvs'];
        $oResponseBloqueio = PessoaBloqueio::isBloqueada($aResv['pessoa_id']);

        $iGeraOSCadaContainer = @$aResv['operacao']['gerar_os_para_cada_container'];
        $sResvOperacaoDescricao = @$aResv['operacao']['descricao'];
        if (@$aResv['operacao'])
            unset($aResv['operacao']);

        if ($oResponseBloqueio->getStatus() != 200) {
            $that->Flash->error('', ['params' => [
                'title' => $oResponseBloqueio->getTitle(),
                'html' => '<br>' . $oResponseBloqueio->getMessage()
            ]]);

            if ($bReturnResponse)
                return $oResponse;

            return $that->redirect($that->referer());
        }

        $dPesoMaximoVeiculo = LgDbUtil::getFirst('Veiculos', [
            'id' => @$aResv['veiculo_id']
        ]);

        $aResv['peso_maximo'] = @$aResv['peso_maximo'] 
            ? DoubleUtil::toDBUnformat((@$aResv['peso_maximo'] ?: 0))
            : ($dPesoMaximoVeiculo ? $dPesoMaximoVeiculo->peso_maximo : null);
        
        $aResv['peso_pallets'] = DoubleUtil::toDBUnformat((@$aResv['peso_pallets'] ?: 0));
        $aResv['peso_estimado_carga'] = DoubleUtil::toDBUnformat((@$aResv['peso_estimado_carga'] ?: 0));
        
        $aResv['peso_total_bags'] = DoubleUtil::toDBUnformat((@$aResv['peso_total_bags'] ?: 0));

        $aResv['empresa_id']        = Empresa::getEmpresaPadrao();
        $aResv['resv_codigo']       = (isset($aResv['resv_codigo'])) ? $aResv['resv_codigo'] : 0;

        $aResv['data_hora_chegada'] = (isset($aResv['data_hora_chegada']) ) ?
             DateUtil::dateTimeToDB($aResv['data_hora_chegada']) : DateUtil::dateTimeToDB(date('Y-m-d H:i:s'), 'Y-m-d H:i:s', ' ');

        $aResv['data_hora_entrada'] = (isset($aResv['data_hora_entrada']) ) ? 
            DateUtil::dateTimeToDB($aResv['data_hora_entrada']) : null;
        
        $aResv['data_hora_saida']   = (isset($aResv['data_hora_saida']) ) ? 
            DateUtil::dateTimeToDB($aResv['data_hora_saida']) : null;

        $aReboques = (isset($aResv['reboque'])) ? $aResv['reboque'] : [];
        $entity = $that->Resvs->newEntity($aResv);
        if (!$oResvs = $that->Resvs->save($entity)) {            
            $that->Flash->error( __('Houve algum problema ao salvar o Registro de Entrada/Saída! '), ['params' => [
                'html' => EntityUtil::dumpErrors($oResvs)
            ]]);
            
            if ($bReturnResponse)
                return $oResponse;

            return $that->redirect($that->referer());
        }
        
        $oResvs->saveAcessoPessoaResv($that);
        $sType = '';

        if (Resv::isDescarga($oResvs) || Resv::isDesova($oResvs)) {
            $sType = 'descarga';
        }elseif (Resv::isCarga($oResvs)) {
            $sType = 'carga';
        } else {
            $sType = 'descarga_carga';
        }

        $this->updateResvsCodigo($oResvs->id, $that);
        $this->insertReboques($aReboques, $oResvs->id, $that);
        if ($iGeraOSCadaContainer == 1) {
            foreach ($aResv['programacao_containers'] as $oProgramacaoContainer) {
                if ($oProgramacaoContainer['tipo'] == 'VAZIO')
                    continue;

                $this->manageOsGenerator($that, true, $aResv, $oResvs, null,  $sType, false, $oProgramacaoContainer['container_id'], $sResvOperacaoDescricao);
            }
        } else {
            $this->manageOsGenerator($that, true, $aResv, $oResvs, null,  $sType);
        }
    
        if (!$bReturnResponse)
            $_SESSION['focus_to'] = '.numero_doc_entrada_saida';

        if ($bReturnResponse)
            return $oResponse->setStatus(200)->setDataExtra(['resv_id' => $oResvs->id]);


        $that->Flash->success( __('Informação de Entrada salva com sucesso!') );
        return $that->redirect(['action'=>'edit', $oResvs->id ]);
    }


    public function saveResvsDescargaGeneric($that, $documento){
        $doc = $that->DocumentosMercadorias->newEntity();
        $transporte = $that->DocumentosTransportes->find()->where(['id'=>$documento])->first();
        if(!$transporte){
            throw new \Exception("Error Processing Request", 1);
        }

        $aData = array('resv_id'=> $this->id,'documento_transporte_id' => $transporte->id);

        if (LgDbUtil::getFirst('ResvsDocumentosTransportes', $aData)) {
            $that->Flash->warning(__('O Documento de Transporte foi vinculado.'));
            return false;
        }
        
        $oResvsDocumentosTransportes = $that->ResvsDocumentosTransportes->newEntity($aData);
        if ($that->ResvsDocumentosTransportes->save($oResvsDocumentosTransportes)) {
            $doc->generateLoteCodigo( $that,$transporte->id);
            $that->Flash->success(__('The') . ' ' . __('Resv do documento Transporte') . ' ' . __('foi salvo com sucesso!'));
            return true;
        } else {
            $that->Flash->error(__('The') . ' ' . __('Resv do documento Transporte') . ' ' . __('could not be deleted. Please, try again.'));
            return false;
        }
    }

    public static function getPesoLiquido($iResvID)
    {
        $aPesagemVeiculoRegistros = LgDbUtil::getFind('PesagemVeiculoRegistros')
            ->innerJoinWith('PesagemVeiculos.Pesagens')
            ->where([
                'PesagemVeiculoRegistros.pesagem_tipo_id IN' => [1,2],
                'Pesagens.resv_id' => $iResvID
            ])
            ->order([
                'PesagemVeiculoRegistros.pesagem_tipo_id' => 'ASC',
                'PesagemVeiculoRegistros.id' => 'DESC'
            ])
            ->toArray();

            $aPesagemData = [
                'peso_entrada' => 0.0,
                'peso_saida'   => 0.0,
            ];

            foreach ($aPesagemVeiculoRegistros as $oPesagemVeiculoRegistro) {
                if ($oPesagemVeiculoRegistro->pesagem_tipo_id == 1) 
                    $aPesagemData['peso_entrada'] = $oPesagemVeiculoRegistro->peso;
                elseif ($oPesagemVeiculoRegistro->pesagem_tipo_id == 2) 
                    $aPesagemData['peso_saida'] = $oPesagemVeiculoRegistro->peso;
            }

            return $aPesagemData['peso_entrada'] && $aPesagemData['peso_saida'] 
                ? abs($aPesagemData['peso_entrada'] - $aPesagemData['peso_saida']) / 1000
                : 0;
    }

    public function saveResvsCargaGeneric($that, $documento)
    {
        $iResvID = $this->id;
        $bHasError = false;
        $aResvsVinculosTables = [
            2 => [
                'table' => 'LiberacoesDocumentais',
                'bindingKey' => 'id',
                'foreignKey' => 'id',
                'through' => 'ResvsLiberacoesDocumentais',
                'resvKey' => 'resv_id',
                'targetkey' => 'liberacao_documental_id',
            ],
            3 => [
                'table' => 'LiberacaoDocumentalTransportadoras',
                'bindingKey' => 'id',
                'foreignKey' => 'liberacao_documental_id',
                'through' => 'ResvsLiberacoesDocumentais',
                'resvKey' => 'resv_id',
                'targetkey' => 'liberacao_documental_id',
            ],
        ];

        $oResv = LgDbUtil::getByID('Resvs', $iResvID);
        $iRequerPesoEstimado = ParametroGeral::getParametroWithValue('OBRIGA_INFORMAR_PESO_ESTIMADO');

        if (!$oResv->peso_estimado_carga && $iRequerPesoEstimado) {
            $that->Flash->error(__('Falta informar o peso estimado!') );
            return false;
        }

        $iTipoDocumentoToValidate = 0;
        $sDocumentoToValite = $documento;
        if(strpos($documento, '_') !== false){
            $aDocParams = explode('_', $documento);
            $sDocumentoToValite = $aDocParams[1];
            $iTipoDocumentoToValidate = $aDocParams[0];
        }
        $iTipoDocumentoToValidate = $iTipoDocumentoToValidate ?: 2; 
        $aVinculoResvTables = $aResvsVinculosTables[$iTipoDocumentoToValidate];
        
        $oDocumento = null;

        if ($aVinculoResvTables)
            $oDocumento = LgDbUtil::getFirst($aVinculoResvTables['table'], [
                $aVinculoResvTables['bindingKey'] => $sDocumentoToValite
            ]);

        if($oDocumento){

            $sForeignKey = $oDocumento[$aVinculoResvTables['foreignKey']];
            $oRelacao = LgDbUtil::getFirst($aVinculoResvTables['through'], [
                $aVinculoResvTables['resvKey'] => $oResv->id,
                $aVinculoResvTables['targetkey'] => $sForeignKey
            ]);

            if($oRelacao){
                #$that->Flash->error('Documento já vinculado a Resv.');
                return false;
            }
        }

        //Converte de KG para TON
        $dPesoEstimado = $oResv->peso_estimado_carga > 1000 
            ? $oResv->peso_estimado_carga / 1000
            : $oResv->peso_estimado_carga;

        $dPesoLiquido = self::getPesoLiquido($iResvID);

        $dPesoComparacao = $dPesoLiquido ?: $dPesoEstimado;

        $oLiberacaoDocumental = null;
        $oLiberacaoDocumentalTransp = null;
        $iLiberacaoDocumentalID = null;
        $iLiberacaoDocumentalTranspID = null;
        $aLiberacaoItens = [];

        if (strpos($documento, '_') !== false) {
            $aDocParams = explode('_', $documento);
            $documento = $aDocParams[1];
            $iDocumentoTipo = $aDocParams[0];
            
            if ($iDocumentoTipo == 2) {
                $oLiberacaoDocumental = LgDbUtil::get('LiberacoesDocumentais')->find()
                    ->contain(['LiberacoesDocumentaisItensLeftMany'])
                    ->where([
                        'id' => $documento,
                    ])
                    ->first();     
                    
                $oRespose = FaturamentoBaixasManager::validaFaturamentoPeriodoAtual(
                    $oLiberacaoDocumental->id, $oLiberacaoDocumental);
                if($oRespose->getStatus() != 200) 
                    return FlashUtil::doResponse($that, $oRespose);

                if ($iRequerPesoEstimado) {
                    $oResponseSaldoLiberacao = Programacao::checkQtdeLiberacoesProgramacoesResvs($oLiberacaoDocumental);
                    $oResponseSaldos = ExecuteCarga::manageResponseSaldos($dPesoComparacao, $oResponseSaldoLiberacao);
                } else {
                    $oResponseSaldos = (new ResponseUtil())->setStatus(200);
                }

                if ($oResponseSaldos->getStatus() != 200 ) {
                    $bHasError = true;
                    
                    if (Pesagem::getPesagemRegistros($oResv)) {
                        $that->Flash->error('', ['params' => [
                            'html' => $oResponseSaldos->getMessage() . '<br> O documento selecionado <b>foi vinculado por conta que o veículo tem pesagens</b>, mas é necessário informar o setor de Estoque para validar se deve continuar ou não!',
                            'title' => $oResponseSaldos->getTitle()
                        ]]);
                    }else {
                        $that->Flash->error('', ['params' => [
                            'html' => $oResponseSaldos->getMessage() . '<br>  Informar o setor de Estoque!',
                            'title' => $oResponseSaldos->getTitle()
                        ]]);

                        if (!Resv::isAcertoPeso($oResv)) {
                            return false;
                        }
                    }
                }

                $iLiberacaoDocumentalID = $oLiberacaoDocumental->id;
                $iLiberacaoDocumentalTranspID = null;

                foreach ($oLiberacaoDocumental->liberacoes_documentais_itens as $oLiberacaoDocumentalItem) {
                    $aLiberacaoItens[] = [
                        'programacao_liberacao_documental_id' => null,
                        'liberacao_documental_item_id' => $oLiberacaoDocumentalItem->id,
                        'liberacao_documental_transportadora_item_id' => null,
                    ];
                }

            }

            if ($iDocumentoTipo == 3) {
                $oLiberacaoDocumentalTransp = LgDbUtil::get('LiberacaoDocumentalTransportadoras')->find()
                    ->contain([
                        'LiberacoesDocumentais',
                        'LiberacaoDocumentalTransportadoraItens' => [
                            'LiberacoesDocumentaisItens'
                        ]
                    ])
                    ->where([
                        'LiberacaoDocumentalTransportadoras.id' => $documento,
                    ])
                    ->first();

                $oLiberacaoDocumental = $oLiberacaoDocumentalTransp->liberacoes_documental;

                $oRespose = FaturamentoBaixasManager::validaFaturamentoPeriodoAtual(
                    $oLiberacaoDocumental->id, $oLiberacaoDocumental);

                if($oRespose->getStatus() != 200) 
                    return FlashUtil::doResponse($that, $oRespose);

                if ($iRequerPesoEstimado) {
                    $oResponseSaldoLiberacao = Programacao::checkQtdeLiberacoesProgramacoesResvs($oLiberacaoDocumental, $oLiberacaoDocumentalTransp);
                    $oResponseSaldos = ExecuteCarga::manageResponseSaldos($dPesoComparacao, $oResponseSaldoLiberacao);
                } else {
                    $oResponseSaldos = (new ResponseUtil())->setStatus(200);
                }

                if ($oResponseSaldos->getStatus() != 200 ) {
                    $bHasError = true;
                    
                    if (Pesagem::getPesagemRegistros($oResv)) {
                        $that->Flash->error('', ['params' => [
                            'html' => $oResponseSaldos->getMessage() . '<br> O documento selecionado <b>foi vinculado por conta que o veículo tem pesagens</b>, mas é necessário informar o setor de Estoque para validar se deve continuar ou não!',
                            'title' => $oResponseSaldos->getTitle()
                        ]]);
                    }else {
                        $that->Flash->error('', ['params' => [
                            'html' => $oResponseSaldos->getMessage() . '<br>  Informar o setor de Estoque!',
                            'title' => $oResponseSaldos->getTitle()
                        ]]);
                        return false;
                    }
                }


                $iLiberacaoDocumentalID = $oLiberacaoDocumentalTransp->liberacao_documental_id;
                $iLiberacaoDocumentalTranspID = $oLiberacaoDocumentalTransp->id;

                foreach ($oLiberacaoDocumentalTransp->liberacao_documental_transportadora_itens as $oTranspItem) {
                    $aLiberacaoItens[] = [
                        'programacao_liberacao_documental_id' => null,
                        'liberacao_documental_item_id' => $oTranspItem->liberacao_documental_item_id,
                        'liberacao_documental_transportadora_item_id' => $oTranspItem->id,
                    ];
                }
            }
        }else {
            $oLiberacaoDocumental = $that->LiberacoesDocumentais->find()->where(['numero' => $documento])->first();
        }

       
        $oRespose = FaturamentoBaixasManager::validaFaturamentoPeriodoAtual(
            $oLiberacaoDocumental->id, $oLiberacaoDocumental
        );

        if($oRespose->getStatus() != 200) return FlashUtil::doResponse(
            $that, $oRespose
        );


        $oFormacaoCarga       = TableRegistry::get('FormacaoCargas')->find()->where(['id' => $documento])->first();
        $aResvsVinculo         = [];
        $oResv = TableRegistry::getTableLocator()->get('Resvs')->find()->where(['id' => $this->id])->first();

        if (!$oResv) {
            $that->Flash->error(__('Não foi possível encontrar a Resv!') );
            return false;
        }
        
        if ($oFormacaoCarga && $that->request->getData('tipo_documento') == 1 || !$that->request->getData('tipo_documento')) {
            $aResvsVinculo = [
                'registry' => $oFormacaoCarga,
                'relation_table' => 'ResvsFormacaoCargas',
                'name_call' => 'Formação de Carga',
                'fk_1' => [
                    'name' => 'formacao_carga_id',
                    'value' => $oFormacaoCarga->id
                ],
                'fk_2' => [
                    'name' => '',
                    'value' => ''
                ]
            ];

            $oResvsFormacaoCargas = TableRegistry::getTableLocator()->get('ResvsFormacaoCargas')->find()
                ->where([
                    'formacao_carga_id' =>$oFormacaoCarga->id
                ])
                ->first();
            
            if ($oFormacaoCarga->transportadora_id != $oResv->transportador_id) {
                $that->Flash->error(__('A transportadora dessa Formação de Carga é diferente da transportadora vinculada à RESV!') );
                return false;
            }
        
            if ($oResvsFormacaoCargas) {
                $that->Flash->error(__('Essa Formação de Carga já está vinculada à outra RESV! Código da RESV #'.$oResvsFormacaoCargas->resv_id.'') );
                return false;
            }

        }elseif (($oLiberacaoDocumental || $oLiberacaoDocumentalTransp) && in_array($that->request->getData('tipo_documento'), [2,3]) || !$that->request->getData('tipo_documento')) {
            $aResvsVinculo = [
                'registry' => $oLiberacaoDocumental ? $oLiberacaoDocumental : $oLiberacaoDocumentalTransp,
                'relation_table' => 'ResvsLiberacoesDocumentais',
                'name_call' => 'Liberação Documental',
                'fk_1' => [
                    'name' => 'liberacao_documental_id',
                    'value' => $iLiberacaoDocumentalID
                ],
                'fk_2' => [
                    'name' => 'liberacao_documental_transportadora_id',
                    'value' => $iLiberacaoDocumentalTranspID
                ]
            ];
        }
        
        if (!$aResvsVinculo && !$oLiberacaoDocumental)
            throw new \Exception("Error Processing Request", 1);
        
        $aData = array(
            'resv_id' => $this->id, 
            $aResvsVinculo['fk_1']['name'] => $aResvsVinculo['fk_1']['value'],
        );

        if ($aResvsVinculo['fk_2']['name'] && $aResvsVinculo['fk_2']['value']) {
            $aData[$aResvsVinculo['fk_2']['name']] = $aResvsVinculo['fk_2']['value'];
        }

        $oResvsVinculo = LgDbUtil::get($aResvsVinculo['relation_table'])->newEntity($aData);

        if ($oResult = LgDbUtil::get($aResvsVinculo['relation_table'])->save($oResvsVinculo)) {

            //Salva Itens da Liberação documental (por transp ou não)
            foreach ($aLiberacaoItens as $aLiberacaoItem) {
                $aLiberacaoItem['resv_liberacao_documental_id'] = $oResult->id;
                LgDbUtil::saveNew('ResvLiberacaoDocumentalItens', $aLiberacaoItem);
            }

            if (!$bHasError)
                $that->Flash->success(__('The') . ' ' . __($aResvsVinculo['name_call']) . ' ' . __('foi salvo com sucesso!'));

            return true;
        } else {
            $that->Flash->error(__('The') . ' ' . __($aResvsVinculo['name_call']) . ' ' . __('não pode ser criada. ') . EntityUtil::dumpErrors($oResvsVinculo) );
            return false;
        }
    }

    public function saveAcessoPessoaResv($that){

        if(isset($this->data_hora_entrada)){
            $entity = $this->acessos_pessoa;

            if(!isset($this->acessos_pessoa)){
                $entity = LgDbUtil::getFirst('AcessosPessoas',[
                    'resv_id' => $this->id
                ]);
            }

            if(empty($entity)){
                $entity = LgDbUtil::get('AcessosPessoas')->newEntity([
                    'resv_id' => $this->id,
                    'empresa_id'=>$this->empresa_id,
                    'pessoa_id'=>$this->pessoa_id,
                    'data_hora_entrada' => $this->data_hora_entrada
                ]);
            }
            
            if($this->data_hora_saida){
                $entity->data_hora_saida = $this->data_hora_saida;
            }
            LgDbUtil::get('AcessosPessoas')->save($entity);
        }
    }

    public static function getContainersDocumento($iNumeroDocumento, $iOperacaoID)
    {
        $aContainers = [];

        switch ($iOperacaoID) {
            case 1: // DESCARGA

                $oDocumentoTransporteEntity = TableRegistry::getTableLocator()->get('DocumentosTransportes');
                $oDocumentoTransporte = $oDocumentoTransporteEntity->find()
                    ->where(['DocumentosTransportes.id' => $iNumeroDocumento])
                    ->contain(['DocumentosMercadoriasMany' => ['DocumentosMercadoriasItens' => ['ItemContainers']]])
                    ->first();

                foreach ($oDocumentoTransporte->documentos_mercadorias as $oDocumentoMercadoria) {
                    if ($oDocumentoMercadoria->documentos_mercadorias_itens) {
                        foreach ($oDocumentoMercadoria->documentos_mercadorias_itens as $oDocumentoMercadoriaItem) {
                            if ($oDocumentoMercadoriaItem) {
                                foreach ($oDocumentoMercadoriaItem->item_containers as $oItemContainer) {
                                    $aContainers[$oItemContainer->container_id] = $oItemContainer->container_id;
                                }
                            }
                        }
                    }
                }

                if ($aContainers) {
                    $oContainersEntity = TableRegistry::getTableLocator()->get('Containers');
                    foreach ($aContainers as $key => $value) {
                        $oContainer = $oContainersEntity->find()->where(['id' => $key])->first();
                        $aContainers[$key] = $oContainer->numero;
                    }
                }

                break;

            case 2: // CARGA

                $oLiberacaoDocumental = LgDbUtil::getFind('LiberacoesDocumentais')
                    ->contain(['LiberacoesDocumentaisItensLeftMany' => ['Containers']])
                    ->where(['LiberacoesDocumentais.id' => explode('_', $iNumeroDocumento)[1]])
                    ->first();

                $aContainers = array_reduce($oLiberacaoDocumental->liberacoes_documentais_itens, function($carry, $oLiberacaoDocItem) {
                    if ($oLiberacaoDocItem->container_id)
                        $carry[$oLiberacaoDocItem->container_id] = @$oLiberacaoDocItem->container->numero;
                        
                    return $carry;
                });

                $aContainers = $aContainers ?: [];
                break;

            case EntityUtil::getIdByParams('Operacoes', 'descricao', 'Desova Direta Documento'):

                $oDocumentoTransporteEntity = TableRegistry::getTableLocator()->get('DocumentosTransportes');
                $oDocumentoTransporte = $oDocumentoTransporteEntity->find()
                    ->where(['DocumentosTransportes.id' => $iNumeroDocumento])
                    ->contain(['DocumentosMercadoriasMany' => ['DocumentosMercadoriasItens' => ['ItemContainers']]])
                    ->first();

                foreach ($oDocumentoTransporte->documentos_mercadorias as $oDocumentoMercadoria) {
                    if ($oDocumentoMercadoria->documentos_mercadorias_itens) {
                        foreach ($oDocumentoMercadoria->documentos_mercadorias_itens as $oDocumentoMercadoriaItem) {
                            if ($oDocumentoMercadoriaItem) {
                                foreach ($oDocumentoMercadoriaItem->item_containers as $oItemContainer) {
                                    $aContainers[$oItemContainer->container_id] = $oItemContainer->container_id;
                                }
                            }
                        }
                    }
                }

                if ($aContainers) {
                    $oContainersEntity = TableRegistry::getTableLocator()->get('Containers');
                    foreach ($aContainers as $key => $value) {
                        $oContainer = $oContainersEntity->find()->where(['id' => $key])->first();
                        $aContainers[$key] = $oContainer->numero;
                    }
                }

                break;

            case EntityUtil::getIdByParams('Operacoes', 'descricao', 'Desova - Canal Vermelho (via Doc.)'):

                $oDocumentoTransporteEntity = TableRegistry::getTableLocator()->get('DocumentosTransportes');
                $oDocumentoTransporte = $oDocumentoTransporteEntity->find()
                    ->where(['DocumentosTransportes.id' => $iNumeroDocumento])
                    ->contain(['DocumentosMercadoriasMany' => ['DocumentosMercadoriasItens' => ['ItemContainers']]])
                    ->first();

                foreach ($oDocumentoTransporte->documentos_mercadorias as $oDocumentoMercadoria) {
                    if ($oDocumentoMercadoria->documentos_mercadorias_itens) {
                        foreach ($oDocumentoMercadoria->documentos_mercadorias_itens as $oDocumentoMercadoriaItem) {
                            if ($oDocumentoMercadoriaItem) {
                                foreach ($oDocumentoMercadoriaItem->item_containers as $oItemContainer) {
                                    $aContainers[$oItemContainer->container_id] = $oItemContainer->container_id;
                                }
                            }
                        }
                    }
                }

                if ($aContainers) {
                    $oContainersEntity = TableRegistry::getTableLocator()->get('Containers');
                    foreach ($aContainers as $key => $value) {
                        $oContainer = $oContainersEntity->find()->where(['id' => $key])->first();
                        $aContainers[$key] = $oContainer->numero;
                    }
                }

                break;

            case EntityUtil::getIdByParams('Operacoes', 'descricao', 'Desova Investigativa (Via Doc.)'):

                $oDocumentoTransporteEntity = TableRegistry::getTableLocator()->get('DocumentosTransportes');
                $oDocumentoTransporte = $oDocumentoTransporteEntity->find()
                    ->where(['DocumentosTransportes.id' => $iNumeroDocumento])
                    ->contain(['DocumentosMercadoriasMany' => ['DocumentosMercadoriasItens' => ['ItemContainers']]])
                    ->first();

                foreach ($oDocumentoTransporte->documentos_mercadorias as $oDocumentoMercadoria) {
                    if ($oDocumentoMercadoria->documentos_mercadorias_itens) {
                        foreach ($oDocumentoMercadoria->documentos_mercadorias_itens as $oDocumentoMercadoriaItem) {
                            if ($oDocumentoMercadoriaItem) {
                                foreach ($oDocumentoMercadoriaItem->item_containers as $oItemContainer) {
                                    $aContainers[$oItemContainer->container_id] = $oItemContainer->container_id;
                                }
                            }
                        }
                    }
                }

                if ($aContainers) {
                    $oContainersEntity = TableRegistry::getTableLocator()->get('Containers');
                    foreach ($aContainers as $key => $value) {
                        $oContainer = $oContainersEntity->find()->where(['id' => $key])->first();
                        $aContainers[$key] = $oContainer->numero;
                    }
                }

                break;
            
            default:
                break;
        }

        return $aContainers;
    }
    
    public static function autoExecutaOs($oResv)
    {
        if (!$oResv)
            return false;

        $oOrdemServico = LgDbUtil::getFirst('OrdemServicos', [
            'resv_id' => $oResv->id
        ]);

        if (!$oOrdemServico)
            return false;

        $aParams = ($x = ParametroGeral::getParametroWithValue('LOGINFO_AUTO_EXECUCAO_OS')) 
            ? (json_decode($x, true) ?: []) 
            : [];

        $aPermiteGerarAuto = [];
        
        foreach ($aParams as $aParam) {
            if ($aParam['ordem_servico_tipo_id'] == $oOrdemServico->ordem_servico_tipo_id && $aParam['ativo']) {
                $aPermiteGerarAuto = $aParam;
            }
        }

        if ($aPermiteGerarAuto)
            return $aPermiteGerarAuto;

        return [];
    }

    public static function isPesagemAvulsa($oResv = null, $iOperacaoID = null) 
    {
        $iOperacaoID = $oResv ? $oResv->operacao_id : $iOperacaoID;
        return in_array($iOperacaoID, [7]);
    }

    public static function isDescarga($oResv = null, $iOperacaoID = null) 
    {
        $iOperacaoID = $oResv ? $oResv->operacao_id : $iOperacaoID;
        return in_array($iOperacaoID, [1, 5, 12, EntityUtil::getIdByParams('Operacoes', 'descricao', 'Desova Direta Documento'), EntityUtil::getIdByParams('Operacoes', 'descricao', 'Desova - Canal Vermelho (via Doc.)'), EntityUtil::getIdByParams('Operacoes', 'descricao', 'Desova Investigativa (Via Doc.)')]);
    }

    public static function isDesova($oResv = null, $iOperacaoID = null) 
    {
        $iOperacaoID = $oResv ? $oResv->operacao_id : $iOperacaoID;
        return in_array($iOperacaoID, [12, 13, EntityUtil::getIdByParams('Operacoes', 'descricao', 'Desova Direta Documento'), EntityUtil::getIdByParams('Operacoes', 'descricao', 'Desova - Canal Vermelho (via Doc.)'), EntityUtil::getIdByParams('Operacoes', 'descricao', 'Desova Investigativa (Via Doc.)')]);
    }

    public static function isCarga($oResv = null, $iOperacaoID = null) 
    {
        $iOperacaoID = $oResv ? $oResv->operacao_id : $iOperacaoID;
        return in_array($iOperacaoID, [2, 6, 10]);
    }

    public static function isCarousel($oResv = null, $iOperacaoID = null) 
    {
        $iOperacaoID = $oResv ? $oResv->operacao_id : $iOperacaoID;
        
        if (isset($oResv->operacao))
            $oOperacao = $oResv->operacao;
        else
            $oOperacao = LgDbUtil::getByID('Operacoes', $iOperacaoID);

        return $oOperacao->is_carrossel;
    }

    public static function isDescargaCarga($oResv = null, $iOperacaoID = null) 
    {
        $iOperacaoID = $oResv ? $oResv->operacao_id : $iOperacaoID;
        return in_array($iOperacaoID, [8]);
    }

    public static function isAcertoPeso($oResv = null, $iOperacaoID = null) 
    {
        $iOperacaoID = $oResv ? $oResv->operacao_id : $iOperacaoID;
        return in_array($iOperacaoID, [5, 6]);
    }

    public static function isAcertoPesoCarga($oResv = null, $iOperacaoID = null) 
    {
        $iOperacaoID = $oResv ? $oResv->operacao_id : $iOperacaoID;
        
        return $iOperacaoID == 6;
    }

    public static function naoFechaPesagemAuto() 
    { 
        $naoFechaPesagemAuto = ParametroGeral::getParametroWithValue('PARAM_NAO_FECHA_PESAGEM_AUTO') == 1 ? true : false;
        return $naoFechaPesagemAuto;
    }

    public function getFirstProduto(){

        $oProduto = null;

        if(!empty($this->documentos_transportes_index)){
            $oItem = LgDbUtil::getFind('DocumentosMercadoriasItens')
                ->contain([
                    'DocumentosMercadorias',
                    'Produtos'
                ])
                ->where([
                    'DocumentosMercadorias.documento_transporte_id' 
                        => $this->documentos_transportes_index[0]->id
                ])
                ->first();

            @$oProduto = $oItem->produto;

        }


        if(!empty($this->liberacoes_documentais_index)){
            $oItem = LgDbUtil::getFind('LiberacoesDocumentaisItens')
                ->contain([
                    'Produtos'
                ])
                ->where([
                    'LiberacoesDocumentaisItens.liberacao_documental_id' 
                        => $this->liberacoes_documentais_index[0]->id
                ])
                ->first();

            @$oProduto = $oItem->produto;
        }

        return isset($oProduto) ?
           $oProduto->codigo. ' - ' .$oProduto->descricao: '';
    }


    public function getFirstDocumento(){

        if(!empty($this->documentos_transportes_index)){
            return @$this->documentos_transportes_index[0]->numero;
        }


        if(!empty($this->liberacoes_documentais_index)){
            return @$this->liberacoes_documentais_index[0]->numero;
        }

        return '';
    }

    public function getFirstCliente(){

        if(!empty($this->documentos_transportes_index)){
            return @$this->documentos_transportes_index[1]->documentos_mercadoria->cliente->descricao;
        }
        
        if(!empty($this->liberacoes_documentais_index)){
            return @$this->liberacoes_documentais_index[0]->empresa->descricao;
        }

        if(!empty($this->resvs_containers)){
            return @$this->resvs_containers[0]->empresa->descricao;
        }

        return '';
    }
    
    public function saveResvsGenericResponse($that, $aPost)
    {
        $oResponse = new ResponseUtil();
        $aResv = $aPost['resvs'];
        $oResponseBloqueio = PessoaBloqueio::isBloqueada($aResv['pessoa_id']);

        if ($oResponseBloqueio->getStatus() != 200)
            return $oResponseBloqueio;

        $iGeraOSCadaContainer = @$aResv['operacao']['gerar_os_para_cada_container'];
        $sResvOperacaoDescricao = @$aResv['operacao']['descricao'];
        if (@$aResv['operacao'])
            unset($aResv['operacao']);

        $dPesoMaximoVeiculo = LgDbUtil::getFirst('Veiculos', [
            'id' => @$aResv['veiculo_id']
        ]);

        $aResv['peso_maximo'] = @$aResv['peso_maximo'] 
            ? DoubleUtil::toDBUnformat((@$aResv['peso_maximo'] ?: 0))
            : ($dPesoMaximoVeiculo ? $dPesoMaximoVeiculo->peso_maximo : null);
        
        $aResv['peso_pallets'] = DoubleUtil::toDBUnformat((@$aResv['peso_pallets'] ?: 0));
        $aResv['peso_estimado_carga'] = DoubleUtil::toDBUnformat((@$aResv['peso_estimado_carga'] ?: 0));

        $aResv['peso_total_bags'] = DoubleUtil::toDBUnformat((@$aResv['peso_total_bags'] ?: 0));

        $aResv['empresa_id']        = Empresa::getEmpresaPadrao();
        $aResv['resv_codigo']       = (isset($aResv['resv_codigo'])) ? $aResv['resv_codigo'] : 0;

        $aResv['data_hora_chegada'] = (isset($aResv['data_hora_chegada']) ) ?
             DateUtil::dateTimeToDB($aResv['data_hora_chegada']) : DateUtil::dateTimeToDB(date('Y-m-d H:i:s'), 'Y-m-d H:i:s', ' ');

        $aResv['data_hora_entrada'] = (isset($aResv['data_hora_entrada']) ) ? 
            DateUtil::dateTimeToDB($aResv['data_hora_entrada']) : null;
        
        $aResv['data_hora_saida']   = (isset($aResv['data_hora_saida']) ) ? 
            DateUtil::dateTimeToDB($aResv['data_hora_saida']) : null;

        $aReboques = (isset($aResv['reboque'])) ? $aResv['reboque'] : [];
        $entity = LgDbUtil::get('Resvs')->newEntity($aResv);
        
        if (!$oResvs = LgDbUtil::get('Resvs')->save($entity))
            return $oResponse
                ->setMessage('Houve algum problema ao salvar o Registro de Entrada/Saída! ' . EntityUtil::dumpErrors($entity));
        
        $oResvs->saveAcessoPessoaResv($that);
        $sType = '';

        if (Resv::isDescarga($oResvs)) {
            $sType = 'descarga';
        } elseif (Resv::isCarga($oResvs)) {
            $sType = 'carga';
        } else {
            $sType = 'descarga_carga';
        }

        $oReturnUpdateCodigo = $this->updateResvsCodigo($oResvs->id, $that, true);

        if ($oReturnUpdateCodigo->getStatus() != 200)
            return $oReturnUpdateCodigo;

        $oReturnInsertReboques = $this->insertReboques($aReboques, $oResvs->id, $that, true);

        if ($oReturnInsertReboques->getStatus() != 200)
            return $oReturnInsertReboques;

        $aViculos = null;
        if (isset($aData['doc_transp_ids']))
            $aViculos = $aData['doc_transp_ids'];

        if ($iGeraOSCadaContainer == 1) {
            foreach ($aResv['programacao_containers'] as $oProgramacaoContainer) {
                $oReturnManageOs = $this->manageOsGenerator($that, true, $aResv, $oResvs, $aViculos,  $sType, true, $oProgramacaoContainer['container_id'], $sResvOperacaoDescricao);
                if ($oReturnManageOs->getStatus() != 200)
                    return $oReturnManageOs;
            }
        } else {
            $oReturnManageOs = $this->manageOsGenerator($that, true, $aResv, $oResvs, $aViculos,  $sType, true);
        }

        if ($oReturnManageOs->getStatus() != 200)
            return $oReturnManageOs;

        return $oResponse->setStatus(200)->setDataExtra(['resv_id' => $oResvs->id]);
    }

    public static function gerarResvGeneric($that, $iProgramacaoID, $sDataHoraVistoria = null)
    {
        $oProgramacao = LgDbUtil::getFind('Programacoes')
            ->contain([
                'ProgramacaoLiberacaoDocumentais' => [
                    'ProgramacaoLiberacaoDocumentalItens'
                ],
                'ProgramacaoContainers' => [
                    'ProgramacaoContainerLacres'
                ],
                'ProgramacaoDocumentoTransportes',
                'ProgramacaoDriveEspacos',
                'Operacoes'
            ])
            ->where([
                'Programacoes.id' => $iProgramacaoID
            ])->first();
        
        $oResponse = new ResponseUtil();

        if ($oProgramacao->resv_id)
            return $oResponse
                ->setMessage('Você não pode gerar novamente uma RESV para a mesma programação!');

        $bVeiculoInside = Veiculo::checkVeiculoInOpenResv($oProgramacao->veiculo_id);

        if ($bVeiculoInside)
            return $oResponse
                ->setMessage('Este veículo já está com RESV (#' . $bVeiculoInside->id . ') aberta!');

        $bExisteContainer = EntradaSaidaContainer::checkExistsContainers($oProgramacao);
        if ($bExisteContainer) {
            return $oResponse
                ->setMessage('Erro ao gerar RESV! O Container ' . $bExisteContainer . ' já está no terminal!');
        }

        // $oResponseCheckSaldo = Programacao::checkSaldoLiberacoes($this, $oProgramacao->id);

        // if ($oResponseCheckSaldo->getStatus() != 200)
        //     return $this->redirect($this->referer());

        // $oResponseCheckPeriodoTransp = Programacao::checkPeriodoTransportadoras($oProgramacao);

        // if ($oResponseCheckPeriodoTransp->getStatus() != 200)
        //     return $oResponse
        //         ->setMessage($oResponseCheckPeriodoTransp->getMessage() . '<br><br>  <b>Informar o setor de Estoque!</b>');
        
        $aData = ObjectUtil::getAsArray($oProgramacao, true);
        $aData['resv_codigo'] = '-';
        $aData['transportador_id'] = $oProgramacao->transportadora_id;
        $aData['retroativo'] = 0;
        unset($aData['programacao_liberacao_documentais']);
        $aData['data_hora_chegada'] = $sDataHoraVistoria ? $sDataHoraVistoria : date('Y-m-d') . 'T' . date('H:i');
        $aData['doc_transp_ids'] = [];
        $aData['grade_horario_id'] = @$oProgramacao->grade_horario_id ?: null;
        if ($oProgramacao->programacao_documento_transportes) {
            foreach ($oProgramacao->programacao_documento_transportes as $oProgramacaoDocTransporte) {
                $aData['doc_transp_ids'][] = $oProgramacaoDocTransporte->documento_transporte_id;
            }
        }
        
        $Resv = new Resv();
        $oResponse = $Resv->saveResvsGenericResponse($that, ['resvs' => $aData]);

        if ($oResponse->getStatus() != 200)
            return $oResponse;

        $iResvID = $oResponse->getDataExtra()['resv_id'];
        
        $oProgramacaoAttResv = LgDbUtil::getByID('Programacoes', $iProgramacaoID);
        $oProgramacaoAttResv->resv_id = $iResvID;
        LgDbUtil::save('Programacoes', $oProgramacaoAttResv);
        
        $oResvAtt = LgDbUtil::getByID('Resvs', $iResvID);
        $oResvAtt->programacao_id = $iProgramacaoID;
        LgDbUtil::save('Resvs', $oResvAtt);
        
        foreach ($oProgramacao->programacao_liberacao_documentais as $oProgramacaoLiberacaoDocumental) {
            $aData = ObjectUtil::getAsObject($oProgramacaoLiberacaoDocumental, true);
            $aData['resv_id'] = $iResvID;

            $oResvsLiberacoesDocumentais = LgDbUtil::saveNew('ResvsLiberacoesDocumentais', $aData);

            if (!$oResvsLiberacoesDocumentais)
                continue;

            foreach ($oProgramacaoLiberacaoDocumental->programacao_liberacao_documental_itens as $oProgramacaoLiberacaoDocumentalItem) {
                $aData = ObjectUtil::getAsObject($oProgramacaoLiberacaoDocumentalItem, true);
                $aData['resv_id'] = $iResvID;
                $aData['resv_liberacao_documental_id'] = $oResvsLiberacoesDocumentais->id;
    
                $oResvLiberacaoDocumentalItem = LgDbUtil::saveNew('ResvLiberacaoDocumentalItens', $aData);
            }

        }
        
        foreach ($oProgramacao->programacao_containers as $oProgramacaoContainer) {
            $aData = ObjectUtil::getAsObject($oProgramacaoContainer, true);
            $aData['resv_id'] = $iResvID;

            $aData['container_forma_uso_id'] = VistoriaItem::getDataContainerContainerFormaUso($aData);

            $oResvsContainer = LgDbUtil::saveNew('ResvsContainers', $aData);

            if (!$oResvsContainer)
                continue;

            foreach ($oProgramacaoContainer->programacao_container_lacres as $oProgramacaoContainerLacre) {
                $aData = ObjectUtil::getAsObject($oProgramacaoContainerLacre, true);
                $aData['resv_id'] = $iResvID;
                $aData['resv_container_id'] = $oResvsContainer->id;
    
                $oResvContainerLacre = LgDbUtil::saveNew('ResvContainerLacres', $aData);
            }

        }

        foreach ($oProgramacao->programacao_documento_transportes as $oProgramacaoDocumentoTransporte) {
            $aData = ObjectUtil::getAsObject($oProgramacaoDocumentoTransporte, true);
            $aData['resv_id'] = $iResvID;

            $oResvsDocumentosTransporte = LgDbUtil::saveNew('ResvsDocumentosTransportes', $aData);

            if (!$oResvsDocumentosTransporte)
                continue;
        }

        foreach ($oProgramacao->programacao_drive_espacos as $oProgramacaoDriveEspaco) {
            $aData = ObjectUtil::getAsObject($oProgramacaoDriveEspaco, true);
            $aData['resv_id'] = $iResvID;

            $oProgramacaoDriveEspaco = LgDbUtil::saveNew('ResvDriveEspacos', $aData);

            if (!$oProgramacaoDriveEspaco)
                continue;
        }

        $aProgramacaoReboques = LgDbUtil::getAll('ProgramacaoVeiculos', [
            'programacao_id' => $iProgramacaoID
        ], [
            'sequencia_veiculo' => 'ASC'
        ]);

        foreach ($aProgramacaoReboques as $oProgramacaoReboque) {
            $aData = ObjectUtil::getAsObject($oProgramacaoReboque, true);
            $aData['resv_id'] = $iResvID;
            LgDbUtil::saveNew('ResvsVeiculos', $aData);
        }

        if (!$oProgramacao->programacao_documento_transportes && Operacao::checkGeraDocAutomaticoByProgramacaoId($oProgramacao->id)) {
            $oResponse = Programacao::managerDocumentoEntradaGenerico($oProgramacao->id);
            if ($oResponse->getStatus() != 200)
                return $oResponse;
        }

        if ($iProgramacaoID) {
            $oResponse = PlanejamentoMovimentacaoInterna::setByResv($iResvID, $iProgramacaoID);
            if ($oResponse->getStatus() != 200) {
                FlashUtil::doResponse($this, $oResponse);
                return $this->redirect($this->referer());
            }
        }

        $oProgramacaoUpdated = LgDbUtil::getFind('Programacoes')
            ->contain([
                'Veiculos'
            ])
            ->where([
                'Programacoes.id' => $iProgramacaoID
            ])->first();

        return $oResponse
            ->setStatus(200)
            ->setMessage('RESV #' . $iResvID . ' gerada com sucesso!')
            ->setDataExtra(['resv_id' => $iResvID, 'oProgramacao' => $oProgramacaoUpdated]);
    }

    public static function registraHorarios($iResvId, $sType, $sDate = null)
    {
        $oResponse = new ResponseUtil();

        if (!is_array($iResvId))
            $iResvId = [$iResvId];

        if (!$iResvId || !$sType)
            return $oResponse
                ->setMessage('Faltam parâmetros para completar esta ação.');     

        $aWhere = ['Resvs.id IN' => $iResvId];

        switch ($sType) {
            case 'entrada':
                $aWhere += ['data_hora_saida IS NULL'];
                break;
            case 'saida':
                $aWhere += ['data_hora_entrada IS NOT NULL'];

                $oResponseSaida = self::podeDarSaida($iResvId, $aWhere);

                if ($oResponseSaida->getStatus() != 200)
                    return $oResponseSaida;

                break;
            case 'chegada':
                $aWhere += ['data_hora_entrada IS NULL'];
                $aWhere += ['data_hora_sainda IS NULL'];
                break;
            default:
                break;
        }

        $iParamObrigaLacreArmadorCargaVazio = ParametroGeral::getParameterByUniqueName('PARAM_OBRIGA_LACRE_ARMADOR_CARGA_VAZIO');
        if ($iParamObrigaLacreArmadorCargaVazio->valor == 1 && $sType == 'saida') {
            $oResponse = self::verifyLacreArmadorCargaVazio($aWhere);
            if ($oResponse->getStatus() != 200)
                return $oResponse;
        }

        $aResvs = LgDbUtil::getFind('Resvs')
            ->where($aWhere)
            ->toArray();
        
        foreach ($aResvs as $oResv) {
            switch ($sType) {
                case 'entrada':
                    $oResv->data_hora_entrada = DateUtil::dateTimeToDB($sDate ? $sDate : date('Y-m-d H:i'));
                    break;
                case 'saida':
                    $oResv->data_hora_saida = DateUtil::dateTimeToDB($sDate ? $sDate : date('Y-m-d H:i'));
                    break;
                case 'chegada':
                    $oResv->data_hora_chegada = DateUtil::dateTimeToDB($sDate ? $sDate : date('Y-m-d H:i'));
                    break;
                default:
                    break;
            }

            LgDbUtil::save('Resvs', $oResv, false);
            $oResv->saveAcessoPessoaResv(null);
        }

        return (new ResponseUtil())
            ->setStatus(200)
            ->setMessage(ucfirst($sType) . ' gerada com sucesso!');

    }

    public static function podeDarSaida($aResvIDs, $aWhere, $iOs = null)
    {
        $oResponse = new ResponseUtil;
        $iBloqueiaCarga = ParametroGeral::getParametroWithValue('PARAM_BLOQUEIA_SAIDA_RESV_SEM_EXEC_OS_CARGA') ?: 0;
        $iBloqueiaDescarga = ParametroGeral::getParametroWithValue('PARAM_BLOQUEIA_SAIDA_RESV_SEM_EXEC_OS_DESCARGA') ?: 0;
        $sExtraText = '<br><br><i>Favor, avise o operador da Execução das Ordens de Serviço!<i/>';

        if (!$iBloqueiaCarga && !$iBloqueiaDescarga) 
            return $oResponse
                ->setStatus(200);  

        $aResvs = LgDbUtil::getFind('Resvs')
            ->contain([
                'OrdemServicos' => [
                    'OrdemServicoItens',
                    'OrdemServicoCarregamentos'
                ]
            ])
            ->where($aWhere)
            ->toArray();
        
        foreach ($aResvs as $oResv) {

            $oOrdemServicoCargaAux = [];
            $aOrdemServicoCarregamentosAux = [];

            $oOrdemServicoDescargaAux = [];
            $aOrdemServicoItensAux = [];

            $oOrdemServico = @$oResv->ordem_servicos[0];
            $aOrdemServicos = $oResv->ordem_servicos;
            $aOrdemServicoItens = @$oOrdemServico->ordem_servico_itens;
            $aOrdemServicoCarregamentos = @$oOrdemServico->ordem_servico_carregamentos;

            foreach ($aOrdemServicos as $oOS) {
                //Pega a OS de Carga/Descarga corretamente
                if ($oOS->ordem_servico_tipo_id == 2) {
                    $oOrdemServicoCargaAux = $oOS;                     
                    $aOrdemServicoCarregamentosAux = $oOrdemServicoCargaAux->ordem_servico_carregamentos;
                }else {
                    $oOrdemServicoDescargaAux = $oOS;                     
                    $aOrdemServicoItensAux = $oOrdemServicoDescargaAux->ordem_servico_itens;
                }
            }

            if (Resv::isDescarga($oResv) && !$oOrdemServico->cancelada && $iBloqueiaDescarga && (!$oOrdemServico->data_hora_fim && !$aOrdemServicoItens)) {

                return $oResponse
                    ->setMessage('A <b>OS #' . $oOrdemServico->id . '</b> da <b>RESV #' . $oResv->id . '</b>, não foi <b style="color:red">EXECUTADA</b> e <b style="color:red">FINALIZADA</b> corretamente!'.$sExtraText);
                
            }else if (Resv::isCarga($oResv) && !$oOrdemServico->cancelada && $iBloqueiaCarga && (!$oOrdemServico->data_hora_fim && !$aOrdemServicoCarregamentos)) {
                
                return $oResponse
                    ->setMessage('A <b>OS #' . $oOrdemServico->id . '</b> da <b>RESV #' . $oResv->id . '</b>, não foi <b style="color:red">EXECUTADA</b> e <b style="color:red">FINALIZADA</b> corretamente!'.$sExtraText);

            }else if (Resv::isDescargaCarga($oResv) && ($iBloqueiaCarga || $iBloqueiaDescarga) ){

                $bValidaCarga = true;
                $bValidaDescarga = true;
                if ($iOs && $oOrdemServicoCargaAux->id == $iOs) {
                    $bValidaDescarga = false;
                    $bValidaCarga = true;
                } else if ($iOs && $oOrdemServicoDescargaAux->id == $iOs) {
                    $bValidaDescarga = true;
                    $bValidaCarga = false;
                }

                if ($iBloqueiaCarga && $bValidaCarga && !$oOrdemServicoCargaAux->cancelada && !@$oOrdemServicoCargaAux->data_hora_fim && !$aOrdemServicoCarregamentosAux)
                    return $oResponse
                        ->setMessage('A <b>OS #' . $oOrdemServicoCargaAux->id . '</b> da <b>RESV #' . $oResv->id . '</b>, não foi <b style="color:red">EXECUTADA</b> e <b style="color:red">FINALIZADA</b> corretamente!'.$sExtraText);
                    
                if ($iBloqueiaDescarga && $bValidaDescarga && !$oOrdemServicoDescargaAux->cancelada && !@$oOrdemServicoDescargaAux->data_hora_fim && !$aOrdemServicoItensAux)
                    return $oResponse
                        ->setMessage('A <b>OS #' . $oOrdemServicoDescargaAux->id . '</b> da <b>RESV #' . $oResv->id . '</b>, não foi <b style="color:red">EXECUTADA</b> e <b style="color:red">FINALIZADA</b> corretamente!'.$sExtraText);
            }
        }

        return $oResponse
            ->setStatus(200);        
    }

    private static function verifyLacreArmadorCargaVazio($aWhere)
    {
        $oResponse = new ResponseUtil();

        $aResvs = LgDbUtil::getFind('Resvs')
            ->contain(['ResvsContainers' => ['Containers', 'ResvContainerLacres' => ['LacreTipos']]])
            ->where($aWhere)
            ->toArray();

        if (!$aResvs)
            return $oResponse->setStatus(200);

        foreach ($aResvs as $oResv) {

            if ($oResv->operacao_id != EntityUtil::getIdByParams('Operacoes', 'descricao', 'Carga'))
                continue;

            if (!$oResv->resvs_containers)
                continue;

            foreach ($oResv->resvs_containers as $oResvContainer) {
                
                if ($oResvContainer->tipo != 'VAZIO')
                    continue;

                if (!$oResvContainer->resv_container_lacres)
                    return $oResponse
                        ->setStatus(400)
                        ->setTitle('Ops!')
                        ->setMessage('Parece que o container "' . (@$oResvContainer->container->numero ?: 'SEM NUMERO') . '" não possui Lacres!');

                $bLacreArmador = false;
                foreach ($oResvContainer->resv_container_lacres as $oResvContainerLacre) {
                    
                    if ($oResvContainerLacre->lacre_tipo->descricao == 'Armador')
                        $bLacreArmador = true;

                }

                if (!$bLacreArmador)
                    return $oResponse
                        ->setStatus(400)
                        ->setTitle('Ops!')
                        ->setMessage('Parece que o container "' . (@$oResvContainer->container->numero ?: 'SEM NUMERO') . '" não possui Lacre do tipo Armador!');

            }

        }

        return $oResponse->setStatus(200);
    }

    public static function getFilters()
    {
        $aModais = LgdbUtil::get('Modais')
            ->find('list', ['keyField' => 'id', 'valueField' => 'descricao'])
            ->select( ['id', 'descricao'] );
        
        return [
            [
                'name'  => 'resv',
                'divClass' => 'col-lg-3',
                'label' => 'Resv',
                'table' => [
                    'className' => 'Resvs',
                    'field'     => 'id',
                    'operacao'  => 'igual'
                ]
            ],
            [
                'name'  => 'container',
                'divClass' => 'col-lg-3',
                'label' => 'Container',
                'table' => [
                    'className' => 'ResvsContainers.Containers',
                    'field'     => 'numero',
                    'operacao'  => 'contem'
                ]
            ],
            [
                'name'  => 'operacao',
                'divClass' => 'col-lg-3',
                'label' => 'Operação',
                'table' => [
                    'className' => 'Operacoes',
                    'field'     => 'descricao',
                    'operacao'  => 'contem'
                ]
            ],
            [
                'name'  => 'placa',
                'divClass' => 'col-lg-3',
                'label' => 'Placa',
                'table' => [
                    'className' => 'Veiculos',
                    'field'     => 'descricao',
                    'operacao'  => 'contem'
                ]
            ],
            [
                'name'  => 'transportadora',
                'divClass' => 'col-lg-3',
                'label' => 'Transportadora',
                'table' => [
                    'className' => 'LeftTransportadoras',
                    'field'     => 'razao_social',
                    'operacao'  => 'contem'
                ]
            ],
            [
                'name'  => 'motorista',
                'divClass' => 'col-lg-3',
                'label' => 'Motorista',
                'table' => [
                    'className' => 'LeftPessoas',
                    'field'     => 'descricao',
                    'operacao'  => 'contem'
                ]
            ],
            [
                'name'  => 'nota',
                'divClass' => 'col-lg-3',
                'label' => 'Nota Vinculada',
                'table' => [
                    'className' => 'ResvsDocumentosTransportes.DocumentosTransportes',
                    'field'     => 'numero',
                    'operacao'  => 'contem'
                ]
            ],
            [
                'name'  => 'data_hora_chegada',
                'divClass' => 'col-lg-2',
                'label' => 'Data Chegada',
                'table' => [
                    'className' => 'Resvs',
                    'field'     => 'data_hora_chegada',
                    'operacao'  => 'contem',
                    'type'      => 'date'
                ]
            ],
            [
                'name'  => 'data_hora_entrada',
                'divClass' => 'col-lg-2',
                'label' => 'Data Entrada',
                'table' => [
                    'className' => 'Resvs',
                    'field'     => 'data_hora_entrada',
                    'operacao'  => 'contem',
                    'type'      => 'date'
                ]
            ],
            [
                'name'  => 'data_hora_saida',
                'divClass' => 'col-lg-2',
                'label' => 'Data Saída',
                'table' => [
                    'className' => 'Resvs',
                    'field'     => 'data_hora_saida',
                    'operacao'  => 'contem',
                    'type'      => 'date'
                ]
            ],
            [
                'name'  => 'select_modal',
                'divClass' => 'col-lg-2',
                'label' => 'Modais',
                'table' => [
                    'className' => 'Modais',
                    'field'     => 'id',
                    'operacao'  => 'in',
                    'type'      => 'select',
                    'options'   => $aModais
                ]
            ],
        ];
    }

    public static function verifyDocInResv($iTransporteID) 
    {
        $oResponse = new ResponseUtil();

        $oResvsDocumentosTransportes = LgDbUtil::getFind('ResvsDocumentosTransportes')
            ->contain('Resvs')
            ->where([
                'ResvsDocumentosTransportes.documento_transporte_id' => $iTransporteID,
            ])
            ->first();

        if ($oResvsDocumentosTransportes && $oResvsDocumentosTransportes->resv->situacao_resv_id != EntityUtil::getIdByParams('SituacaoResvs', 'descricao', 'Cancelada'))
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('Impossível Editar ou Remover. Parece que esse documento já está vínculado a RESV: ' . $oResvsDocumentosTransportes->resv_id);

        return $oResponse
            ->setStatus(200);
    }

    public static function getLabelByModal()
    {
        $aLabels = [
            EntityUtil::getIdByParams('Modais', 'descricao', 'Áereo')       => 'Aeronave',
            EntityUtil::getIdByParams('Modais', 'descricao', 'Rodoviário')  => 'Placa (cavalo)',
            EntityUtil::getIdByParams('Modais', 'descricao', 'Marítimo')    => 'Navio',
            EntityUtil::getIdByParams('Modais', 'descricao', 'Ferroviário') => 'Vagão'
        ];

        return $aLabels;
    }
    
    public static function getLastResvOpenByUsuario($oUsuarioVinculos)
    {
        $oResponse = new ResponseUtil();

        $oResv = LgDbUtil::getFind('Resvs')
            ->where([
                'Resvs.veiculo_id'         => $oUsuarioVinculos['veiculo']->veiculo_id,
                'Resvs.pessoa_id'          => $oUsuarioVinculos['motorista']->pessoa_id,
                'Resvs.data_hora_saida IS' => null
            ])
            ->order(['Resvs.id' => 'DESC'])
            ->first();

        if (!$oResv)
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('Não existe Resv em aberto para essa operação!');

        return $oResponse
            ->setStatus(200)
            ->setDataExtra($oResv);
    }

    public static function getPesagemResvsImprimirTicket($iResvID)
    {
        $oResv = LgDbUtil::getFind('Resvs')
            ->contain([
                'Operacoes',
                'ResvDriveEspacos' => [
                    'DriveEspacos'
                ],
                'OrdemServicosLeft' => [
                    'OrdemServicoTipos',
                    'OrdemServicoItens' => [
                        'DocumentosMercadoriasItens' => [
                            'DocumentosMercadorias' => [
                                'DocumentosTransportes'
                            ]
                        ],
                        'EstoqueEnderecos'
                    ],
                    'OrdemServicoCarregamentos' => [
                        'Produtos',
                        'LiberacoesDocumentais' => [
                            'LiberacaoDocumentalItemDados',
                            'LiberacoesDocumentaisItensInnerMany'
                        ]
                    ]
                ],
                'Veiculos',
                'ResvsVeiculos' => [
                    'Veiculos'
                ],
                'Pessoas',
                'Transportadoras'
            ])
            ->where([
                'Resvs.id' => $iResvID
            ])
            ->first();
        return $oResv;
    }
}
