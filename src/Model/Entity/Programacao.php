<?php
namespace App\Model\Entity;

use App\RegraNegocio\AutoExecucaoOrdemServico\AutoExecuteUtil;
use App\RegraNegocio\AutoExecucaoOrdemServico\ExecuteCarga;
use App\RegraNegocio\Container\LiberacaoAutomaticaContainer;
use App\RegraNegocio\DocumentosMercadorias\DocumentosMercadoriasManage;
use App\RegraNegocio\Integracoes\HandlerIntegracao;
use App\RegraNegocio\Faturamento\FaturamentoBaixasManager;
use App\Util\ArrayUtil;
use App\Util\DateUtil;
use App\Util\DoubleUtil;
use App\Util\EntityUtil;
use App\Util\FlashUtil;
use App\Util\LgDbUtil;
use App\Util\ObjectUtil;
use App\Util\ResponseUtil;
use App\Util\SessionUtil;
use Cake\Database\Expression\IdentifierExpression;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use Cake\Utility\Inflector;
use DocumentacaoEntrada;

/**
 * Programacao Entity
 *
 * @property int $id
 * @property \Cake\I18n\Time|null $data_hora_programada
 * @property \Cake\I18n\Time|null $data_hora_chegada
 * @property int $operacao_id
 * @property int $veiculo_id
 * @property int|null $transportadora_id
 * @property int $pessoa_id
 * @property int $modal_id
 * @property int $portaria_id
 * @property int|null $embalagem_id
 * @property int|null $resv_id
 * @property float|null $peso_maximo
 * @property float|null $peso_estimado_carga
 * @property float|null $peso_pallets
 * @property string $observacao
 *
 * @property \App\Model\Entity\Operacao $operacao
 * @property \App\Model\Entity\Veiculo $veiculo
 * @property \App\Model\Entity\Transportadora $transportadora
 * @property \App\Model\Entity\Pessoa $pessoa
 * @property \App\Model\Entity\Modal $modal
 * @property \App\Model\Entity\Portaria $portaria
 * @property \App\Model\Entity\Embalagem $embalagem
 * @property \App\Model\Entity\Resv[] $resvs
 * @property \App\Model\Entity\ProgramacaoLiberacaoDocumental[] $programacao_liberacao_documentais
 * @property \App\Model\Entity\ProgramacaoVeiculo[] $programacao_veiculos
 */
class Programacao extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
     /* Default fields
        
        'data_hora_programada' => true,
        'data_hora_chegada' => true,
        'operacao_id' => true,
        'veiculo_id' => true,
        'transportadora_id' => true,
        'pessoa_id' => true,
        'modal_id' => true,
        'portaria_id' => true,
        'embalagem_id' => true,
        'resv_id' => true,
        'peso_maximo' => true,
        'peso_estimado_carga' => true,
        'peso_pallets' => true,
        'observacao' => true,
        'operacao' => true,
        'veiculo' => true,
        'transportadora' => true,
        'pessoa' => true,
        'modal' => true,
        'portaria' => true,
        'embalagem' => true,
        'resvs' => true,
        'programacao_liberacao_documentais' => true,
        'programacao_veiculos' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function saveProgramacaoGeneric($that, $aPost, $iDocumentoid = null, $sOperacao = '', $bReturn = false)
    {
        $aProgramacao = $aPost['programacao'];
        $oResponseBloqueio = PessoaBloqueio::isBloqueada($aProgramacao['pessoa_id']);

        if ($oResponseBloqueio->getStatus() != 200) {
            $that->Flash->error('', ['params' => [
                'title' => $oResponseBloqueio->getTitle(),
                'html' => '<br>' . $oResponseBloqueio->getMessage()
            ]]);
            return $that->redirect($that->referer());
        }

        $dPesoMaximoVeiculo = LgDbUtil::getFirst('Veiculos', [
            'id' => @$aProgramacao['veiculo_id']
        ]);

        $aProgramacao['observacao'] = @$aProgramacao['observacao'] ?: @$aPost['observacao'];
        
        $aProgramacao['peso_maximo'] = @$aProgramacao['peso_maximo'] 
            ? DoubleUtil::toDBUnformat((@$aProgramacao['peso_maximo'] ?: 0))
            : ($dPesoMaximoVeiculo ? $dPesoMaximoVeiculo->peso_maximo : null);
        
        $aProgramacao['peso_pallets'] = DoubleUtil::toDBUnformat((@$aProgramacao['peso_pallets'] ?: 0));
        $aProgramacao['peso_estimado_carga'] = DoubleUtil::toDBUnformat((@$aProgramacao['peso_estimado_carga'] ?: 0));

        $aProgramacao['empresa_id']        = Empresa::getEmpresaPadrao();
        $aProgramacao['resv_codigo']       = (isset($aProgramacao['resv_codigo'])) ? $aProgramacao['resv_codigo'] : 0;

        $aProgramacao['data_hora_programada'] = ($aProgramacao['data_hora_programada']) 
            ? DateUtil::dateTimeToDB($aProgramacao['data_hora_programada']) 
            : null;

        $aProgramacao['data_hora_chegada'] = ($aProgramacao['data_hora_chegada']) 
            ? DateUtil::dateTimeToDB($aProgramacao['data_hora_chegada']) 
            : null;

        $aProgramacao['data_hora_origem'] = ($aProgramacao['data_hora_origem']) 
            ? DateUtil::dateTimeToDB($aProgramacao['data_hora_origem']) 
            : null;

        $aReboques = (isset($aProgramacao['reboque'])) ? $aProgramacao['reboque'] : [];
        $entity = LgDbUtil::get('Programacoes')->newEntity($aProgramacao);
        
        if (!$oProgramacao = LgDbUtil::get('Programacoes')->save($entity)) {            
            $that->Flash->error( __('Houve algum problema ao salvar o Registro de Programação! ' . EntityUtil::dumpErrors($oProgramacao)) );
            return $that->redirect($that->referer());
        }

        // $sType = '';

        // if (Resv::isDescarga($oProgramacao)) {
        //     $sType = 'descarga';
        // }elseif (Resv::isCarga($oProgramacao)) {
        //     $sType = 'carga';
        // }

        self::insertReboques($aReboques, $oProgramacao->id, $that);

        if($bReturn){
            return ['oProgramacao' => $oProgramacao, 'return' => true];
        }
        
        $_SESSION['focus_to'] = '.numero_doc_entrada_saida';

        $that->Flash->success( __('Informação de Programação salva!') );
        return $that->redirect(['action' => 'edit', $oProgramacao->id ]);
    }

    private static function insertReboques($aReboques, $iProgramacaoID, $that) 
    {
        $i = 1;
        
        if ($aReboques)
            foreach ($aReboques as $aReboque) {
                
                if ($aReboque['veiculo_id']) {
                    
                    $aDataReboque = array(
                        'sequencia_veiculo' => $i++,
                        'veiculo_id'        => $aReboque['veiculo_id'],
                        'programacao_id'    => $iProgramacaoID
                    );
                    
                    $aDataReboque = (isset($aReboque['id'])) ? $aDataReboque + ['id' => $aReboque['id'] ] : $aDataReboque; 
                    
                    $oReboque = $that->setEntity('ProgramacaoVeiculos', $aDataReboque );
                    
                    $oReboque = LgDbUtil::get('ProgramacaoVeiculos')->patchEntity($oReboque, $aDataReboque);
                    
                    if (!LgDbUtil::get('ProgramacaoVeiculos')->save($oReboque)) {
                        $that->Flash->error( __('Não foi possível salvar o(s) Reboque(s)! ' . EntityUtil::dumpErrors($oReboque) ) );
                    }

                }
            }
    }

    public static function checkQtdeLiberacoesProgramacoesResvs($oLiberacaoDocumental, $oLiberacaoDocumentalTransp = null)
    {
        $oResponse = new ResponseUtil();

        $dQtdeTotalUtilizadoLiberacaoDocumentalTransportadora = null;
        $dQtdeTotalLiberadoLiberacaoDocumentalTransportadora = null;
        $sNumeroLiberacao = null;

        $dQtdeTotalUtilizadoLiberacaoDocumental = self::getTotalUtilizadoLiberacaoDocumental($oLiberacaoDocumental);
        $dQtdeTotalLiberadoLiberacaoDocumental = self::getTotalLiberadoLiberacaoDocumental($oLiberacaoDocumental);

        if ($oLiberacaoDocumentalTransp) {
            $sNumeroLiberacao = $oLiberacaoDocumentalTransp->numero_liberacao;
            $dQtdeTotalUtilizadoLiberacaoDocumentalTransportadora = self::getTotalUtilizadoLiberacaoDocumentalTransportadora($oLiberacaoDocumentalTransp);
            $dQtdeTotalLiberadoLiberacaoDocumentalTransportadora = self::getTotalLiberadoLiberacaoDocumentalTransportadora($oLiberacaoDocumentalTransp);
        }

        return $oResponse
            ->setStatus(200)
            ->setDataExtra([
                'qtde_utilizado_liberacao_documental' => $dQtdeTotalUtilizadoLiberacaoDocumental,
                'qtde_liberado_liberacao_documental' => $dQtdeTotalLiberadoLiberacaoDocumental,
                'qtde_utilizado_liberacao_documental_transportadora' => $dQtdeTotalUtilizadoLiberacaoDocumentalTransportadora,
                'qtde_liberado_liberacao_documental_transportadora' => $dQtdeTotalLiberadoLiberacaoDocumentalTransportadora,
                'conhecimento'     => $oLiberacaoDocumental->numero,
                'numero_liberacao' => $sNumeroLiberacao,
            ]);
    }

    public static function getTotalLiberadoLiberacaoDocumental($oLiberacaoDocumental)
    {
        $oLiberacaoDocumentalItem = LgDbUtil::getFind('LiberacoesDocumentaisItens')
            ->where([
                'liberacao_documental_id' => $oLiberacaoDocumental->id
            ])
            ->first();

        if (!$oLiberacaoDocumentalItem)
            return 0.0;

        return $oLiberacaoDocumentalItem->quantidade_liberada;
    }

    public static function getTotalUtilizadoLiberacaoDocumental($oLiberacaoDocumental)
    {
        // $aResvs = LgDbUtil::getFind('Resvs')
        //     ->contain([
        //         'ResvsLiberacoesDocumentais' => function($q) use($oLiberacaoDocumental) {
        //             return $q->where([
        //                 'ResvsLiberacoesDocumentais.liberacao_documental_id' => $oLiberacaoDocumental->id
        //             ]);
        //         },
        //         'Veiculos',
        //         'Pessoas',
        //         'Transportadoras',
        //         'OrdemServicos' => [
        //             'OrdemServicoCarregamentos'
        //         ],
        //         'Pesagens' => [
        //             'PesagemVeiculos' => [
        //                 'PesagemVeiculoRegistros' => function($q) {
        //                     return $q
        //                         ->where([
        //                             'PesagemVeiculoRegistros.pesagem_tipo_id IN' => [1,2]
        //                         ])
        //                         ->order([
        //                             'PesagemVeiculoRegistros.pesagem_tipo_id' => 'ASC',
        //                             'PesagemVeiculoRegistros.id' => 'DESC'
        //                         ]);
        //                 }
        //             ]
        //         ]
        //     ])
        //     ->matching('ResvsLiberacoesDocumentais', function($q) use($oLiberacaoDocumental) {
        //         return $q->where([
        //             'ResvsLiberacoesDocumentais.liberacao_documental_id' => $oLiberacaoDocumental->id
        //         ]);
        //     })
        //     ->matching('OrdemServicos.OrdemServicoCarregamentos', function($q) use($oLiberacaoDocumental) {
        //         return $q->where([
        //             'OrdemServicoCarregamentos.liberacao_documental_id' => $oLiberacaoDocumental->id
        //         ]);
        //     })
        //     ->where()
        //     ->toArray();

        $aResvs = LiberacaoDocumentalTransportadora::queryResvs($oLiberacaoDocumental->id);

        foreach ($aResvs as $oResv) {
            $oResv->peso_carga = 0;
            $oResv->peso_liquido = 0;
            $oResv->peso_entrada = 0;
            $oResv->peso_saida = 0;
            $oResv->ordem_servicos = [];
            $aPesagemData = [
                'peso_entrada' => 0.0,
                'peso_saida'   => 0.0,
            ];

            foreach ($oResv->resvs_liberacoes_documentais as $oResvLiberacaoDocumental) {
                $oResv->ordem_servicos[0] = $oResvLiberacaoDocumental->ordem_servico;
                if (isset($oResvLiberacaoDocumental->ordem_servico->ordem_servico_carregamentos)) {
                    foreach ($oResvLiberacaoDocumental->ordem_servico->ordem_servico_carregamentos as $oOrdemServicoCarregamento) {
                        $oResv->peso_carga += $oOrdemServicoCarregamento->quantidade_carregada * 1000;
                    }
                }
            }


            foreach ($oResv->pesagens as $oPesagem) {
                foreach ($oPesagem->pesagem_veiculos as $oPesagemVeiculo) {
                    foreach ($oPesagemVeiculo->pesagem_veiculo_registros as $oPesagemVeiculoRegistro) {
                        if ($oPesagemVeiculoRegistro->pesagem_tipo_id == 1) 
                            $aPesagemData['peso_entrada'] = $oPesagemVeiculoRegistro->peso;
                        elseif ($oPesagemVeiculoRegistro->pesagem_tipo_id == 2) 
                            $aPesagemData['peso_saida'] = $oPesagemVeiculoRegistro->peso;
                    }
                    $oResv->peso_liquido += $aPesagemData['peso_entrada'] && $aPesagemData['peso_saida'] 
                        ? abs($aPesagemData['peso_entrada'] - $aPesagemData['peso_saida']) / 1000
                        : 0;
                }
            }
        }

        $dTotalCarregado = 0.0;
        
        foreach ($aResvs as $oResv) {

            if ($oResv->peso_carga)
                $dTotalCarregado += $oResv->peso_carga / 1000;
            elseif ($oResv->peso_liquido)
                $dTotalCarregado += $oResv->peso_liquido;
            else 
                $dTotalCarregado += $oResv->peso_estimado_carga;
        }

        if (!$dTotalCarregado)
            return 0.0;

        return $dTotalCarregado;
    }

    public static function getTotalLiberadoLiberacaoDocumentalTransportadora($oLiberacaoDocumentalTransportadora)
    {
        $dQtde = @LgDbUtil::getFind('LiberacaoDocumentalTransportadoras')
            ->select([
                'qtde' => LgDbUtil::getFind('LiberacaoDocumentalTransportadoraItens')->func()->sum('LiberacaoDocumentalTransportadoraItens.quantidade_liberada')
            ])
            ->leftJoinWith('LiberacaoDocumentalTransportadoraItens')
            ->where([
                'LiberacaoDocumentalTransportadoras.liberacao_documental_id' => $oLiberacaoDocumentalTransportadora->liberacao_documental_id,
                'LiberacaoDocumentalTransportadoras.id' => $oLiberacaoDocumentalTransportadora->id,
            ])
            ->limit(1)
            ->first()
            ->qtde;
            
        if (!$dQtde)
            return 0.0;

        return $dQtde;
    }

    public static function getTotalUtilizadoLiberacaoDocumentalTransportadora($oLiberacaoDocumentalTransportadora)
    {
        $aResvs = LiberacaoDocumentalTransportadora::getCarregamentoPorVeiculos($oLiberacaoDocumentalTransportadora->id);
        
        $dTotalCarregado = 0.0;
        
        foreach ($aResvs as $oResv) {

            if ($oResv->peso_carga)
                $dTotalCarregado += $oResv->peso_carga / 1000;
            elseif ($oResv->peso_liquido)
                $dTotalCarregado += $oResv->peso_liquido;
            else 
                $dTotalCarregado += $oResv->peso_estimado_carga;
        }

        if (!$dTotalCarregado)
            return 0.0;

        return $dTotalCarregado;
    }

    public static function checkPeriodoTransportadoras($oProgramacao)
    {
        $oResponse = new ResponseUtil;
        $sDataHoraProgramada = $oProgramacao->data_hora_programada->format('Y-m-d H:i:s');
        $sDataHoraChegada = $oProgramacao->data_hora_chegada->format('Y-m-d H:i:s');

        if (!$oProgramacao->programacao_liberacao_documentais && !$oProgramacao->programacao_containers
            && $oProgramacao->operacao->valida_documento)
            return $oResponse->setMessage('Não há Liberações cadastradas!');
        
        foreach ($oProgramacao->programacao_liberacao_documentais as $oProgramacaoLiberacaoDocumental) {
            $iLiberacaoDocumentalTranspID = $oProgramacaoLiberacaoDocumental->liberacao_documental_transportadora_id;

            if ($iLiberacaoDocumentalTranspID) {
                $oResponse = self::checkPeriodoTransportadora(
                    $iLiberacaoDocumentalTranspID, 
                    $oProgramacao->transportadora_id, 
                    $sDataHoraProgramada, 
                    $sDataHoraChegada
                );
            }elseif ($oProgramacaoLiberacaoDocumental->liberacao_documental_id){
                $oResponse = self::checkLiberacaoDocumentalPorTransp(
                    $oProgramacaoLiberacaoDocumental->liberacao_documental_id
                );
            }

            if ($oResponse->getStatus() != 200)
                return $oResponse;
        }
        
        return $oResponse->setStatus(200);
    }

    public static function checkLiberacaoDocumentalPorTransp($iLiberacaoDocumentalID)
    {
        $oResponse = new ResponseUtil;
        $aLiberacaoDocumentais = LgDbUtil::getFind('LiberacoesDocumentais')
            ->contain(['Clientes'])
            ->where([
                'LiberacoesDocumentais.id' => $iLiberacaoDocumentalID,
                'libera_por_transportadora' => 0
            ])
            ->limit(1)
            ->toArray();

        if (!$aLiberacaoDocumentais)
            return $oResponse->setMessage('A Liberação Documental (#'.$iLiberacaoDocumentalID.') vinculada, é somente liberada por Transportadora!');

        return $oResponse->setStatus(200);
    }

    public static function checkPeriodoTransportadora($iLiberacaoDocumentalTranspID, $iTransportadoraID, $sDataHoraProgramada, $sDataHoraChegada)
    {
        $oResponse = new ResponseUtil;
        $aLiberacaoDocumentalTransportadoras = LgDbUtil::getFind('LiberacaoDocumentalTransportadoras')
            ->select(LgDbUtil::get('LiberacaoDocumentalTransportadoras'))
            ->select(LgDbUtil::get('LiberacoesDocumentais'))
            ->select([
                'programacao_periodo_dentro' => LgDbUtil::getFind('LiberacaoDocumentalTransportadoras')->newExpr()->addCase(
                    [
                        LgDbUtil::getFind('LiberacaoDocumentalTransportadoras')->newExpr()->between(
                            '"' . $sDataHoraProgramada . '"',
                            new IdentifierExpression('LiberacaoDocumentalTransportadoras.data_inicio_retirada'),
                            new IdentifierExpression('LiberacaoDocumentalTransportadoras.data_fim_retirada')
                        )
                    ],
                    ['1', '0']
                ),
                'chegada_periodo_dentro' => LgDbUtil::getFind('LiberacaoDocumentalTransportadoras')->newExpr()->addCase(
                    [
                        LgDbUtil::getFind('LiberacaoDocumentalTransportadoras')->newExpr()->between(
                            '"' . $sDataHoraChegada . '"',
                            new IdentifierExpression('LiberacaoDocumentalTransportadoras.data_inicio_retirada'),
                            new IdentifierExpression('LiberacaoDocumentalTransportadoras.data_fim_retirada')
                        )
                    ],
                    ['1', '0']
                )
            ])
            ->contain(['LiberacoesDocumentais'])
            ->where([
                'LiberacaoDocumentalTransportadoras.id' => $iLiberacaoDocumentalTranspID,
                'LiberacaoDocumentalTransportadoras.transportadora_id IS' => $iTransportadoraID,
                'LiberacoesDocumentais.libera_por_transportadora' => 1
            ])
            ->limit(1)
            ->toArray();

        if (!$aLiberacaoDocumentalTransportadoras)
            return $oResponse->setMessage('A liberação selecionada, não está mais com essa transportadora, ou documento de Liberação Fiscal não é mais Liberado por Transportadoras!');

        foreach ($aLiberacaoDocumentalTransportadoras as $oLiberacaoDocumentalTransp) {
            if ($oLiberacaoDocumentalTransp->programacao_periodo_dentro == '0' || $oLiberacaoDocumentalTransp->chegada_periodo_dentro == '0'){
                return $oResponse->setMessage('A Liberação atual não está mais dentro do período permitido dessa Programação!');
            }
        }

        return $oResponse->setStatus(200);
    }

    public static function checkSaldoLiberacoes($oThat, $iProgramacaoID)
    {
        $oResponse = (new ResponseUtil)->setStatus(200);

        if (!$iProgramacaoID)
            return $oResponse;

        $oProgramacao = LgDbUtil::getFind('Programacoes')
            ->contain([
                'ProgramacaoLiberacaoDocumentais' => [
                    'LiberacaoDocumentalTransportadoras',
                    'LiberacoesDocumentais'
                ],
                'ProgramacaoContainers'
            ])
            ->where([
                'Programacoes.id' => $iProgramacaoID
            ])->first();

        if (!Resv::isCarga($oProgramacao) || $oProgramacao->resv_id || $oProgramacao->programacao_containers)
            return $oResponse;
        
        $oLiberacaoDocumentalTransp = null;
        $dPesoEstimado = $oProgramacao->peso_estimado_carga;
        $iRequerPesoEstimado = ParametroGeral::getParametroWithValue('OBRIGA_INFORMAR_PESO_ESTIMADO');

        if (!$dPesoEstimado && $iRequerPesoEstimado) {
            $oThat->Flash->warning('Favor informar o Peso Estimado da Carga!');
            return $oResponse->setStatus(400);
        }

        if (!$iRequerPesoEstimado)
            return $oResponse
                ->setMessage('Parâmetro de Obrigação de Peso Estimado está desligado, liberando para prosseguir!')
                ->setStatus(200);

        foreach ($oProgramacao->programacao_liberacao_documentais as $oProgramacaoLiberacaoDocumental) {
            $oLiberacaoDocumentalTransp = $oProgramacaoLiberacaoDocumental->liberacao_documental_transportadora ?: null;
            $oLiberacaoDocumental = $oProgramacaoLiberacaoDocumental->liberacoes_documental;

            $oResponseSaldoLiberacao = self::checkQtdeLiberacoesProgramacoesResvs($oLiberacaoDocumental, $oLiberacaoDocumentalTransp);
            $oResponseSaldos = ExecuteCarga::manageResponseSaldos($dPesoEstimado, $oResponseSaldoLiberacao);

            if ($oResponseSaldos->getStatus() != 200) {
                $oThat->Flash->error('', ['params' => [
                    'html' => $oResponseSaldos->getMessage() . '<br>  Informar o setor de Estoque!',
                    'title' => $oResponseSaldos->getTitle()
                ]]);
                return $oResponseSaldos;
            }
        }

        return $oResponse;
    }

    public static function saveProgramacaoCargaGeneric($that, $documento, $oProgramacao)
    {
        $iRequerPesoEstimado = ParametroGeral::getParametroWithValue('OBRIGA_INFORMAR_PESO_ESTIMADO');

        if (!$oProgramacao->peso_estimado_carga && $iRequerPesoEstimado) {
            $that->Flash->error(__('Falta informar o peso estimado!') );
            return false;
        }

        //Converte de KG para TON
        $dPesoEstimado = $oProgramacao->peso_estimado_carga > 1000 
            ? $oProgramacao->peso_estimado_carga / 1000
            : $oProgramacao->peso_estimado_carga;

        if (!$oProgramacao) {
            $that->Flash->error(__('Não foi possível encontrar a Programação!') );
            return false;
        }

        $aVinculosTables = [
            2 => [
                'table' => 'LiberacoesDocumentais',
                'bindingKey' => 'id',
                'foreignKey' => 'id',
                'through' => 'ProgramacaoLiberacaoDocumentais',
                'key' => 'programacao_id',
                'targetkey' => 'liberacao_documental_id',
            ],
            3 => [
                'table' => 'LiberacaoDocumentalTransportadoras',
                'bindingKey' => 'id',
                'foreignKey' => 'liberacao_documental_id',
                'through' => 'ProgramacaoLiberacaoDocumentais',
                'key' => 'programacao_id',
                'targetkey' => 'liberacao_documental_id',
            ],
        ];

        $sDocumentoToValite = $documento;
        if(strpos($documento, '_') !== false){
            $aDocParams = explode('_', $documento);
            $sDocumentoToValite = $aDocParams[1];
            $iTipoDocumentoToValidate = $aDocParams[0];
        }
        $iTipoDocumentoToValidate = $iTipoDocumentoToValidate ?: 2; 
        $aVinculoDocTables = $aVinculosTables[$iTipoDocumentoToValidate];

        $oDocumento = LgDbUtil::getFirst($aVinculoDocTables['table'], [
            $aVinculoDocTables['bindingKey'] => $sDocumentoToValite
        ]);

        if($oDocumento){

            $sForeignKey = $oDocumento[$aVinculoDocTables['foreignKey']];
            $oRelacao = LgDbUtil::getFirst($aVinculoDocTables['through'], [
                $aVinculoDocTables['key'] => $oProgramacao->id,
                $aVinculoDocTables['targetkey'] => $sForeignKey
            ]);

            if($oRelacao){
                #$that->Flash->error('Documento já vinculado a Programação.');
                return false;
            }
        }
        
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
                    $oLiberacaoDocumental->id);
                if($oRespose->getStatus() != 200) 
                    return FlashUtil::doResponse($that, $oRespose);  

                $oResponseSaldoLiberacao = self::checkQtdeLiberacoesProgramacoesResvs($oLiberacaoDocumental);
                $oResponseSaldos = ExecuteCarga::manageResponseSaldos($dPesoEstimado, $oResponseSaldoLiberacao);

                if ($oResponseSaldos->getStatus() != 200) {
                    $that->Flash->error('', ['params' => [
                        'html' => $oResponseSaldos->getMessage() . '<br>  Informar o setor de Estoque!',
                        'title' => $oResponseSaldos->getTitle()
                    ]]);
                    return false;
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
                        'LiberacaoDocumentalTransportadoraItens' => ['LiberacoesDocumentaisItens']
                    ])
                    ->where([
                        'LiberacaoDocumentalTransportadoras.id' => $documento,
                    ])
                    ->first();

                $oLiberacaoDocumental = $oLiberacaoDocumentalTransp->liberacoes_documental;

                $oRespose = FaturamentoBaixasManager::validaFaturamentoPeriodoAtual(
                    $oLiberacaoDocumental->id);
                if($oRespose->getStatus() != 200) 
                    return FlashUtil::doResponse($that, $oRespose);  
                
                $oResponseSaldoLiberacao = self::checkQtdeLiberacoesProgramacoesResvs($oLiberacaoDocumental, $oLiberacaoDocumentalTransp);
                $oResponseSaldos = ExecuteCarga::manageResponseSaldos($dPesoEstimado, $oResponseSaldoLiberacao);

                if ($oResponseSaldos->getStatus() != 200) {
                    $that->Flash->error('', ['params' => [
                        'html' => $oResponseSaldos->getMessage() . '<br>  Informar o setor de Estoque!',
                        'title' => $oResponseSaldos->getTitle()
                    ]]);
                    return false;
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
            $oLiberacaoDocumental->id);
        if($oRespose->getStatus() != 200) 
            return FlashUtil::doResponse($that, $oRespose);   

        $aProgramacaoVinculo = [];
        if (($oLiberacaoDocumental || $oLiberacaoDocumentalTransp) && in_array($that->request->getData('tipo_documento'), [2,3]) || !$that->request->getData('tipo_documento')) {
            $aProgramacaoVinculo = [
                'registry' => $oLiberacaoDocumental ? $oLiberacaoDocumental : $oLiberacaoDocumentalTransp,
                'relation_table' => 'ProgramacaoLiberacaoDocumentais',
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

        if (!$aProgramacaoVinculo && !$oLiberacaoDocumental)
            throw new \Exception("Error Processing Request", 1);
        
        $aData = array(
            'programacao_id' => $oProgramacao->id, 
            $aProgramacaoVinculo['fk_1']['name'] => $aProgramacaoVinculo['fk_1']['value'],
            $aProgramacaoVinculo['fk_2']['name'] => $aProgramacaoVinculo['fk_2']['value'],
        );

        $oProgramacaoVinculo = LgDbUtil::get($aProgramacaoVinculo['relation_table'])->newEntity($aData);
        
        if ($oResult = LgDbUtil::get($aProgramacaoVinculo['relation_table'])->save($oProgramacaoVinculo)) {

            //Salva Itens da Liberação documental (por transp ou não)
            foreach ($aLiberacaoItens as $aLiberacaoItem) {
                $aLiberacaoItem['programacao_liberacao_documental_id'] = $oResult->id;
                LgDbUtil::saveNew('ProgramacaoLiberacaoDocumentalItens', $aLiberacaoItem);
            }

            $that->Flash->success(__('The') . ' ' . __($aProgramacaoVinculo['name_call']) . ' ' . __('foi salvo com sucesso!'));
            return true;
        } else {
            $that->Flash->error(__('The') . ' ' . __($aProgramacaoVinculo['name_call']) . ' ' . __('não pode ser criada. ') . EntityUtil::dumpErrors($oProgramacaoVinculo) );
            return false;
        }
    }

    public static function canFecharResv($oProgramacao)
    {
        if (!$oProgramacao->resv_id)
            return false;

        $oResv = LgDbUtil::getByID('Resvs', $oProgramacao->resv_id);
        
        $aPesagens = Pesagem::getPesagemRegistros($oResv);

        if ($aPesagens)
            return false;

        return true;
    }

    public static function canGenerateResv($oProgramacao)
    {
        if ($oProgramacao->resv_id)
            return false;
        
        $aData = ObjectUtil::getAsArray($oProgramacao, true);
        $aData['resv_codigo'] = '-';
        $aData['transportador_id'] = $oProgramacao->transportadora_id;
        $aData['retroativo'] = 0;
        unset($aData['pessoa']);
        unset($aData['operacao']);
        unset($aData['programacao_liberacao_documentais']);
        unset($aData['programacao_containers']);

        $oResvEntity = LgDbUtil::get('Resvs')->newEntity($aData);

        if (isset($oProgramacao->programacao_situacao)
            && @$oProgramacao->programacao_situacao->depende_aprovacao)
            return false;
        
        if ($oResvEntity->hasErrors())
            return false;

        if (!$oProgramacao->operacao->valida_documento)
            return true;
        
        $iCountDoc = 0;
        $iCountDoc += LgDbUtil::getFind('ProgramacaoContainers')->where([
            'programacao_id' => $oProgramacao->id
        ])->count();

        if (Resv::isCarga($oProgramacao) || Resv::isDescargaCarga($oProgramacao))
            $iCountDoc += LgDbUtil::getFind('ProgramacaoLiberacaoDocumentais')->where([
                'programacao_id' => $oProgramacao->id
            ])->count();

        if (Resv::isDescarga($oProgramacao) || Resv::isDescargaCarga($oProgramacao) || Resv::isDesova($oProgramacao))
            $iCountDoc += LgDbUtil::getFind('ProgramacaoDocumentoTransportes')->where([
                'programacao_id' => $oProgramacao->id
            ])->count();

        if (!$iCountDoc)
            return false;

        return true;
    }

    public static function canGenerateVistoriaExterna($oProgramacao)
    {
        if (isset($oProgramacao->vistoria)
            && @$oProgramacao->vistoria)
            return false;

        if (isset($oProgramacao->programacao_situacao)
            && @$oProgramacao->programacao_situacao->depende_aprovacao)
            return false;

        $iCountDoc = 0;
        $iCountDoc += LgDbUtil::getFind('ProgramacaoContainers')->where([
            'programacao_id' => $oProgramacao->id
        ])->count();

        if (Resv::isCarga($oProgramacao) || Resv::isDescargaCarga($oProgramacao))
            $iCountDoc += LgDbUtil::getFind('ProgramacaoLiberacaoDocumentais')->where([
                'programacao_id' => $oProgramacao->id
            ])->count();

        if (Resv::isDescarga($oProgramacao) || Resv::isDescargaCarga($oProgramacao))
            $iCountDoc += LgDbUtil::getFind('ProgramacaoDocumentoTransportes')->where([
                'programacao_id' => $oProgramacao->id
            ])->count();

        if (!$iCountDoc)
            return false;

        return true;
    }

    public static function carregaCombosInformaChegada($sAction = '', $aFilters = [])
    {
        $aCombos = array();

        $aDefaultAssociation = ['keyField' => 'id', 'valueField' => 'descricao'];

        $aCombos['Embalagens_options'] = LgDbUtil::getAll('Embalagens', [
            'embalagem_tipo_id' => 1
        ], [], $aDefaultAssociation, array_values($aDefaultAssociation));

        $sFilterName = 'Transportadoras_options';
        $aCombos[$sFilterName] = $sAction == 'add' ? [] : LgDbUtil::get('Transportadoras')
            ->find('list', ['keyField' => 'id', 'valueField' => 'cnpj_razao_social'])
            ->select([
                'id',
                'cnpj_razao_social' => LgDbUtil::getFind('Transportadoras')->func()->concat([
                    'cnpj' => 'identifier',
                    ' - ',
                    'razao_social' => 'identifier'
                ])
            ])
            ->where( ArrayUtil::get($aFilters, $sFilterName) ?: ['ativo' => 1])
            ->toArray();

        $sFilterName = 'Pessoas_options';
        $aCombos[$sFilterName] = $sAction == 'add' ? [] : LgDbUtil::get('Pessoas')
            ->find('list', ['keyField' => 'id', 'valueField' => 'nome_cpf'])
            ->select([
                'id',
                'nome_cpf' => LgDbUtil::getFind('Pessoas')->func()->concat([
                    'cpf' => 'identifier',
                    ' - ',
                    'nome_fantasia' => 'identifier',
                    ' (CNH: ',
                    'cnh' => 'identifier',
                    ')',
                ])
            ])
            ->where( ArrayUtil::get($aFilters, $sFilterName) ?: ['bloqueado' => 0])->toArray();

        $aCombos['Modais_options'] = LgDbUtil::get('Modais')
            ->find('list', ['keyField' => 'id', 'valueField' => 'descricao'])
            ->select(['id', 'descricao'])->toArray();

        $aCombos['TipoDocumentos_options'] = LgDbUtil::get('TipoDocumentos')
            ->find('list', ['keyField' => 'id', 'valueField' => 'tipo_documento'])
            ->select(['id', 'descricao'])->toArray();

        $aCombos['Operacoes_options'] = LgDbUtil::get('Operacoes')
            ->find('list', ['keyField' => 'id', 'valueField' => 'descricao'])
            ->select(['id', 'descricao'])
            // ->where(['id IN' => [1,2, 3,8,10]])
            ->order(['descricao' => 'ASC'])
            ->toArray();

        $aCombos['OperacoesContainers_options'] = LgDbUtil::get('Operacoes')
            ->find('list', ['keyField' => 'id', 'valueField' => 'descricao'])
            ->select(['id', 'descricao'])
            ->where(['id IN' => [1,2]])
            ->order(['descricao' => 'ASC'])
            ->toArray();

        $sFilterName = 'Veiculos_options';
        $aCombos[$sFilterName] = $sAction == 'add' ? [] : LgDbUtil::get('Veiculos')
            ->find('list', ['keyField' => 'id', 
                'valueField' => 'veiculo_identificacao'])
            ->select(['id', 'veiculo_identificacao'])
            ->where(ArrayUtil::get($aFilters, $sFilterName) ?: [])
            ->toArray();

        $aCombos['Portarias_options'] = LgDbUtil::get('Portarias')
            ->find('list', ['keyField' => 'id', 
                'valueField' => 'descricao'])
            ->select(['id', 'descricao'])->toArray();

        $aCombos['LacreTipos_options'] = LgDbUtil::get('LacreTipos')
            ->find('list', ['keyField' => 'id', 
                'valueField' => 'descricao'])
            ->select(['id', 'descricao'])->toArray();

        $aCombos['TipoIsos_options'] = LgDbUtil::get('TipoIsos')
            ->find('list', ['keyField' => 'id', 
                'valueField' => 'descricao'])
            ->select(['id', 'descricao'])->toArray();

        $aCombos['Empresas_options'] = LgDbUtil::get('Empresas')
            ->find('list', ['keyField' => 'id', 
                'valueField' => 'descricao'])
            ->select(['id', 'descricao'])->toArray();

        $aCombos['ContainerFormaUso_options'] = LgDbUtil::get('ContainerFormaUsos')
            ->find('list', ['keyField' => 'id', 
                'valueField' => 'descricao'])
            ->select(['id', 'descricao']);

        $aCombos['Containers_options'] = LgDbUtil::get('Containers')
            ->find('list', ['keyField' => 'id', 
                'valueField' => 'numero'])
            ->select(['id', 'numero']);

        $aCombos['DriveEspacos_options'] = LgDbUtil::get('DriveEspacos')
            ->find('list', ['keyField' => 'id', 
                'valueField' => 'descricao'])
            ->select(['id', 'descricao']);

        $aCombos['ContainerDestinos_options'] = LgDbUtil::get('ContainerDestinos')
            ->find('list', ['keyField' => 'id', 
                'valueField' => 'descricao'])
            ->select(['id', 'descricao']);

        $aCombos['ProgramacaoSituacoes_options'] = LgDbUtil::get('ProgramacaoSituacoes')
            ->find('list', ['keyField' => 'id', 
                'valueField' => 'descricao'])
            ->select(['id', 'descricao']);

        $aCombos['Procedencias_options'] = LgDbUtil::get('Procedencias')
            ->find('list', ['keyField' => 'id', 
                'valueField' => 'nome'])
            ->select(['id', 'nome']);
            
        $aCombos['OrgaoSolicitantes_options'] = LgDbUtil::get('OrgaoSolicitantes')
            ->find('list', ['keyField' => 'id', 
                'valueField' => 'descricao'])
            ->select(['id', 'descricao']);
        
        return $aCombos;
    }

    public static function saveProgramacao($that, $aProgramacao )
    {
        $oResponse = new ResponseUtil;
        $oResponseBloqueio = PessoaBloqueio::isBloqueada($aProgramacao['pessoa_id']);

        if ($oResponseBloqueio->getStatus() != 200)
            return $oResponseBloqueio;

        $dPesoMaximoVeiculo = LgDbUtil::getFirst('Veiculos', [
            'id' => @$aProgramacao['veiculo_id']
        ]);


        $aProgramacao['peso_maximo'] = @$aProgramacao['peso_maximo'] 
            ? DoubleUtil::toDBUnformat((@$aProgramacao['peso_maximo'] ?: 0))
            : ($dPesoMaximoVeiculo ? $dPesoMaximoVeiculo->peso_maximo : null);
        
        $aProgramacao['peso_pallets'] = DoubleUtil::toDBUnformat((@$aProgramacao['peso_pallets'] ?: 0));
        $aProgramacao['peso_estimado_carga'] = DoubleUtil::toDBUnformat((@$aProgramacao['peso_estimado_carga'] ?: 0));

        $aProgramacao['empresa_id']        = Empresa::getEmpresaPadrao();
        $aProgramacao['resv_codigo']       = (isset($aProgramacao['resv_codigo'])) ? $aProgramacao['resv_codigo'] : 0;

        $aProgramacao['data_hora_programada'] = ($aProgramacao['data_hora_programada']) 
            ? DateUtil::dateTimeToDB($aProgramacao['data_hora_programada']) 
            : null;

        $aProgramacao['data_hora_chegada'] = ($aProgramacao['data_hora_chegada']) 
            ? DateUtil::dateTimeToDB($aProgramacao['data_hora_chegada']) 
            : null;

        $aReboques = (isset($aProgramacao['reboque'])) ? $aProgramacao['reboque'] : [];
        $entity = LgDbUtil::get('Programacoes')->newEntity($aProgramacao);
        
        if (!$oProgramacao = LgDbUtil::get('Programacoes')->save($entity))
            return $oResponse->setMessage('Houve algum problema ao salvar o Registro de Programação! ' . EntityUtil::dumpErrors($entity));

        self::insertReboques($aReboques, $oProgramacao->id, $that);

        $oProgramacao->veiculo = $dPesoMaximoVeiculo;

        return $oResponse
            ->setStatus(200)
            ->setMessage('Informação de Programação salva!')
            ->setDataExtra($oProgramacao);
    }

    public static function saveProgramacaoDescargaGeneric($iProgramacaoId, $iDocumentoId)
    {
        $transporte = LgDbUtil::getFind('DocumentosTransportes')->where(['id'=>$iDocumentoId])->first();
        $oResponse = new ResponseUtil;

        if(!$transporte) {
            return $oResponse->setMessage('Documento de transporte não encontrado.');
        }

        $aData = array('programacao_id'=> $iProgramacaoId,'documento_transporte_id' => $transporte->id);
        $oProgramacaoDocumentoTransporte = LgDbUtil::get('ProgramacaoDocumentoTransportes')->newEntity($aData);

        if (LgDbUtil::get('ProgramacaoDocumentoTransportes')->save($oProgramacaoDocumentoTransporte)) {

            $oDocumentoMercadoriaEntity = new DocumentosMercadoria;
            $oDocumentoMercadoriaEntity->generateLoteCodigo(null, $transporte->id);

            $oProgramacaoDocEntrada = LgDbUtil::getFind('ProgramacaoDocumentoTransportes')
                ->contain(['DocumentosTransportes' => ['DocumentosMercadoriasMany' => ['Clientes']]])
                ->where(['ProgramacaoDocumentoTransportes.id' => $oProgramacaoDocumentoTransporte->id])
                ->first();

            $sCliente = '';
            foreach ($oProgramacaoDocEntrada->documentos_transporte->documentos_mercadorias as $oDocumentoMercadoria) {
                if ($sCliente) break;
            
                if ($oDocumentoMercadoria->cliente)
                    $sCliente = $oDocumentoMercadoria->cliente->descricao . ' ' . $oDocumentoMercadoria->cliente->cnpj;
            }

            $oProgramacaoDocEntrada->cliente = $sCliente;

            return $oResponse->setMessage('Documento cadastrado com sucesso')->setStatus(200)->setDataExtra($oProgramacaoDocEntrada);
        }

        return $oResponse
            ->setMessage('Documento não cadastrado pelos seguintes motivos: ' . EntityUtil::dumpErrors($oProgramacaoDocumentoTransporte))
            ->setStatus(400)
            ->setDataExtra([]);
    }

    public static function saveProgramacaoCargaResponse($documento, $iProgramacaoId)
    {
        $oResponse = new ResponseUtil;

        $oProgramacao = LgDbUtil::getFirst('Programacoes', ['id'=>$iProgramacaoId]);

        if (!$oProgramacao)
            return $oResponse->setMessage('Não foi possível encontrar a Programação!');
        
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
                        'LiberacaoDocumentalTransportadoraItens' => ['LiberacoesDocumentaisItens']
                    ])
                    ->where([
                        'LiberacaoDocumentalTransportadoras.id' => $documento,
                    ])
                    ->first();

                $oLiberacaoDocumental = $oLiberacaoDocumentalTransp->liberacoes_documental;

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
            $oLiberacaoDocumental = LgDbUtil::getFirst('LiberacoesDocumentais', ['numero' => $documento]);
        }
        $aProgramacaoVinculo = [];

        if (($oLiberacaoDocumental || $oLiberacaoDocumentalTransp) && in_array($iDocumentoTipo, [2,3]) || !$iDocumentoTipo) {
            $aProgramacaoVinculo = [
                'registry' => $oLiberacaoDocumental ? $oLiberacaoDocumental : $oLiberacaoDocumentalTransp,
                'relation_table' => 'ProgramacaoLiberacaoDocumentais',
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

        if (!$aProgramacaoVinculo && !$oLiberacaoDocumental)
            return $oResponse
                ->setStatus(400)
                ->setMessage('Faltam parâmetros para salvar o documento.');
        

        $aData = array(
            'programacao_id' => $oProgramacao->id, 
            $aProgramacaoVinculo['fk_1']['name'] => $aProgramacaoVinculo['fk_1']['value'],
            $aProgramacaoVinculo['fk_2']['name'] => $aProgramacaoVinculo['fk_2']['value'],
        );

        $oProgramacaoVinculo = LgDbUtil::get($aProgramacaoVinculo['relation_table'])->newEntity($aData);
        
        if ($oResult = LgDbUtil::get($aProgramacaoVinculo['relation_table'])->save($oProgramacaoVinculo)) {

            //Salva Itens da Liberação documental (por transp ou não)
            foreach ($aLiberacaoItens as $aLiberacaoItem) {
                $aLiberacaoItem['programacao_liberacao_documental_id'] = $oResult->id;
                LgDbUtil::saveNew('ProgramacaoLiberacaoDocumentalItens', $aLiberacaoItem);
            }

            $oProgramacaoLiberacaoDocumental = LgDbUtil::get($aProgramacaoVinculo['relation_table'])->get($oProgramacaoVinculo->id, [
                'contain' => [
                    'LiberacoesDocumentais' => ['Clientes'],
                    'LiberacaoDocumentalTransportadoras',
                    'ProgramacaoLiberacaoDocumentalItens'
                ]
            ]);

            return $oResponse
                ->setStatus(200)
                ->setMessage(__('The') . ' ' . __($aProgramacaoVinculo['name_call']) . ' ' . __('foi salvo com sucesso!'))
                ->setDataExtra($oProgramacaoLiberacaoDocumental);
        } else {
            return $oResponse
                ->setStatus(400)
                ->setMessage(__('The') . ' ' . __($aProgramacaoVinculo['name_call']) . ' ' . __('não pode ser criada. ') . EntityUtil::dumpErrors($oProgramacaoVinculo))
                ->setDataExtra([]);
        }
    }

    public static function getContainersDocumento($iNumeroDocumento, $iOperacaoID)
    {
        $aContainers = [];

        switch ($iOperacaoID) {
            case 1: // DESCARGA

                $oDocumentoTransporte = LgDbUtil::getFind('DocumentosTransportes')
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
                    foreach ($aContainers as $key => $value) {
                        $oContainer = LgDbUtil::getFind('Containers')->where(['id' => $key])->first();
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
                    $carry[$oLiberacaoDocItem->container_id] = $oLiberacaoDocItem->container->numero;
                    return $carry;
                });

                $aContainers = $aContainers ?: [];
                break;
            default:
                break;
        }

        return $aContainers;
    }

    public static function removeProgramacao($iProgramacaoId)
    {
        $oProgramacao = LgDbUtil::get('Programacoes')->get($iProgramacaoId, [
            'contain' => array(
                'ProgramacaoVeiculos',
                'ProgramacaoLiberacaoDocumentais' => ['ProgramacaoLiberacaoDocumentalItens'],
                'ProgramacaoContainers' => ['ProgramacaoContainerLacres'],
                'ProgramacaoDocumentoGenericos',
                'ProgramacaoDocumentoTransportes',
                'ProgramacaoHistoricoSituacoes',
                'Vistorias' => [
                    'VistoriaAvarias' => ['VistoriaAvariaRespostas'],
                    'VistoriaFotos',
                    'VistoriaLacres',
                    'VistoriaItens'
                ]
            )
        ]);

        $oReponse = new ResponseUtil;

        if (!$oProgramacao)
            return $oReponse
                ->setMessage('Programação não encontrada');

        if ($oProgramacao->resv_id)
            return $oReponse
                ->setMessage('Esta programação já existe resv criada.');

        if ($oProgramacao->programacao_liberacao_documentais) {

            foreach ($oProgramacao->programacao_liberacao_documentais as $oProgramacaoLiberacaoDocumental) {
                self::deleteMany($oProgramacaoLiberacaoDocumental->programacao_liberacao_documental_itens);
            }

            self::deleteMany($oProgramacao->programacao_liberacao_documentais);
        }

        if ($oProgramacao->programacao_containers) {

            foreach ($oProgramacao->programacao_containers as $oProgramacaoContainer) {
                self::deleteMany($oProgramacaoContainer->programacao_container_lacres);
            }

            self::deleteMany($oProgramacao->programacao_containers);
        }

        if ($oProgramacao->programacao_documento_genericos)
            self::deleteMany($oProgramacao->programacao_documento_genericos);

        if ($oProgramacao->programacao_veiculos)
            self::deleteMany($oProgramacao->programacao_veiculos);

        if ($oProgramacao->programacao_documento_transportes)
            self::deleteMany($oProgramacao->programacao_documento_transportes);

        if ($oProgramacao->vistoria) {

            foreach ($oProgramacao->vistoria->vistoria_avarias as $oVistoriaAvaria) {
                self::deleteMany($oVistoriaAvaria->vistoria_avaria_respostas);
            }

            self::deleteMany($oProgramacao->vistoria->vistoria_avarias);
            self::deleteMany($oProgramacao->vistoria->vistoria_fotos);
            self::deleteMany($oProgramacao->vistoria->vistoria_lacres);
            self::deleteMany($oProgramacao->vistoria->vistoria_itens);

            LgDbUtil::get('Vistorias')->delete($oProgramacao->vistoria);
        }
        LgDbUtil::get('Programacoes')->delete($oProgramacao);

        return $oReponse
            ->setStatus(200)
            ->setMessage('Programação excluída com sucesso');
    }

    public static function deleteMany($aEntities)
    {
        if (!$aEntities)
            return;

        $aEntityIds = array_map(function($position) {
            return $position->id;
        }, $aEntities);

        $sModel = $aEntities[0]->source();
        
        foreach ($aEntities as $oEntity) {
            $oEntityNew = LgDbUtil::getByID($sModel, $oEntity->id);

            if ($oEntityNew)
                LgDbUtil::get($sModel)->delete($oEntityNew);
        }
    }

    public static function fecharResvResponse($iProgramacaoID)
    {
        $oProgramacao = LgDbUtil::get('Programacoes')->get($iProgramacaoID, [
            'contain' => [
                'Veiculos'
            ]
        ]);
        $bReturn = Programacao::canFecharResv($oProgramacao);
        $oResponse = new ResponseUtil();

        if (!$bReturn) {
            return $oResponse
                ->setMessage('Já existe pesagem desse veículo! Peça para o setor de Estoques remover as pesagens desse veículo!');
        }

        $oResv = LgDbUtil::getFind('Resvs')
            ->contain([
                'Pesagens' => [
                    'PesagemVeiculos'
                ],
                'ResvsLiberacoesDocumentais' => [
                    'ResvLiberacaoDocumentalItens'
                ],
                'ResvsDocumentosTransportes',
                'ResvsContainers' => [
                    'ResvContainerLacres'
                ],
                'ResvsVeiculos',
                'OrdemServicos' => [
                    'OrdemServicoCarregamentos'
                ]
            ])
            ->where([
                'Resvs.id' => $oProgramacao->resv_id,
                'Resvs.programacao_id' => $oProgramacao->id
            ])
            ->first();

        if (!$oResv)
            return $oResponse
                ->setMessage('A RESV '.$oProgramacao->resv_id.' a ser fechada não pertence à Programação #' . $iProgramacaoID );

        $oOrdemServico = @$oResv->ordem_servicos[0];
        $aOrdemServicoCarregamentos = @$oOrdemServico->ordem_servico_carregamentos;

        if ($oOrdemServico || $aOrdemServicoCarregamentos)
            return $oResponse
                ->setMessage('Já existe itens carregados nessa RESV! Ordem de Serviço #' . $oOrdemServico->id);

        foreach ($oResv->pesagens as $oPesagem) {

            self::deleteMany($oPesagem->pesagem_veiculos);
        }

        self::deleteMany($oResv->pesagens);

        if ($oOrdemServico) {
            LgDbUtil::get('OrdemServicos')->delete($oOrdemServico);
        }

        foreach ($oResv->resvs_liberacoes_documentais as $oResvLiberacaoDocumental) {

            self::deleteMany($oResvLiberacaoDocumental->liberacao_documental_itens);
        }

        self::deleteMany($oResv->resvs_documentos_tranportes);

        foreach ($oResv->resvs_containers as $oResvContainer) {

            self::deleteMany($oResvContainer->resv_container_lacres);
        }

        self::deleteMany($oResv->resvs_containers);
        self::deleteMany($oResv->resvs_liberacoes_documentais);
        self::deleteMany($oResv->resvs_veiculos);

        $oProgramacao->resv_id = null;
        LgDbUtil::save('Programacoes', $oProgramacao);
        LgDbUtil::get('Resvs')->delete($oResv);
        
        return $oResponse
            ->setStatus(200)
            ->setMessage('RESV deletada com sucesso!')
            ->setDataExtra(['oProgramacao' => $oProgramacao]);
    }

    public static function saveProgramacaoContainerFromDocumento($aRequestData, $iProgramacaoId)
    {
        $aProgramacaoContainers = [];

        if (@$aRequestData['documento']) {
            switch ($aRequestData['operacao_id_doc_entrada_saida']) {
                case 1:
                    $aDataDoc['table'] = 'DocumentosTransportes';
                    $aDataDoc['column'] = 'documento_transporte_id';
                    $iDocumentoId = $aRequestData['documento'];
                    break;
                case 2:
                    $aDataDoc['table'] = 'LiberacoesDocumentais';
                    $aDataDoc['column'] = 'liberacao_documental_id';
                    $iDocumentoId = explode('_', $aRequestData['documento'])[1];
                    break;
                case (EntityUtil::getIdByParams('Operacoes', 'descricao', 'Desova Direta Documento')):
                    $aDataDoc['table'] = 'DocumentosTransportes';
                    $aDataDoc['column'] = 'documento_transporte_id';
                    $iDocumentoId = $aRequestData['documento'];
                    break;
                case (EntityUtil::getIdByParams('Operacoes', 'descricao', 'Desova - Canal Vermelho (via Doc.)')):
                    $aDataDoc['table'] = 'DocumentosTransportes';
                    $aDataDoc['column'] = 'documento_transporte_id';
                    $iDocumentoId = $aRequestData['documento'];
                    break;
                case (EntityUtil::getIdByParams('Operacoes', 'descricao', 'Desova Investigativa (Via Doc.)')):
                    $aDataDoc['table'] = 'DocumentosTransportes';
                    $aDataDoc['column'] = 'documento_transporte_id';
                    $iDocumentoId = $aRequestData['documento'];
                    break;
                case (EntityUtil::getIdByParams('Operacoes', 'descricao', 'Desova')):
                    $aDataDoc['table'] = 'DocumentosTransportes';
                    $aDataDoc['column'] = 'documento_transporte_id';
                    $iDocumentoId = $aRequestData['documento'];
                    break;
    
                default:
                    break;
            }
    
            $oDocumento = LgDbUtil::getFind($aDataDoc['table'])
                ->where([$aDataDoc['table'] . '.id' => $iDocumentoId])
                ->first();
    
            if ($aRequestData['operacao_id_doc_entrada_saida'] == 1 && $oDocumento)
                $oDocumentoMercadoria = LgDbUtil::getFind('DocumentosMercadorias')
                    ->where([
                        'documento_transporte_id' => $oDocumento->id,
                        'documento_mercadoria_id_master IS NOT NULL'
                    ])
                    ->first();
        }

        $aProgramacaoContainerIds = [];
        foreach ($aRequestData['documento_containers'] as $iContainerID) {
            if($aRequestData['drive_espaco_id']) {
                $oDriveEspaco = LgDbUtil::getFirst('DriveEspacos', ['id' => $aRequestData['drive_espaco_id']]);
                $bCheckQtdeContainer = DriveEspaco::checkQtdeContainer($oDriveEspaco, $aRequestData['operacao_id_doc_entrada_saida'], $aRequestData['tipo_container']);

                if($bCheckQtdeContainer->status !== 200) {
                    return (new ResponseUtil())
                        ->setStatus(405)
                        ->setMessage($bCheckQtdeContainer->message);
                }
            }

            $bExisteContainer = EntradaSaidaContainer::verifyIfContainerInEstoque(@$iContainerID ?: null, $aRequestData['operacao_id_doc_entrada_saida']);

            if ($bExisteContainer)
                return (new ResponseUtil())
                    ->setStatus(405)
                    ->setMessage('Container já esta em estoque.');

            $oReturn = ProgramacaoContainer::verifyExistsContainerInProgramacao($iContainerID);

            if ($oReturn->getStatus() == 400)
                return $oReturn;
            
            LiberacaoAutomaticaContainer::do($iContainerID);

            $aData = [
                'container_id'            => (int) $iContainerID,
                'programacao_id'          => (int) $iProgramacaoId,
                'operacao_id'             => (int) $aRequestData['operacao_id_doc_entrada_saida'],
                'tipo'                    => $aRequestData['tipo_container'],
                // 'cliente_id'              => isset($oDocumentoMercadoria) ? $oDocumentoMercadoria->cliente_id : null
            ];

            if ((int) $aRequestData['drive_espaco_id'])
                $aData['drive_espaco_id'] = (int)$aRequestData['drive_espaco_id'];

            if (@$aRequestData['documento'])
                $aData[$aDataDoc['column']] = $oDocumento->id;

            $oProgramacaoContainer = LgDbUtil::get('ProgramacaoContainers')->newEntity($aData);

            if (LgDbUtil::get('ProgramacaoContainers')->save($oProgramacaoContainer)) {

                if (@$aDataDoc['column'] === 'documento_transporte_id') {

                    $aDocumentoLacres = LgDbUtil::getFind('Lacres')
                        ->where([
                            'documento_transporte_id' => $oDocumento->id,
                            'container_id' => $iContainerID
                        ])
                        ->toArray();
                    if ($aDocumentoLacres) {
                        foreach ($aDocumentoLacres as $oLacre) {
                            
                            $oLacreEntity = LgDbUtil::get('ProgramacaoContainerLacres')->newEntity([
                                'lacre_numero' => $oLacre->descricao,
                                'lacre_tipo_id' => $oLacre->lacre_tipo_id,
                                'programacao_container_id' => $oProgramacaoContainer->id
                            ]);
            
                            LgDbUtil::get('ProgramacaoContainerLacres')->save($oLacreEntity);
                        }
                    }
                }
                $aProgramacaoContainerIds[] = $oProgramacaoContainer->id;

            }
        }

        if ($aProgramacaoContainerIds)
            $aProgramacaoContainers = LgDbUtil::getFind('ProgramacaoContainers')
                ->contain([
                    'Programacoes',
                    'Containers',
                    'DocumentosTransportes',
                    'Operacoes',
                    'Empresas',
                    'DriveEspacos',
                    'ProgramacaoContainerLacres' => [
                        'LacreTipos'
                    ]
                ])
                ->where(['ProgramacaoContainers.id IN' => $aProgramacaoContainerIds])
                ->toArray();

        if ($aProgramacaoContainers)
            return (new ResponseUtil())
                ->setStatus(200)
                ->setMessage('Containers salvos com sucesso.')
                ->setDataExtra($aProgramacaoContainers);

        return (new ResponseUtil())
            ->setMessage('Houve algum problema ao obter os Containers salvos, verifique se preencheu todos os dados!');
    }

    public static function consisteTipoOperacao($iTableId, $sTable)
    {
        $iOperacaoId = null;
        $oSql = null;

        $iOperacaoDescargaId = EntityUtil::getIdByParams('Operacoes', 'descricao', 'Descarga');
        $iOperacaoCargaId = EntityUtil::getIdByParams('Operacoes', 'descricao', 'Carga');
        $iOperacaoDescargaCargaId = EntityUtil::getIdByParams('Operacoes', 'descricao', 'Descarga/Carga');
        switch ($sTable) {
            case 'Programacoes':
                $oSql = LgDbUtil::getFind('Programacoes')
                    ->contain([
                        'ProgramacaoLiberacaoDocumentais' => [
                            'ProgramacaoLiberacaoDocumentalItens'
                        ],
                        'ProgramacaoContainers' => [
                            'ProgramacaoContainerLacres'
                        ],
                        'ProgramacaoDocumentoTransportes'
                    ])
                    ->where([
                        'Programacoes.id' => $iTableId
                    ])->first();
    
                
                    $iOperacaoLibDoc = $iOperacaoDocTransp = 
                    $iOperacaoCntVazioCarga = $iOperacaoCntVazioDescarga = 0;
    
                    if (!empty($oSql->programacao_liberacao_documentais))
                        $iOperacaoLibDoc++;
                    
                    if (!empty($oSql->programacao_documento_transportes))
                        $iOperacaoDocTransp++;
    
                    if (!empty($oSql->programacao_containers)) {
                        foreach ($oSql->programacao_containers as $oProgramacaoContainer) {
                            if ($oProgramacaoContainer->tipo == 'CHEIO')
                                continue;
    
                            if ($oProgramacaoContainer->operacao_id == $iOperacaoDescargaId)
                                $iOperacaoCntVazioDescarga++;
    
                            if ($oProgramacaoContainer->operacao_id == $iOperacaoCargaId)
                                $iOperacaoCntVazioCarga++;
                        }
                    }
    
                    if (!$iOperacaoLibDoc && $iOperacaoDocTransp)
                        $iOperacaoId = $iOperacaoDescargaId;
                    elseif ($iOperacaoLibDoc && !$iOperacaoDocTransp)
                        $iOperacaoId = $iOperacaoCargaId;
    
                    if ($iOperacaoLibDoc && $iOperacaoDocTransp)
                        $iOperacaoId = $iOperacaoDescargaCargaId;
    
                    if ($iOperacaoCntVazioCarga && $iOperacaoCntVazioDescarga)
                        $iOperacaoId = $iOperacaoDescargaCargaId;
    
                    if (!$iOperacaoCntVazioCarga && $iOperacaoCntVazioDescarga
                        && !$iOperacaoLibDoc && !$iOperacaoDocTransp)
                        $iOperacaoId = $iOperacaoDescargaId;
    
                    if ($iOperacaoCntVazioCarga && !$iOperacaoCntVazioDescarga
                        && !$iOperacaoLibDoc && !$iOperacaoDocTransp)
                        $iOperacaoId = $iOperacaoCargaId;

                    if ($iOperacaoCntVazioCarga && $iOperacaoCntVazioDescarga
                        && !$iOperacaoLibDoc && !$iOperacaoDocTransp)
                        $iOperacaoId = $iOperacaoDescargaCargaId;
                break;
            case 'Resvs':
                $oSql = LgDbUtil::getFind('Resvs')
                    ->contain([
                        'ResvsLiberacoesDocumentais',
                        'ResvsDocumentosTransportes',
                        'ResvsContainers'
                    ])
                    ->where([
                        'Resvs.id' => $iTableId
                    ])
                    ->first();

                $iOperacaoLibDoc = $iOperacaoDocTransp = 
                $iOperacaoCntVazioCarga = $iOperacaoCntVazioDescarga = 0;

                if (!empty($oSql->resvs_liberacoes_documentais))
                    $iOperacaoLibDoc++;
                
                if (!empty($oSql->resvs_documentos_transportes))
                    $iOperacaoDocTransp++;

                if (!empty($oSql->resvs_containers)) {
                    foreach ($oSql->resvs_containers as $oResvContainer) {
                        if ($oResvContainer->tipo == 'CHEIO')
                            continue;

                        if ($oResvContainer->operacao_id == $iOperacaoDescargaId)
                            $iOperacaoCntVazioDescarga++;

                        if ($oResvContainer->operacao_id == $iOperacaoCargaId)
                            $iOperacaoCntVazioCarga++;
                    }
                }

                if (!$iOperacaoLibDoc && $iOperacaoDocTransp)
                    $iOperacaoId = $iOperacaoDescargaId;
                elseif ($iOperacaoLibDoc && !$iOperacaoDocTransp)
                    $iOperacaoId = $iOperacaoCargaId;

                if ($iOperacaoLibDoc && $iOperacaoDocTransp)
                    $iOperacaoId = $iOperacaoDescargaCargaId;

                if ($iOperacaoCntVazioCarga && $iOperacaoCntVazioDescarga)
                    $iOperacaoId = $iOperacaoDescargaCargaId;

                if (!$iOperacaoCntVazioCarga && $iOperacaoCntVazioDescarga
                    && !$iOperacaoLibDoc && !$iOperacaoDocTransp)
                    $iOperacaoId = $iOperacaoDescargaId;

                if ($iOperacaoCntVazioCarga && !$iOperacaoCntVazioDescarga
                    && !$iOperacaoLibDoc && !$iOperacaoDocTransp)
                    $iOperacaoId = $iOperacaoCargaId;

                if ($iOperacaoCntVazioCarga && $iOperacaoCntVazioDescarga
                    && !$iOperacaoLibDoc && !$iOperacaoDocTransp)
                    $iOperacaoId = $iOperacaoDescargaCargaId;
                
                if ($oSql->operacao_id != $iOperacaoId && $iOperacaoId != $iOperacaoDescargaCargaId) {
                    $oOrdemServico = LgDbUtil::getFind('OrdemServicos')
                        ->where(['resv_id' => $oSql->id])
                        ->first();

                    $oOperacao = LgDbUtil::getById('Operacoes', $iOperacaoId);

                    $oOrdemServico->ordem_servico_tipo = EntityUtil::getIdByParams('OrdemServicoTipos', 'descricao', $oOperacao->descricao);

                    LgDbUtil::get('OrdemServicoTipos')->save($oOrdemServico);
                } elseif ($oSql->operacao_id != $iOperacaoId && $iOperacaoId == $iOperacaoDescargaCargaId) {
                    
                    $sType = '';
            
                    if (Resv::isDescarga($oSql)) {
                        $sType = 'Carga';
                    }elseif (Resv::isCarga($oSql)) {
                        $sType = 'Descarga';
                    }
            
                    $oResvEntity = new Resv();
                    $aData = array(
                        'resv_id'                => $oSql->id,
                        'ordem_servico_tipo_id'  => EntityUtil::getIdByParams('OrdemServicoTipos', 'descricao', $sType),
                        'retroativo'             => isset($oSql->retroativo) ? $oSql->retroativo : 0,
                        'initiated_by_id'        => $_SESSION['Auth']['User']['id'],
                        'empresa_id'             => Empresa::getEmpresaPadrao()
                    );

                    $oOrdemServico = LgDbUtil::get('OrdemServicos')->newEntity($aData);
                    LgDbUtil::get('OrdemServicos')->save($oOrdemServico);
                }

                
                break;
        }
       
        if (isset($oSql->operacao_id) && $oSql->operacao_id != $iOperacaoId) {
            $oEntity = LgDbUtil::getById($sTable, $iTableId);
            $oEntity->operacao_id = $iOperacaoId;
            LgDbUtil::get($sTable)->save($oEntity);
        }
    }

    public function saveProgramacaoDescarga($that, $documento){
        $doc = $that->DocumentosMercadorias->newEntity();
        $transporte = $that->DocumentosTransportes->find()->where(['id'=>$documento])->first();
        if(!$transporte){
            throw new \Exception("Error Processing Request", 1);
        }
        $aData = array('programacao_id'=> $this->id,'documento_transporte_id' => $transporte->id);
        $oProgramacaoDocumentoTransportes = $that->ProgramacaoDocumentoTransportes->newEntity($aData);
        if ($that->ProgramacaoDocumentoTransportes->save($oProgramacaoDocumentoTransportes)) {
            $doc->generateLoteCodigo( $that,$transporte->id);
            $that->Flash->success(__('The') . ' ' . __('Programação do documento Transporte') . ' ' . __('foi salvo com sucesso!'));
            return true;
        } else {
            $that->Flash->error(__('The') . ' ' . __('Programação do documento Transporte') . ' ' . __('could not be deleted. Please, try again.'));
            return false;
        }
    }

    public static function doPostRequest($that, $aData, &$oProgramacao){

        $aProgramacao = @$aData['programacao'];
        $aProgramacao['peso_estimado_carga'] = DoubleUtil::toDBUnformat((@$aProgramacao['peso_estimado_carga'] ?: 0));
        $bReturn = !empty($aData['liberacao_documental_transportadora']);

        if(isset($aData['agendamento'])){

            $oGrade = LgDbUtil::getFirst('GradeHorarios', ['id' => $aData['grade_horario_id']]);
            $aDataHora = explode('_', $aData['hora_programada']);

            $aProgramacao = [
                'grade_horario_id' => $aData['grade_horario_id'],
                'data_hora_programada' => DateUtil::dateTimeToDB(date('Y-m-d H:i:s',  @$aDataHora[0])),
                'data_hora_chegada' => DateUtil::dateTimeToDB(date('Y-m-d H:i:s',  @$aDataHora[1])),
                'time_programada' => @$aDataHora[0],
                'time_chegada' => @$aDataHora[1],
                'operacao_id' => @$oGrade->operacao_id,
                'liberacao_documental_transportadora' => @$aData['liberacao_documental_transportadora']
            ];

            $oProgramacao =  LgDbUtil::get('Programacoes')->patchEntity($oProgramacao, $aProgramacao);
            return false;
        }

        if(isset($aData['grade_horario_id'])){
            $oGrade = LgDbUtil::getFirst('GradeHorarios', ['id' => $aData['grade_horario_id']]);
            $aData['programacao']['grade_horario_id'] = @$oGrade->id;
            $aData['programacao']['operacao_id'] = @$oGrade->operacao_id ?: @$aData['programacao']['operacao_id'];
        }

        // dd(($aData);
        $iRequerPesoEstimado = ParametroGeral::getParametroWithValue('OBRIGA_INFORMAR_PESO_ESTIMADO');
        if ($bReturn && !@$aProgramacao['peso_estimado_carga'] && $iRequerPesoEstimado) {
            $that->Flash->error(__('Falta informar o peso estimado!') );
            return false;
        }

        $uReturn = self::saveProgramacaoGeneric($that, $aData, null, '',  $bReturn);

        if(is_array($uReturn) && isset($uReturn['return']) && $uReturn['return']){
            $that->Flash->success( __('Informação de Programação salva!'));
            $iID = $aData['liberacao_documental_transportadora'];
            $_SESSION['focus_to'] = '.numero_doc_entrada_saida';
            self::saveProgramacaoCargaGeneric($that, "3_$iID", $uReturn['oProgramacao']);
            return $that->redirect(['action' => 'edit', $uReturn['oProgramacao']->id]);
        }

        return true;
    }

    public static function getUserRestriction(){
        $iPerfil = SessionUtil::getPerfilUsuario();
        $aRestrition = json_decode(ParametroGeral::getParametroWithValue('PARAM_RESTRICOES_PROGRAMACOES'), true);
        if(empty($aRestrition['perfis'][$iPerfil])){
            return false;
        }

        return $aRestrition['perfis'][$iPerfil];
    }


    public static function bVerifyRestriction($aRestricoes, $controller, $action){

        if(empty($aRestricoes)){
            return false;
        }

        if (!array_key_exists($controller, $aRestricoes))
            return false;

        if (!array_key_exists($action, $aRestricoes[$controller]))
            return false;

        return ($aRestricoes[$controller][$action]);
    }

    public static function getDataProgramacao($oProgramacao, $iIndexCompleto)
    {
        $aDocTransportes = array_reduce($oProgramacao->programacao_documento_transportes, function($carry, $oProgDocTransp) {
            $carry[] = $oProgDocTransp->documentos_transporte->numero;
            return $carry;
        }, []) ?: [];

        $aCeMercantes = [];
        foreach ($oProgramacao->programacao_documento_transportes as $oProgDocTransp) {
            foreach ($oProgDocTransp->documentos_transporte->documentos_mercadorias as $oDocMerc) {
                if ($oDocMerc->ce_mercante)
                    $aCeMercantes[] = $oDocMerc->ce_mercante;
            }
        }

        $aProgDocTransportes = $oProgramacao->programacao_documento_transportes;
        $aClientes = [];
        $aClientes[] = isset($aProgDocTransportes[count($aProgDocTransportes) - 1]->documentos_transporte->documentos_mercadorias[1]->cliente->descricao)
            ? $aProgDocTransportes[count($aProgDocTransportes) - 1]->documentos_transporte->documentos_mercadorias[1]->cliente->descricao
            : '';

        $aLibDocs = array_reduce($oProgramacao->programacao_liberacao_documentais, function($carry, $oProgLibDoc) {
            $carry[] = $oProgLibDoc->liberacoes_documental->numero;
            return $carry;
        }, []) ?: [];

        $aProgLibDocs = $oProgramacao->programacao_liberacao_documentais;
        $aClientes[] = isset($aProgLibDocs[count($aProgLibDocs) - 1]->liberacoes_documental->cliente->descricao)
            ? $aProgLibDocs[count($aProgLibDocs) - 1]->liberacoes_documental->cliente->descricao
            : '';

        if ($iIndexCompleto != 2) {
            $aCnts = array_reduce($oProgramacao->programacao_containers, function($carry, $oProgCnt) {
                $sContainerDestino = $oProgCnt->container_destino ?  '</br> Destino: ' . $oProgCnt->container_destino->descricao : null;
                $sContainer = $oProgCnt->container ? '</br>Número: ' . $oProgCnt->container->numero . '</br> Armador: ' . @$oProgCnt->container->armador->descricao : 'CNT VAZIO';
                if ($sContainerDestino)
                    $sContainer .= $sContainerDestino;
                $carry[] = $sContainer;
                return $carry;
            }, []) ?: [];
        } else {
            $aCnts = array_reduce($oProgramacao->programacao_containers, function($carry, $oProgCnt) {
                $sContainer = $oProgCnt->container ? $oProgCnt->container->numero : 'CNT VAZIO';
                $carry[] = $sContainer;
                return $carry;
            }, []) ?: [];
        }

        return [
            'doc_transportes' => $aDocTransportes,
            'lib_documentais' => $aLibDocs,
            'containers' => $aCnts,
            'clientes' => $aClientes,
            'ce_mercantes' => $aCeMercantes
        ];
    }

    public static function bVerifyUserRestriction($controller, $action){
        $aRestricoes = self::getUserRestriction();
        return self::bVerifyRestriction($aRestricoes, $controller, $action);
    }

    public static function verifyExistsAgendamentoDocumento($aDataPost)
    {
        $oResponse = new ResponseUtil();

        if (!$aDataPost['oDocumentoContainers'])
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('Necessário selecionar algum container!');

        $aData = [
            'programacao_id' => $aDataPost['iProgramacaoID']
        ];

        foreach ($aDataPost['oDocumentoContainers'] as $key => $value) {
            
            $aData['container_id'] = $value;
            $oResponse             = ProgramacaoContainer::verifyContainerAgendado($aData);

            if ($oResponse->getStatus() != 200)
                return $oResponse;

        }

        return $oResponse;
    }

    public static function getFilters($aDataQuery)
    {
        $aBeneficiariosWhere = [];
        if ($aDataQuery['beneficiario']['values'][0])
            $aBeneficiariosWhere += ['Empresas.id' => $aDataQuery['beneficiario']['values'][0]];
        $aBeneficiarios = LgdbUtil::get('Empresas')
            ->find('list', ['keyField' => 'id', 'valueField' => 'descricao'])
            ->select( ['id', 'descricao'] )
            ->where($aBeneficiariosWhere)
            ->limit(1);

        $aArmadoresWhere = [];
        if ($aDataQuery['armador']['values'][0])
            $aArmadoresWhere += ['Empresas.id' => $aDataQuery['armador']['values'][0]];
        $aArmadores = LgdbUtil::get('Empresas')
            ->find('list', ['keyField' => 'id', 'valueField' => 'descricao'])
            ->select( ['id', 'descricao'] )
            ->where($aArmadoresWhere)
            ->limit(1);

        $aClientesWhere = [];
        if ($aDataQuery['cliente']['values'][0])
            $aClientesWhere += ['Empresas.id' => $aDataQuery['cliente']['values'][0]];
        $aClientes = LgdbUtil::get('Empresas')
            ->find('list', ['keyField' => 'id', 'valueField' => 'descricao'])
            ->select( ['id', 'descricao'] )
            ->where($aClientesWhere)
            ->limit(1);

        $aDriveEspacosWhere = [];
        if ($aDataQuery['drive_espaco']['values'][0])
            $aDriveEspacosWhere += ['DriveEspacos.id' => $aDataQuery['drive_espaco']['values'][0]];
        $aDriveEspacos = LgdbUtil::get('DriveEspacos')
            ->find('list', ['keyField' => 'id', 'valueField' => 'descricao'])
            ->select( ['id', 'descricao'] )
            ->where($aDriveEspacosWhere)
            ->limit(1);

        $aContainersWhere = [];
        if ($aDataQuery['container']['values'][0])
            $aContainersWhere += ['Containers.id' => $aDataQuery['container']['values'][0]];
        $aContainers = LgdbUtil::get('Containers')
            ->find('list', ['keyField' => 'id', 'valueField' => 'numero'])
            ->select( ['id', 'numero'] )
            ->where($aContainersWhere)
            ->limit(1);

        $aGradeHorarios = LgdbUtil::get('GradeHorarios')
            ->find('list', ['keyField' => 'id', 'valueField' => 'descricao'])
            ->select( ['id', 'descricao'] )
            ->where(['tipo_grade' => 0, 'ativo' => 1]);

        $aOperacoes = LgdbUtil::get('Operacoes')
            ->find('list', ['keyField' => 'id', 'valueField' => 'descricao'])
            ->select( ['id', 'descricao'] );

        $aTransportadorasWhere = [];
        if ($aDataQuery['transportadora']['values'][0])
            $aTransportadorasWhere += ['Transportadoras.id' => $aDataQuery['transportadora']['values'][0]];
        $aTransportadoras = LgdbUtil::get('Transportadoras')
            ->find('list', ['keyField' => 'id', 'valueField' => 'razao_social'])
            ->select( ['id', 'razao_social'] )
            ->where($aTransportadorasWhere)
            ->limit(1);

        $aVeiculosWhere = [];
        if ($aDataQuery['placa']['values'][0])
            $aVeiculosWhere += ['Veiculos.id' => $aDataQuery['placa']['values'][0]];
        $aVeiculos = LgdbUtil::get('Veiculos')
            ->find('list', ['keyField' => 'id', 'valueField' => 'descricao'])
            ->select( ['id', 'descricao'] )
            ->where($aVeiculosWhere)
            ->limit(1);

        $aProgramacaoSituacoes = LgdbUtil::get('ProgramacaoSituacoes')
            ->find('list', ['keyField' => 'id', 'valueField' => 'descricao'])
            ->select( ['id', 'descricao'] );

        $aPessoasWhere = [];
        if ($aDataQuery['motorista']['values'][0])
            $aPessoasWhere += ['Pessoas.id' => $aDataQuery['motorista']['values'][0]];
        $aPessoas = LgdbUtil::get('Pessoas')
            ->find('list', ['keyField' => 'id', 'valueField' => 'descricao'])
            ->select( ['id', 'descricao'] )
            ->where($aPessoasWhere)
            ->limit(1);

        $aModais = LgdbUtil::get('Modais')
            ->find('list', ['keyField' => 'id', 'valueField' => 'descricao'])
            ->select( ['id', 'descricao'] );

        return [
            [
                'name'  => 'situacao',
                'divClass' => 'col-lg-2',
                'label' => 'Situação',
                'table' => [
                    'className' => 'ProgramacaoSituacoes',
                    'field'     => 'id',
                    'operacao'  => 'in',
                    'type'      => 'select',
                    'options'   => $aProgramacaoSituacoes
                ]
            ],
            [
                'name'  => 'grade_horario',
                'divClass' => 'col-lg-3',
                'label' => 'Grade Horário',
                'table' => [
                    'className' => 'GradeHorarios',
                    'field'     => 'id',
                    'operacao'  => 'in',
                    'type'      => 'select',
                    'options'   => $aGradeHorarios
                ]
            ],
            [
                'name'  => 'operacao',
                'divClass' => 'col-lg-2',
                'label' => 'Operação',
                'table' => [
                    'className' => 'Operacoes',
                    'field'     => 'id',
                    'operacao'  => 'in',
                    'type'      => 'select',
                    'options'   => $aOperacoes
                ]
            ],
            [
                'name'  => 'placa',
                'divClass' => 'col-lg-2',
                'label' => 'Placa',
                'table' => [
                    'className' => 'Veiculos',
                    'field'     => 'id',
                    'operacao'  => 'contem',
                    'type'      => 'select-ajax',
                    'arrayParamns' => [
                        'class'        => 'not-fix-width',
                        'label'        => false,
                        'null'         => true,
                        'search'       => true,
                        'name'         => 'veiculo_id_find',
                        'options'      =>  [],
                        'url'          => ['controller' => 'Veiculos', 'action' => 'filterQuerySelectpicker'],
                        'data'         => [
                            'busca' => '{{{q}}}',
                            'value' => 'descricao', 
                            'key'   => 'id'
                        ],
                        'options_ajax' => $aVeiculos,
                        'value'        => null,
                        'selected'     => null,
                    ]
                ]
            ],
            [
                'name'  => 'transportadora',
                'divClass' => 'col-lg-3',
                'label' => 'Transportadora',
                'table' => [
                    'className' => 'Transportadoras',
                    'field'     => 'id',
                    'operacao'  => 'contem',
                    'type'      => 'select-ajax',
                    'arrayParamns' => [
                        'class'        => 'not-fix-width',
                        'label'        => false,
                        'null'         => true,
                        'search'       => true,
                        'name'         => 'transportadora_id_find',
                        'options'      => [],
                        'url'          => ['controller' => 'Transportadoras', 'action' => 'filterQuerySelectpicker'],
                        'data'         => [
                            'busca' => '{{{q}}}',
                            'value' => 'razao_social', 
                            'key'   => 'id'
                        ],
                        'options_ajax' => $aTransportadoras,
                        'value'        => null,
                        'selected'     => null,
                    ]
                ]
            ],
            [
                'name'  => 'motorista',
                'divClass' => 'col-lg-3',
                'label' => 'Motorista',
                'table' => [
                    'className' => 'Pessoas',
                    'field'     => 'id',
                    'operacao'  => 'contem',
                    'type'      => 'select-ajax',
                    'arrayParamns' => [
                        'class'        => 'not-fix-width',
                        'label'        => false,
                        'null'         => true,
                        'search'       => true,
                        'name'         => 'pessoa_id_find',
                        'options'      => [],
                        'url'          => ['controller' => 'Pessoas', 'action' => 'filterQuerySelectpicker'],
                        'data'         => [
                            'busca' => '{{{q}}}',
                            'value' => 'descricao', 
                            'key'   => 'id'
                        ],
                        'options_ajax' => $aPessoas,
                        'value'        => null,
                        'selected'     => null,
                    ]
                ]
            ],
            [
                'name'  => 'container',
                'divClass' => 'col-lg-2',
                'label' => 'Container',
                'table' => [
                    'className' => 'ProgramacaoContainers.Containers',
                    'field'     => 'id',
                    'operacao'  => 'contem',
                    'type'      => 'select-ajax',
                    'arrayParamns' => [
                        'class'        => 'not-fix-width',
                        'label'        => false,
                        'null'         => true,
                        'search'       => true,
                        'name'         => 'container_id_find',
                        'options'      =>  [],
                        'url'          => ['controller' => 'Containers', 'action' => 'filterQuerySelectpicker'],
                        'data'         => [
                            'busca' => '{{{q}}}',
                            'value' => 'numero', 
                            'key'   => 'id'
                        ],
                        'options_ajax' => $aContainers,
                        'value'        => null,
                        'selected'     => null,
                    ]
                ]
            ],
            [
                'name'  => 'drive_espaco',
                'divClass' => 'col-lg-2',
                'label' => 'Drive Espaço',
                'table' => [
                    'className' => 'ProgramacaoContainers.DriveEspacos',
                    'field'     => 'id',
                    'operacao'  => 'contem',
                    'type'      => 'select-ajax',
                    'arrayParamns' => [
                        'class'        => 'not-fix-width',
                        'label'        => false,
                        'null'         => true,
                        'search'       => true,
                        'name'         => 'container_id_find',
                        'options'      =>  [],
                        'url'          => ['controller' => 'DriveEspacos', 'action' => 'filterQuerySelectpickerDriveEspacos'],
                        'data'         => [
                            'busca' => '{{{q}}}',
                            'value' => 'descricao', 
                            'key'   => 'id'
                        ],
                        'options_ajax' => $aDriveEspacos,
                        'value'        => null,
                        'selected'     => null,
                    ]
                ]
            ],
            [
                'name'  => 'armador',
                'divClass' => 'col-lg-2',
                'label' => 'Armador',
                'table' => [
                    'className' => 'ProgramacaoContainers.Containers.Armadores',
                    'field'     => 'id',
                    'operacao'  => 'contem',
                    'type'      => 'select-ajax',
                    'arrayParamns' => [
                        'class'        => 'not-fix-width',
                        'label'        => false,
                        'null'         => true,
                        'search'       => true,
                        'name'         => 'armador_id_find',
                        'options'      =>  [],
                        'url'          => ['controller' => 'Empresas', 'action' => 'filterQuerySelectpicker'],
                        'data'         => [
                            'busca' => '{{{q}}}',
                            'value' => 'descricao', 
                            'key'   => 'id'
                        ],
                        'options_ajax' => $aArmadores,
                        'value'        => null,
                        'selected'     => null,
                    ]
                ]
            ],
            [
                'name'  => 'cliente',
                'divClass' => 'col-lg-3',
                'label' => 'Cliente',
                'table' => [
                    'className' => 'ProgramacaoDocumentoTransportes.DocumentosTransportes.DocumentosMercadoriasMany.Clientes',
                    'field'     => 'id',
                    'operacao'  => 'contem',
                    'type'      => 'select-ajax',
                    'arrayParamns' => [
                        'class'        => 'not-fix-width',
                        'label'        => false,
                        'null'         => true,
                        'search'       => true,
                        'name'         => 'cliente_id_find',
                        'options'      =>  [],
                        'url'          => ['controller' => 'Empresas', 'action' => 'filterQuerySelectpicker'],
                        'data'         => [
                            'busca' => '{{{q}}}',
                            'value' => 'descricao', 
                            'key'   => 'id'
                        ],
                        'options_ajax' => $aClientes,
                        'value'        => null,
                        'selected'     => null,
                    ]
                ]
            ],
            [
                'name'  => 'beneficiario',
                'divClass' => 'col-lg-2',
                'label' => 'Beneficiario',
                'table' => [
                    'className' => 'ProgramacaoDocumentoTransportes.DocumentosTransportes.DocumentosMercadoriasMany.Beneficiarios',
                    'field'     => 'id',
                    'operacao'  => 'contem',
                    'type'      => 'select-ajax',
                    'arrayParamns' => [
                        'class'        => 'not-fix-width',
                        'label'        => false,
                        'null'         => true,
                        'search'       => true,
                        'name'         => 'beneficiario_id_find',
                        'options'      =>  [],
                        'url'          => ['controller' => 'Empresas', 'action' => 'filterQuerySelectpicker'],
                        'data'         => [
                            'busca' => '{{{q}}}',
                            'value' => 'descricao', 
                            'key'   => 'id'
                        ],
                        'options_ajax' => $aBeneficiarios,
                        'value'        => null,
                        'selected'     => null,
                    ]
                ]
            ],
            [
                'name'  => 'data_hora_programada_periodo',
                'divClass' => 'col-lg-4',
                'label' => 'Data',
                'table' => [
                    'className' => 'Programacoes',
                    'field'     => 'data_hora_programada',
                    'operacao'  => 'entre',
                    'type'      => 'date'
                ]
            ],
            [
                'name'  => 'data_hora_programada',
                'divClass' => 'col-lg-2',
                'label' => 'Data Programada',
                'table' => [
                    'className' => 'Programacoes',
                    'field'     => 'data_hora_programada',
                    'operacao'  => 'contem',
                    'type'      => 'date'
                ]
            ],
            [
                'name'  => 'data_hora_chegada',
                'divClass' => 'col-lg-2',
                'label' => 'Data Chegada',
                'table' => [
                    'className' => 'Programacoes',
                    'field'     => 'data_hora_chegada',
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

    public static function alterarSituacaoProgramacao($iProgramacaoID, $iProgramacaoSituacaoID, $that = null)
    {
        $oResponse = new ResponseUtil();

        $oProgramacao = LgDbUtil::getFind('Programacoes')
            ->contain(['Operacoes'])
            ->where(['Programacoes.id' => $iProgramacaoID])
            ->first();

        if (!$oProgramacao)
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('Não foi possível encontrar essa Programação!');

        $oProgramacao->programacao_situacao_id = $iProgramacaoSituacaoID;

        $oParamIntegracaoPosCntAgendar = ParametroGeral::getParameterByUniqueName('PARAM_INTEGRACAO_POS_CNT_AGENDAR');

        if ($oParamIntegracaoPosCntAgendar)
            HandlerIntegracao::do(@$oParamIntegracaoPosCntAgendar->id, ['programacao_id' => $oProgramacao->id]);

        if (LgDbUtil::save('Programacoes', $oProgramacao)) {
            if ($iProgramacaoSituacaoID == EntityUtil::getIdByParams('ProgramacaoSituacoes', 'descricao', 'Aprovado')
                && @$oProgramacao->operacao->gera_vistoria_auto) {
                $oResponse = Vistoria::gerarVistoriaExterna($oProgramacao->id);
            }

            if ($iProgramacaoSituacaoID == EntityUtil::getIdByParams('ProgramacaoSituacoes', 'descricao', 'Aprovado')
                && @$oProgramacao->operacao->gera_resv_auto) {
                $oResponse = Resv::gerarResvGeneric($that, $oProgramacao->id);
            }
            
            return $oResponse
                ->setStatus(200)
                ->setTitle('Sucesso!')
                ->setMessage('Situação alterada com sucesso!');
        }

        return $oResponse
            ->setStatus(400)
            ->setTitle('Ops!')
            ->setMessage('Erro ao alterar a Situação dessa Programação! ' . EntityUtil::dumpErrors($oProgramacao));
    }

    public static function verifyExistsItensProgramacao($iProgramacaoID)
    {
        $oProgramacao = LgDbUtil::get('Programacoes')->get($iProgramacaoID, [
            'contain' => array(
                'ProgramacaoDocumentoTransportes', 
                'ProgramacaoLiberacaoDocumentais',
                'ProgramacaoContainers'
            )
        ]);

        if (!$oProgramacao->programacao_documento_transportes && 
            !$oProgramacao->programacao_liberacao_documentais && 
            !$oProgramacao->programacao_containers) {
                return false;
        }

        return true;
    }

    public static function consistirDocProgResv($iProgramacaoId, $iDocId, $sTable)
    {
        $oProgramacao = LgDbUtil::getFind('Programacoes')
            ->contain(['Resvs' => [
                'ResvsDocumentosTransportes',
                'ResvsLiberacoesDocumentais',
                'ResvsContainers' => [
                    'ResvContainerLacres'
                ]
            ]])
            ->where(['Programacoes.id' => $iProgramacaoId])
            ->first();

        if (!$oProgramacao->resvs)
            return;

        $oResv = $oProgramacao->resvs[0];

        if ($sTable == 'containers') {
            foreach ($oProgramacao->programacao_containers as $oProgramacaoContainer) {
                $aData = ObjectUtil::getAsObject($oProgramacaoContainer, true);
                $aData['resv_id'] = $oResv->id;
    
                $aData['container_forma_uso_id'] = VistoriaItem::getDataContainerContainerFormaUso($aData);
    
                $oResvsContainers = LgDbUtil::saveNew('ResvsContainers', $aData);
    
                foreach ($oProgramacaoContainer->programacao_container_lacres as $oProgramacaoContainerLacre) {
                    $aData = ObjectUtil::getAsObject($oProgramacaoContainerLacre, true);
                    $aData['resv_container_id'] = $oResvsContainers->id;
        
                    $oResvContainerLacre = LgDbUtil::saveNew('ResvContainerLacres', $aData);
                }
            }

            Programacao::consisteTipoOperacao($iProgramacaoId, 'Programacoes');
            Programacao::consisteTipoOperacao($oResv->id, 'Resvs');

            return;
        }

        $sTableCamelize = 'Resvs' . Inflector::camelize($sTable);
        $aColumn = array_map(function($value) {
            return Inflector::singularize($value);
        }, explode('_', $sTable));

        $sTable = 'resvs_' . Inflector::pluralize($sTable);
        $sColumn = implode('_', $aColumn) . '_id';

        if (!isset($oResv->{$sTable}))
            return;

        foreach ($oResv->{$sTable} as $oResvDoc) {
            if ($oResvDoc->{$sColumn} == $iDocId)
                return;
        }

        $oDocEntity = LgDbUtil::get($sTableCamelize)->newEntity([
            'resv_id' => $oResv->id,
            $sColumn => $iDocId
        ]);

        LgDbUtil::get($sTableCamelize)->save($oDocEntity);

        Programacao::consisteTipoOperacao($iProgramacaoId, 'Programacoes');
        Programacao::consisteTipoOperacao($oResv->id, 'Resvs');
    }
    public static function consisteProgCarousel($sPlaca)
    {
        $oProgramacao = LgDbUtil::getFind('Programacoes')
                ->contain([
                    'Veiculos',
                    'Operacoes',
                    'ProgramacaoDriveEspacos' => [
                        'DriveEspacos'
                    ],
                    'ResvsFirstLeft',
                    'ProgramacaoVeiculos',
                ])
                ->where([
                    'Veiculos.descricao' => $sPlaca,
                    'ResvsFirstLeft.data_hora_saida IS NOT NULL'
                ])
                ->last();

        $iOperacaoCarousel = EntityUtil::getIdByParams('Operacoes', 'descricao', 'Carrossel (Carga)');
        $oDriveEspaco = isset($oProgramacao->programacao_drive_espacos[0])
            ? $oProgramacao->programacao_drive_espacos[0]->drive_espaco
            : null;

        $dDataEncerramento = $oDriveEspaco ? $oDriveEspaco->data_hora_validade : null;
        $bInDataPermitida = $dDataEncerramento 
            ? DateUtil::dateTimeFromDB(date('Y-m-d H:i:s'), 'Y-m-d H:i:s', ' ') < DateUtil::dateTimeFromDB($dDataEncerramento, 'Y-m-d H:i:s', ' ')
            : false;

        $bGeradoNovaProg = false;
        if ($oProgramacao && $oProgramacao->operacao->is_carrossel && $bInDataPermitida) {
            $aData = json_decode(json_encode($oProgramacao), true);
            $aDriveEspacos = $oProgramacao->programacao_drive_espacos;
            $aProgramacaoVeiculos = $oProgramacao->programacao_veiculos;
            $iProgramacaoOldId = $aData['id'];
            unset($aData['id']);
            unset($aData['resv_id']);
            unset($aData['veiculo']);
            unset($aData['resvs_first_left']);
            unset($aData['programacao_drive_espacos']);
            unset($aData['programacao_veiculos']);
            unset($aData['operacao']);
            unset($aData['codigo_externo']);
            $aData['data_hora_programada'] = DateUtil::dateTimeToDB(date('Y-m-d H:i'));
            $aData['data_hora_chegada'] = DateUtil::dateTimeToDB(date('Y-m-d H:i'));
            $oProgramacao = LgDbUtil::get('Programacoes')->newEntity($aData);
            if (LgDbUtil::get('Programacoes')->save($oProgramacao)) {
                $bGeradoNovaProg = true;

                foreach ($aDriveEspacos as $oDriveEspaco) {
                    $oProgramacaoDriveEspacos = LgDbUtil::get('ProgramacaoDriveEspacos')->newEntity([
                        'programacao_id' => $oProgramacao->id,
                        'drive_espaco_id' => $oDriveEspaco->drive_espaco_id
                    ]);
                    $oProgramacaoDriveEspacos = LgDbUtil::get('ProgramacaoDriveEspacos')->save($oProgramacaoDriveEspacos);
                }

                foreach ($aProgramacaoVeiculos as $oVeiculo) {
                    $oProgramacaoVeiculo = LgDbUtil::get('ProgramacaoVeiculos')->newEntity([
                        'sequencia_veiculo' => $oVeiculo->sequencia_veiculo,
                        'programacao_id' => $oProgramacao->id,
                        'veiculo_id' => $oVeiculo->veiculo_id
                    ]);
                    $oProgramacaoVeiculo = LgDbUtil::get('ProgramacaoVeiculos')->save($oProgramacaoVeiculo);
                }
            } else {
                $oResponseLog = (new ResponseUtil())
                    ->setMessage('Não foi gerado programação de carrossel ' . EntityUtil::dumpErrors($oProgramacao))
                    ->setDataExtra([
                        'drive_espaco' => @$oDriveEspaco->drive_espaco_id
                    ]);
                ReportResponse::saveLogResponse($oResponseLog, $iProgramacaoOldId, 'GERAÇÃO CARROSSEL', 'gate_automatico');
            }

        }

        if ($bGeradoNovaProg)
            return (new ResponseUtil())
                ->setStatus(200)
                ->setDataExtra($oProgramacao);

        $sMessage = 'Não foi possível gerar programação.';
        if (!$bGeradoNovaProg) {
            $sMessage .= ' Motivo: Não foi encontrado programação de carrousel para este veículo';
            return (new ResponseUtil())
                ->setMessage($sMessage)
                ->setDataExtra(null);
        }

        if (!$oProgramacao->operacao->is_carrossel) {
            $sMessage .= ' Motivo: A programação encontrada não de operação Carrossel';
            return (new ResponseUtil())
                ->setMessage($sMessage)
                ->setDataExtra(null);
        }

        if (!$bInDataPermitida) {
            $sMessage .= ' Motivo: Data atual excedeu a data de validade do drive espaço';
            return (new ResponseUtil())
                ->setMessage($sMessage)
                ->setDataExtra(null);
        }

        return (new ResponseUtil())
            ->setDataExtra(null);
    }

    public static function geraProgramacaoAuto($aData)
    {
        $oResponse = new ResponseUtil();

        $oGrade    = LgDbUtil::getFirst('GradeHorarios', ['id' => $aData['grade_horario_id']]);
        $aDataHora = explode('_', $aData['hora_programada']);

        $aDataInsert = [
            'data_hora_programada'    => DateUtil::dateTimeToDB(date('Y-m-d H:i:s',  @$aDataHora[0])),
            'grade_horario_id'        => @$aData['grade_horario_id'],
            'operacao_id'             => @$oGrade->operacao_id,
            'veiculo_id'              => EntityUtil::getIdByParams('Veiculos', 'descricao', 'TT01'),
            'transportadora_id'       => EntityUtil::getIdByParams('Transportadoras', 'razao_social', 'TRANSP. INTERNO'),
            'pessoa_id'               => EntityUtil::getIdByParams('Pessoas', 'descricao', 'OPERADOR TT'),
            'modal_id'                => EntityUtil::getIdByParams('Modais', 'descricao', 'Rodoviário'),
            'portaria_id'             => 1
        ];

        $sParamCamposNaoObrigatorios = ParametroGeral::getParametroWithValue('PARAM_CAMPOS_NAO_OBRIGATORIOS_PROGRAMACAO_AUTOMATICA');
        if ($sParamCamposNaoObrigatorios) {
            $oParamCamposNaoObrigatorios = json_decode($sParamCamposNaoObrigatorios);
            if (@$oParamCamposNaoObrigatorios->grades) {
                if (in_array($oGrade->id, @$oParamCamposNaoObrigatorios->grades)) {
                    if ($oParamCamposNaoObrigatorios) {
                        foreach ($oParamCamposNaoObrigatorios as $sKey => $iValue) {
                            if ($iValue == 1)
                                unset($aDataInsert[$sKey]);
                        }
                    }
                }
            }
        }

        if ($oGrade->gera_aprovacao_prog)
            $aDataInsert['programacao_situacao_id'] = EntityUtil::getIdByParams('ProgramacaoSituacoes', 'descricao', 'Aguardando aprovação');
        else
            $aDataInsert['programacao_situacao_id'] = EntityUtil::getIdByParams('ProgramacaoSituacoes', 'descricao', 'Aprovado');

        if (@$aData['documento']) {
            $oDocumento = LgDbUtil::getFind('DocumentosTransportes')
                ->contain([
                    'ContainerEntradas',
                    'DocumentosMercadoriasLote' => [
                        'DocumentosMercadoriasItens'
                    ]
                ])
                ->where(['DocumentosTransportes.id' => $aData['documento']])
                ->first();

            $aContainers = array_reduce($oDocumento->container_entradas, function($carry, $oCntEntrada) {
                $carry[] = $oCntEntrada->container_id;
                return $carry;
            }, []);

            $iQtdeContainerDoc = @$oDocumento->container_entradas ? count($oDocumento->container_entradas) : 0;
            if ($iQtdeContainerDoc && isset($aData['qtde_containers']) && @$aData['qtde_containers'] > $iQtdeContainerDoc)
                return $oResponse
                    ->setStatus(400)
                    ->setTitle('Ops!')
                    ->setMessage('Quantidade de container maior que a existente! Total: ' . $iQtdeContainerDoc);
    
            if (@$aData['qtde_containers'] && !$oGrade->gera_todos_containers) {
                $aContainers = $aData['qtde_containers'] > count($aContainers)
                    ? $aContainers
                    : array_chunk($aContainers, $aData['qtde_containers'])[0];
            } elseif (!$oGrade->gera_todos_containers) {
                $aContainers = $aData['containers'];
            }
        }

        $aContainers = @$aData['containers'] ?: $aContainers;
        
        $oResponseContainerPatio = Programacao::validaContainerPatio($aContainers);

        if ($oResponseContainerPatio->getStatus() != 200)
            return $oResponseContainerPatio;

        $oProgramacao = LgDbUtil::saveNew('Programacoes', $aDataInsert, true);

        if (!$oProgramacao)
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('Ocorreu algum erro ao gerar a Programação Automática!');


        $bVinculaDocAutoAgendar = ParametroGeral::getParametroWithValue('PARAM_VINCULA_DOC_AUTO_AGENDAR');

        $bGeraProgResumida  = $bInformaQtdeContainers = false;
        $bSolicitaDocumento = $bInformaQtdeContainers = $bSomenteContainer = false;
        
        if ($oGrade) {
            $bGeraProgResumida = $oGrade->gera_programacao_resumida ? true : false;
            $bSolicitaDocumento = $oGrade->solicita_documento ? true : false;
            $bSomenteContainer = $oGrade->somente_container ? true : false;
        }
        
        $bMostraCamposDoc = false;
        if (($bVinculaDocAutoAgendar && $bSolicitaDocumento) || ($bVinculaDocAutoAgendar && $bSomenteContainer))
            $bMostraCamposDoc = true;
                
        if ($bMostraCamposDoc) {
            if ($aData['tipo_documento'] == 'descarga')
                $oResponseVinculaDoc = self::vinculaDocContainersAuto($aData, $oProgramacao, $oGrade);
            else if ($aData['tipo_documento'] == 'carga')
                $oResponseVinculaDoc = self::vinculaLiberacaoDocumentalAuto($aData['documento'], $oProgramacao);

            if ($oResponseVinculaDoc->getStatus() != 200) {
                LgDbUtil::get('Programacoes')->delete($oProgramacao);
                return $oResponseVinculaDoc->setDataExtra($oProgramacao->id);
            }
        }

        $oOperacao = LgDbUtil::getByID('Operacoes', $oProgramacao->operacao_id);
        if ($oOperacao->obriga_anexos)
            return $oResponse
                ->setStatus(201)
                ->setType('warning')
                ->setTitle('Atenção!')
                ->setMessage('Necessário vincular os anexos a esta programação!')
                ->setDataExtra($oProgramacao->id);


        return $oResponse
            ->setStatus(200)
            ->setTitle('Sucesso!')
            ->setMessage('Programação Automática gerada com sucesso!')
            ->setDataExtra($oProgramacao->id);
    }

    private static function vinculaLiberacaoDocumentalAuto($iDocumentoID, $oProgramacao) 
    {
        $oResponse = new ResponseUtil();

        $aDataInsert = [
            'liberacao_documental_id' => $iDocumentoID,
            'programacao_id'          => $oProgramacao->id,
        ];

        $oProgramacaoLiberacaoDocumental = LgDbUtil::saveNew('ProgramacaoLiberacaoDocumentais', $aDataInsert, true);
        
        if ($oProgramacaoLiberacaoDocumental->hasErrors())
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('Ocorreu um erro ao vincular a Liberação Documental!');

        return $oResponse
            ->setStatus(200);
    }

    public static function isVistoria($oProgramacao)
    {
        if (!$oProgramacao->grade_horario_id)
            return false;

        $oGradeHorario = LgDbUtil::getByID('GradeHorarios', $oProgramacao->grade_horario_id);

        if ($oGradeHorario->is_vistoria == 0)
            return false;
        
        return true;
    }

    public static function managerDocumentoEntradaGenerico($iProgramacaoID)
    {
        $oResponse = new ResponseUtil();

        $oProgramacao = LgDbUtil::getFind('Programacoes')
            ->contain('Operacoes')
            ->where(['Programacoes.id' => $iProgramacaoID])
            ->first();

        $oOrdemServicos = LgDbUtil::getFind('OrdemServicos')
            ->where(['OrdemServicos.resv_id' => $oProgramacao->resv_id])
            ->toArray();

        if (!$oOrdemServicos)
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('Não foram encontradas Ordens de Serviços para essa Programação!');

        $aDocumentoData = self::getDataInsertDocEntradaGenerico($oOrdemServicos[0], $oProgramacao->id);

        $oResponse = DocumentosMercadoriasManage::saveConhecimento($aDocumentoData);
        if ($oResponse->getStatus() != 200)
            return $oResponse;

        $oDocumentoGenerico = $oResponse->getDataExtra();

        foreach ($oOrdemServicos as $oOrdemServico) {

            $oResponse = self::saveContainerEntradasByDocGenerico($oDocumentoGenerico, $oOrdemServico->container_exclusivo_id);
            if ($oResponse->getStatus() != 200)
                return $oResponse;

            $oResponse = self::setDesovaIncrementalByOs($oOrdemServico);
            if ($oResponse->getStatus() != 200)
                return $oResponse;

            $oResponse = self::saveResvsDocumentosTransportesByDocGenerico($oDocumentoGenerico, $oOrdemServico->resv_id);
            if ($oResponse->getStatus() != 200)
                return $oResponse;

            $oResponse = self::saveProgramacaoDocumentoTransportesByDocGenerico($oDocumentoGenerico, $oProgramacao->id);
            if ($oResponse->getStatus() != 200)
                return $oResponse;

        }

        return $oResponse
            ->setStatus(200);
    }

    private static function getDataInsertDocEntradaGenerico($oOrdemServico, $iProgramacaoID)
    {
        return [
            'transporte' => [
                'save_by_search_forced' => false,
                'numero'                => $oOrdemServico->id,
                'empresa_id'            => Empresa::getEmpresaPadrao(),
                'modal_id'              => EntityUtil::getIdByParams('Modais', 'descricao', 'Rodoviário'),
                'tipo_documento_id'     => 1
            ],
            'masters' => [   
                [       
                    'save_by_search_forced' => false,
                    'save'                  => true,
                    'numero_documento'      => $oOrdemServico->id,
                    'empresa_id'            => Empresa::getEmpresaPadrao(),
                    'modal_id'              => EntityUtil::getIdByParams('Modais', 'descricao', 'Rodoviário'),
                    'houses' => [
                        [
                            'save_by_search_forced'      => false,
                            'save'                       => true,
                            'numero_documento'           => $oOrdemServico->id,
                            'data_emissao'               => date('Y-m-d'),
                            'empresa_id'                 => Empresa::getEmpresaPadrao(),
                            'cliente_id'                 => self::getClienteIdProgramacaoContainers($oOrdemServico->container_exclusivo_id, $iProgramacaoID) ?: 1,
                        ],
                    ],
                ],
            ],
        ];
    }

    private static function getClienteIdProgramacaoContainers($iContainerID, $iProgramacaoID)
    {
        $oProgramacaoContainer = LgDbUtil::getFirst('ProgramacaoContainers', [
            'container_id'   => $iContainerID,
            'programacao_id' => $iProgramacaoID,
        ]);

        if (!$oProgramacaoContainer)
            return null;

        return $oProgramacaoContainer->cliente_id;
    }

    private static function setDesovaIncrementalByOs($oOrdemServico)
    {
        $oResponse = new ResponseUtil();

        $oOrdemServico->desova_incremental = 1;
        $oOrdemServico = LgDbUtil::save('OrdemServicos', $oOrdemServico, true);

        if ($oOrdemServico->hasErrors())
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('Ocorreu um erro ao atualizar os dados da Ordem de Serviço!');

        return $oResponse
            ->setStatus(200);
    }

    private static function saveContainerEntradasByDocGenerico($oDocumentoGenerico, $iContainerID)
    {
        $oResponse = new ResponseUtil();

        $aDataInsert = [
            'documento_transporte_id' => $oDocumentoGenerico['entities'][0]['documento_transporte_id'],
            'container_id'            => $iContainerID
        ];

        $oContainerEntradas = LgDbUtil::getOrSaveNew('ContainerEntradas', $aDataInsert, true);
        if ($oContainerEntradas->hasErrors())
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('Ocorreu um erro ao inserir o Container no Documento de Transporte!');

        return $oResponse
            ->setStatus(200);
    }

    private static function saveResvsDocumentosTransportesByDocGenerico($oDocumentoGenerico, $iResvID)
    {
        $oResponse = new ResponseUtil();

        $aDataInsert = [
            'documento_transporte_id' => $oDocumentoGenerico['entities'][0]['documento_transporte_id'],
            'resv_id'                 => $iResvID
        ];

        $oResvDocumentoTransporte = LgDbUtil::getOrSaveNew('ResvsDocumentosTransportes', $aDataInsert, true);
        if ($oResvDocumentoTransporte->hasErrors())
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('Ocorreu um erro ao inserir o Documento de Transporte na Resv!');

        return $oResponse
            ->setStatus(200);
    }

    private static function saveProgramacaoDocumentoTransportesByDocGenerico($oDocumentoGenerico, $iProgramacaoID)
    {
        $oResponse = new ResponseUtil();

        $aDataInsert = [
            'documento_transporte_id' => $oDocumentoGenerico['entities'][0]['documento_transporte_id'],
            'programacao_id'          => $iProgramacaoID
        ];

        $oProgramacaoDocumentoTransporte = LgDbUtil::getOrSaveNew('ProgramacaoDocumentoTransportes', $aDataInsert, true);
        if ($oProgramacaoDocumentoTransporte->hasErrors())
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('Ocorreu um erro ao inserir o Documento de Transporte na Programação!');

        return $oResponse
            ->setStatus(200);
    }

    public static function saveProgQrCode($oUsuarioVinculos, $iCodigoBarraID)
    {
        $oResponse = new ResponseUtil();

        $aDataInsert = [
            'data_hora_programada'    => DateUtil::dateTimeToDB(date('Y-m-d H:i:s')),
            'operacao_id'             => EntityUtil::getIdByParams('Operacoes', 'descricao', 'Descarga'),
            'veiculo_id'              => $oUsuarioVinculos['veiculo']->veiculo_id,
            'transportadora_id'       => $oUsuarioVinculos['transportadora']->transportadora_id,
            'pessoa_id'               => $oUsuarioVinculos['motorista']->pessoa_id,
            'modal_id'                => EntityUtil::getIdByParams('Modais', 'descricao', 'Rodoviário'),
            'portaria_id'             => EntityUtil::getIdByParams('Portarias', 'descricao', 'GATE'),
            'codigo_barra_id'         => $iCodigoBarraID ?: null
        ];

        $oProgramacao = LgDbUtil::saveNew('Programacoes', $aDataInsert, true);
        if ($oProgramacao->hasErrors())
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('Ocorreu algum erro ao gerar a Programação pelo QR Code!');

        return $oResponse
            ->setStatus(200)
            ->setDataExtra($oProgramacao->id);
    }

    public static function saveProgDocTransporteQrCode($iProgramacaoID, $iDocumentoTransporteID)
    {
        $oResponse = new ResponseUtil();

        $aDataInsert = [
            'programacao_id' => $iProgramacaoID,
            'documento_transporte_id' => $iDocumentoTransporteID
        ];

        $oProgDocTransporte = LgDbUtil::saveNew('ProgramacaoDocumentoTransportes', $aDataInsert, true);
        if ($oProgDocTransporte->hasErrors())
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('Ocorreu algum erro ao vincular o Documento na Programação gerada pelo QR Code!');

        $oDocumentoMercadoriaEntity = new DocumentosMercadoria;
        $oDocumentoMercadoriaEntity->generateLoteCodigo(null, $iDocumentoTransporteID);

        return $oResponse
            ->setStatus(200);
    }

    public static function vinculaDocContainersAuto($aData, $oProgramacao, $oGrade)
    {
        $aContainers = [];
        if (@$aData['documento']) {
            $oDocumento = LgDbUtil::getFind('DocumentosTransportes')
                ->contain([
                    'ContainerEntradas',
                    'DocumentosMercadoriasLote' => [
                        'DocumentosMercadoriasItens'
                    ]
                ])
                ->where(['DocumentosTransportes.id' => $aData['documento']])
                ->first();

            if (!@$oDocumento->documentos_mercadoria[0]->documentos_mercadorias_itens) {

                $oResponse = DocumentosTransporte::deleteDocumentosTransportes($oDocumento->id);

                return (new ResponseUtil())
                    ->setMessage('Documento foi integrado sem itens, favor tente novamente.');
            }

            if(@$aData['despachante']){
                $saveDespechanteDoc = self::saveDespechanteDoc($aData['despachante'], $oDocumento);
                if(!$saveDespechanteDoc){
                    return (new ResponseUtil())
                        ->setMessage('Não foi possivel salvar o despachante no documento de entrada');
                }
            }

            $aContainers = array_reduce($oDocumento->container_entradas, function($carry, $oCntEntrada) {
                $carry[] = $oCntEntrada->container_id;
                return $carry;
            }, []);
    
            if (@$aData['qtde_containers'] && !$oGrade->gera_todos_containers) {
                $aContainers = $aData['qtde_containers'] > count($aContainers)
                    ? $aContainers
                    : array_chunk($aContainers, $aData['qtde_containers'])[0];
            } elseif (!$oGrade->gera_todos_containers) {
                $aContainers = $aData['containers'];
            }
        }

        $oRequest = self::saveProgramacaoContainerFromDocumento([
            'operacao_id_doc_entrada_saida' => $oProgramacao->operacao_id,
            'documento' => @$aData['documento'] ?: null,
            'documento_containers' => $aContainers ?: $aData['containers'],
            'tipo_container' => 'CHEIO',
            'drive_espaco_id' => null
        ], $oProgramacao->id);

        if ($oRequest->getStatus() != 200)
            return $oRequest;

        if (!@$aData['documento'])
            return $oRequest;

        $iDocumentoId = $aData['documento'];

        if (Resv::isCarga($oProgramacao)) { //CARGA

            $oResponse = Programacao::saveProgramacaoCargaResponse($iDocumentoId, $oProgramacao->id);

        }elseif (Resv::isDescarga($oProgramacao) || Resv::isDesova($oProgramacao)) {
            
            $oResponse = Programacao::saveProgramacaoDescargaGeneric($oProgramacao->id, $iDocumentoId);
        }

        if ($oResponse->getStatus() != 200)
            return $oResponse;

        return $oResponse;
    }

    public static function saveDespechanteDoc($iDespachante, $oDocumento)
    {

        $aDocumentosMercadorias = LgDbUtil::getAll('DocumentosMercadorias', ['documento_transporte_id' => $oDocumento->id]);

        foreach($aDocumentosMercadorias as $value) {
            $oDocumentoMercadoria = LgDbUtil::getByID('DocumentosMercadorias', $value->id);
            $oDocumentoMercadoria->despachante_id = $iDespachante;
            if(!LgDbUtil::save('DocumentosMercadorias', $oDocumentoMercadoria)) {
                return false;
            }
        }
        return true;
    }

    public static function getDataDocSchedule($iDocumentoId, $oGrade)
    {
        if (!$iDocumentoId) {
            if ($oGrade) {
                if (Resv::isCarga(null, $oGrade->operacao_id)) {
                    $aDocumentos = LgDbUtil::get('LiberacoesDocumentais')
                        ->find('list', ['keyField' => 'id', 'valueField' => 'numero'])
                        ->toArray();
                    return [
                        'documentos' => $aDocumentos,
                        'containers' => []
                    ];
                }
            }

            $aDocumentos = LgDbUtil::get('DocumentosTransportes')
                ->find('list', ['keyField' => 'id', 'valueField' => 'numero'])
                ->toArray();
            return [
                'documentos' => $aDocumentos,
                'containers' => []
            ];
        }

        if ($oGrade) {
            if (Resv::isCarga(null, $oGrade->operacao_id)) {
                $aDocumentos = LgDbUtil::get('LiberacoesDocumentais')
                    ->find('list', ['keyField' => 'id', 'valueField' => 'numero'])
                    ->where(['id' => $iDocumentoId])
                    ->toArray();
            } else if (Resv::isDescarga(null, $oGrade->operacao_id) || $oGrade->is_vistoria || Resv::isDesova(null, $oGrade->operacao_id)) {
                $aDocumentos = LgDbUtil::get('DocumentosTransportes')
                    ->find('list', ['keyField' => 'id', 'valueField' => 'numero'])
                    ->where(['id' => $iDocumentoId])
                    ->toArray();
            }
        } else {
            $aDocumentos = LgDbUtil::get('DocumentosTransportes')
                ->find('list', ['keyField' => 'id', 'valueField' => 'numero'])
                ->where(['id' => $iDocumentoId])
                ->toArray();
        }

        $aContainers = LgDbUtil::get('ContainerEntradas')
            ->find('list', ['keyField' => 'container_id', 'valueField' => 'container_numero'])
            ->select([
                'container_id',
                'container_numero' => 'Containers.numero'
            ])
            ->innerJoinWith('Containers')
            ->where(['ContainerEntradas.documento_transporte_id' => $iDocumentoId])
            ->toArray();

        return [
            'documentos' => $aDocumentos,
            'containers' => $aContainers
        ];
    }

    public static function consisteIntegracaoPosContainer($oProgramacao, $aProgramacaoData)
    {
        $iProgSituacaoAprovado = EntityUtil::getIdByParams('ProgramacaoSituacoes', 'descricao', 'Aprovado');
        if ($oProgramacao->programacao_situacao_id != $iProgSituacaoAprovado 
            && @$aProgramacaoData['programacao_situacao_id'] == $iProgSituacaoAprovado) {

                $oParamIntegracaoPosCntAgendar = ParametroGeral::getParameterByUniqueName('PARAM_INTEGRACAO_POS_CNT_AGENDAR');

                if ($oParamIntegracaoPosCntAgendar)
                    HandlerIntegracao::do(@$oParamIntegracaoPosCntAgendar->id, ['programacao_id' => $oProgramacao->id]);
        }
    }
    
    public static function geraProgramacaoGateAutoByPlanejamentoVeiculos($sPlaca)
    {
        $oResponse = new ResponseUtil();

        $oVeiculo = LgDbUtil::getFind('Veiculos')
            ->where(['Veiculos.veiculo_identificacao' => $sPlaca])
            ->first();

        if (!$oVeiculo)
            return $oResponse
                ->setStatus(400)
                ->setMessage('Veiculo não cadastrado no sistema!');

        $oLastResv = LgDbUtil::getFind('Resvs')
            ->where(['Resvs.veiculo_id' => $oVeiculo->id])
            ->order(['Resvs.id' => 'DESC'])
            ->first();

        $oUsuarioVeiculo = LgDbUtil::getFind('UsuarioVeiculos')
            ->where(['UsuarioVeiculos.veiculo_id' => $oVeiculo->id])
            ->order(['UsuarioVeiculos.id' => 'DESC'])
            ->first();

        if (!$oLastResv && !$oUsuarioVeiculo)
            return $oResponse
                ->setStatus(400)
                ->setMessage('Não foi possível gerar programação automatica, pois esse veiculo não possui Resv anterior nem vinculo com algum usuario!');

        $oResponse = PlanejamentoMovimentacaoVeiculo::getByVeiculo($oVeiculo->id);
        if ($oResponse->getStatus() != 200)
            return $oResponse;

        $oPlanejamentoVeiculo = $oResponse->getDataExtra();
        if ($oPlanejamentoVeiculo->planejamento_movimentacao_produto->controle_producao_id) {
            $oResponse = ControleProducao::check($oPlanejamentoVeiculo->planejamento_movimentacao_produto->controle_producao_id);
            if ($oResponse->getStatus() != 200)
                return $oResponse;
        }

        $oResponse = DocumentosTransporte::getDocTransporteIdByProdutoId($oPlanejamentoVeiculo->planejamento_movimentacao_produto->produto_id);
        if ($oResponse->getStatus() != 200)
                return $oResponse;

        $iDocumentoTransporteID = $oResponse->getDataExtra();

        $oResponse = self::saveProgramacaoGateAutoByPlanejamentoVeiculos($oPlanejamentoVeiculo, $oVeiculo, $oLastResv, $oUsuarioVeiculo, $iDocumentoTransporteID);
        if ($oResponse->getStatus() != 200)
            return $oResponse;

        $iProgramacaoID = $oResponse->getDataExtra(); 
        $oResponse = self::saveProgDocTransporteQrCode($iProgramacaoID, $iDocumentoTransporteID);
        if ($oResponse->getStatus() != 200)
            return $oResponse;

        $oProgramacao = LgDbUtil::getFind('Programacoes')
            ->contain(['Pessoas', 'Transportadoras', 'Operacoes'])
            ->where(['Programacoes.id' => $iProgramacaoID])
            ->first();

        $oDocTransporte = LgDbUtil::getFind('DocumentosTransportes')
            ->where(['DocumentosTransportes.id' => $iDocumentoTransporteID])
            ->first();

        return (new ResponseUtil())
            ->setStatus(200)
            ->setMessage('Programação gerada com sucesso!')
            ->setDataExtra([
                'id' => $oProgramacao->id,
                'motorista' => $oProgramacao->pessoa->descricao,
                'transportadora' => $oProgramacao->transportadora->razao_social,
                'operação' => $oProgramacao->operacao->descricao,
                'documento' => $oDocTransporte->numero,
                'containers' => ''
            ]);
    }

    private static function saveProgramacaoGateAutoByPlanejamentoVeiculos($oPlanejamentoVeiculo, $oVeiculo, $oLastResv, $oUsuarioVeiculo)
    {
        $oResponse = new ResponseUtil();

        if ($oLastResv) {
            $aDataInsert = [
                'operacao_id'          => $oLastResv->operacao_id,
                'transportadora_id'    => $oLastResv->transportador_id,
                'pessoa_id'            => $oLastResv->pessoa_id,
                'modal_id'             => $oLastResv->modal_id,
                'portaria_id'          => $oLastResv->portaria_id,
                'veiculo_id'           => $oVeiculo->id,
                'data_hora_programada' => date('Y-m-d H:i:s'),
                'data_hora_chegada'    => date('Y-m-d H:i:s'),
            ];
        } else {
            $oUsuarioVinculos = Usuario::getVinculos(SessionUtil::getUsuarioConectado());

            $oUsuarioVinculos['transportadora'] = LgDbUtil::getFind('UsuarioTransportadoras')
                ->where(['UsuarioTransportadoras.usuario_id' => SessionUtil::getUsuarioConectado()])
                ->order([
                    'UsuarioTransportadoras.id' => 'DESC'
                ])
                ->first();

            $aDataInsert = [
                'operacao_id'          => $oPlanejamentoVeiculo->planejamento_movimentacao_produto->operacao_id,
                'transportadora_id'    => $oUsuarioVinculos['transportadora']->transportadora_id,
                'pessoa_id'            => $oUsuarioVinculos['motorista']->pessoa_id,
                'modal_id'             => EntityUtil::getIdByParams('Modais', 'descricao', 'Rodoviário'),
                'portaria_id'          => EntityUtil::getIdByParams('Portarias', 'descricao', 'GATE'),
                'veiculo_id'           => $oUsuarioVinculos['veiculo']->veiculo_id,
                'data_hora_programada' => date('Y-m-d H:i:s'),
                'data_hora_chegada'    => date('Y-m-d H:i:s'),
            ];
        }

        $oProgramacao = LgDbUtil::saveNew('Programacoes', $aDataInsert, true);
        if ($oProgramacao->hasErrors())
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('Ocorreu algum erro ao gerar a Programação pelo QR Code!');

        return $oResponse
            ->setStatus(200)
            ->setDataExtra($oProgramacao->id);
    }

    public static function getClienteDocumento($oProgramacao)
    {
        if (!@$oProgramacao->grade_horario)
            return null;

        if (@$oProgramacao->grade_horario->gera_programacao_auto != 1)
            return null;

        $oParamIntegracaoTranportadora = ParametroGeral::getParameterByUniqueName('PARAM_INTEGRACAO_TRANSPORTADORA');
        if (!@$oParamIntegracaoTranportadora)
            return null;

        $oParamDecode = json_decode(@$oParamIntegracaoTranportadora->valor);
        if (@$oParamDecode->ativo != 1)
            return null;

        if (Perfil::isAdmin()) {
            $oEmpresa = LgDbUtil::getByID('Empresas', Empresa::getEmpresaPadrao());
            return @$oEmpresa->cnpj;
        }

        if (Resv::isDescarga(null, @$oProgramacao->operacao_id)) {

            if (!@$oProgramacao->programacao_documento_transportes)
                return null;

            foreach (@$oProgramacao->programacao_documento_transportes as $oProgDocTransporte) {
                foreach (@$oProgDocTransporte->documentos_mercadorias as $oDocMercadoria) {
                    if (@$oDocMercadoria->cliente_id) {
                        @$oEmpresa = LgDbUtil::getByID('Empresas', @$oDocMercadoria->cliente_id);
                        return @$oEmpresa->cnpj;
                    }
                }
            }

        } else if (Resv::isCarga(null, @$oProgramacao->operacao_id)) {

            if (!@$oProgramacao->programacao_liberacao_documentais)
                return null;

            foreach (@$oProgramacao->programacao_liberacao_documentais as $oProgLiberacao) {
                if (@$oProgLiberacao->liberacoes_documental->cliente_id) {
                    $oEmpresa = LgDbUtil::getByID('Empresas', @$oProgLiberacao->cliente_id);
                    return @$oEmpresa->cnpj;
                }
            }

        }

        return null;
    }

    public static function validaContainerPatio($aContainers)
    {
        if (!$aContainers)
            return (new ResponseUtil())
                ->setStatus(200)
                ->setMessage('Sem informação de containers!');

        $aGradesNaoIntegram = json_decode(
            ParametroGeral::getParametroWithValue('PARAM_GRADES_VALIDAM_POS_CONTAINER'), true);

        $aGradesNaoIntegram = @$aGradesNaoIntegram['grades'] ?: [];

        if(@$aContainers['grade_horario_id'] && !in_array($aContainers['grade_horario_id'], $aGradesNaoIntegram))
            return (new ResponseUtil())
                ->setStatus(200)
                ->setMessage('Grade sem validação de posição de container!');

        $oParamIntegracaoPosCntDesova = ParametroGeral::getParameterByUniqueName('PARAM_INTEGRACAO_POS_CNT_DESOVA');

        $aValorParam = @$oParamIntegracaoPosCntDesova->valor ? json_decode(@$oParamIntegracaoPosCntDesova->valor, true) : [];

        if (!isset($aValorParam['ativo']) || !@$aValorParam['ativo'])
            return (new ResponseUtil())
                ->setStatus(200)
                ->setMessage('Parâmetro não ativado!');

        $aContainers = LgDbUtil::getFind('Containers')
            ->where(['id IN' => $aContainers])
            ->toArray();
        
        $aNumberContainers = [];   
        foreach ($aContainers as $oContainer) {
            $aNumberContainers[] = $oContainer->numero;
        }

        $uRequest = HandlerIntegracao::do(@$oParamIntegracaoPosCntDesova->id, [
            'containers' => $aNumberContainers
        ]);

        $aPosContainers = is_array($uRequest) ? $uRequest : [$uRequest];

        foreach ($aPosContainers as $key => $aContainer) {
            foreach ($aContainer as $numero => $aContainerPos) {
                if ($aContainerPos == 'Não está no pátio')
                    return (new ResponseUtil())
                        ->setMessage('Container '.$numero.' não está no pátio!');
            }
        }

        return (new ResponseUtil())
            ->setStatus(200)
            ->setMessage('Todos containers estão em pátio!');
            
    }

}


        