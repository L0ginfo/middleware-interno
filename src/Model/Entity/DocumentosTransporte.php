<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use App\Model\Entity\TipoDocumento;
use Cake\Datasource\ConnectionManager;
use App\Util\DateUtil;
use App\Util\EntityUtil;
use App\Model\Entity\DocumentosMercadoria;
use App\Model\Entity\Procedencia;
use App\Model\Entity\TratamentosCarga;
use App\Model\Entity\NaturezasCarga;
use App\Model\Entity\Empresa;
use App\Util\ArrayUtil;
use App\Util\LeitorArquivosUtil;
use App\Util\ResponseUtil;
use Cake\Http\Client;
use Cake\Http\Client\Response;
use Cake\Http\Session;
use Cake\ORM\Locator\TableLocator;
use Cake\ORM\TableRegistry;
use Psr\Http\Message\StreamInterface;
use App\Model\Entity\ItemContainer;
use App\RegraNegocio\DocumentosMercadorias\Mantra\EntregaLiberacao;
use App\RegraNegocio\DocumentosMercadorias\Mantra\RegistraEncerraTermo;
use App\Util\DoubleUtil;
use App\Util\LgDbUtil;
use App\Util\SessionUtil;

/**
 * DocumentosTransporte Entity
 *
 * @property int $id
 * @property string $numero
 * @property \Cake\I18n\Date|null $data_emissao
 * @property float|null $valor_total
 * @property float|null $quantidade
 * @property float|null $peso_bruto
 * @property float|null $peso_liquido
 * @property float|null $valor_frete
 * @property float|null $valor_seguro
 * @property string|null $numero_voo
 * @property int|null $modal_id
 * @property int|null $cliente_id
 * @property int|null $despachante_id
 * @property int|null $agente_id
 * @property int|null $parceiro_id
 * @property int|null $tipo_documento_id
 * @property int $empresa_id
 *
 * @property \App\Model\Entity\Modal $modal
 * @property \App\Model\Entity\Empresa $empresa
 * @property \App\Model\Entity\TipoDocumento $tipo_documento
 */
class DocumentosTransporte extends Entity
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
    protected $_accessible = [
        'numero' => true,
        'data_emissao' => true,
        'valor_total' => true,
        'quantidade' => true,
        'peso_bruto' => true,
        'peso_liquido' => true,
        'valor_frete' => true,
        'valor_seguro' => true,
        'navio_aeronave' => true,
        'numero_voo' => true,
        'modal_id' => true,
        'cliente_id' => true,
        'despachante_id' => true,
        'agente_id' => true,
        'parceiro_id' => true,
        'tipo_documento_id' => true,
        'empresa_id' => true,
        'modal' => true,
        'empresa' => true,
        'tipo_documento' => true,
        'resv' => true,
        'resvs_documentos_transporte' => true,
        'documentos_mercadoria' => true,
        'chave_nf' =>true,
        'serie_nf' =>true,
        'planejamento_maritimo_id' =>true,
    ];
    
    private $sLinksApiMantra = [
        'host' => 'http://ec2-3-135-167-34.us-east-2.compute.amazonaws.com:5000/',
        'requisita_documentos' => 'Comex/documentos',
        'registra_termo' => 'Comex/termo',
        'encerra_termo' => 'Comex/encerramento',
        'entrega_termo' => 'Comex/entrega'
    ];

    public $iDocumentoTransporteIdSalvo;

    public function getDocumentosTransportes($that, $documento = null, $tipoDocumento = null)
    {
        $aDocumentos = array();
        $documento  = $that->request->getQuery('documento');
        $tipoDocumento  = $that->request->getQuery('tipo');
        $where = 'WHERE situacao != "os_finalizada_resvs_finalizada"';
        $bHaveFilters = $that->request->getQuery('log_filter') ? true : false;
        $bPrecisaEmpresaVinculadas = Perfil::precisaEmpresasVinculadas();
        $aExtraConditions = [];

        if (!$bHaveFilters) {
            $aExtraConditions = [
                function($exp , $q) {
                    return $exp->notExists(
                        LgDbUtil::getFind('ResvsDocumentosTransportes')->select('ResvsDocumentosTransportes.id')->contain(['Resvs', 'OrdemServicos'])->where([
                            'ResvsDocumentosTransportes.documento_transporte_id = DocumentosTransportes.id',
                            'OrdemServicos.data_hora_inicio IS NOT NULL',
                            'OrdemServicos.data_hora_fim    IS NOT NULL',
                            'Resvs.data_hora_chegada IS NOT NULL',
                            'Resvs.data_hora_saida   IS NOT NULL'
                        ])
                    );
                }
            ];
        }

        if($documento){
            switch ($tipoDocumento) {
                case 1:
                    $where= "WHERE transporte_numero = '$documento'";
                    break;
                
                case 2:
                    $where= "WHERE master_numero_documento = '$documento'";
                    break;
            }
        }

        $aDocumentos = LgDbUtil::getFind('DocumentosTransportes')
                        ->select([
                            'data_emissao' => 'DocumentosTransportes.data_emissao',
                            'transporte_numero' => 'DocumentosTransportes.numero',
                            'navio_aeronave' => 'DocumentosTransportes.navio_aeronave',
                            'transporte_id' => 'DocumentosTransportes.id',
                            'master_numero_documento' => '1',
                            'acao' => '1',
                            'master_numero_documento' => LgDbUtil::getFind('DocumentosTransportes')->newExpr()->add(
                                LgDbUtil::setConcatGroupByDb('DocumentosMercadorias.numero_documento')
                            ),
                            'cliente' => LgDbUtil::getFind('DocumentosMercadorias')->newExpr()->add(
                                LgDbUtil::setConcatGroupByDb('Clientes.descricao')
                            ),
                            'beneficiario' => LgDbUtil::getFind('DocumentosMercadorias')->newExpr()->add(
                                LgDbUtil::setConcatGroupByDb('Beneficiarios.descricao')
                            ),
                            'containers' => LgDbUtil::setConcatGroupByDb('Containers.numero'),
                            'formacao_lotes_consolidado' => 'COUNT(FormacaoLotesConsolidado.id)',
                            'documento_transporte_situacao' => env('DB_ADAPTER') == 'sqlsrv' ? 'CAST(DocumentoTransporteSituacoes.descricao AS VARCHAR(100))' : 'DocumentoTransporteSituacoes.descricao'
                        ])
                        ->select([
                            'situacao' => "CASE 
                            WHEN (SELECT count(1) 
                                    FROM resvs_documentos_transportes rdt, resvs r, ordem_servicos os
                                    WHERE DocumentosTransportes.id       = rdt.documento_transporte_id
                                        AND rdt.resv_id = r.id
                                        AND os.resv_id  = rdt.resv_id
                                        AND os.data_hora_inicio IS NOT NULL
                                        AND os.data_hora_fim    IS NOT NULL
                                        AND r.data_hora_chegada IS NOT NULL
                                        AND r.data_hora_saida   IS NOT NULL) = 1
                                    THEN 'os_finalizada_resvs_finalizada'
                            WHEN (SELECT count(1)  
                                    FROM resvs_documentos_transportes rdt, resvs r, ordem_servicos os
                                    WHERE DocumentosTransportes.id       = rdt.documento_transporte_id
                                        AND rdt.resv_id = r.id
                                        AND os.resv_id  = rdt.resv_id
                                        AND os.data_hora_inicio IS NOT NULL
                                        AND os.data_hora_fim    IS NOT NULL
                                        AND r.data_hora_chegada IS NOT NULL
                                        AND r.data_hora_entrada IS NOT NULL
                                        AND r.data_hora_saida   IS NULL) = 1
                                    THEN 'os_finalizada'
                            WHEN (SELECT count(1) 
                                    FROM resvs_documentos_transportes rdt, resvs r
                                    WHERE DocumentosTransportes.id = rdt.documento_transporte_id
                                        AND rdt.resv_id = r.id
                                        AND data_hora_chegada IS NOT NULL
                                        AND data_hora_entrada IS NULL
                                        AND data_hora_saida IS NULL) = 1
                            THEN 'chegada_informada'
                            WHEN (SELECT count(1) 
                                    FROM resvs_documentos_transportes rdt, resvs r
                                    WHERE DocumentosTransportes.id = rdt.documento_transporte_id
                                        AND rdt.resv_id = r.id
                                        AND data_hora_chegada IS NOT NULL
                                        AND data_hora_entrada IS NOT NULL
                                        AND data_hora_saida IS NULL) = 1
                            THEN 'em_descarga'
                            WHEN (SELECT count(1) 
                                    FROM resvs_documentos_transportes rdt, resvs r
                                    WHERE DocumentosTransportes.id = rdt.documento_transporte_id
                                        AND rdt.resv_id = r.id
                                        AND data_hora_chegada IS NOT NULL
                                        AND data_hora_entrada IS NOT NULL
                                        AND data_hora_saida IS NOT NULL) = 1
                            THEN 'finalizado'
                            WHEN (SELECT count(1)
                                    WHERE NOT EXISTS (SELECT 1
                                                    FROM resvs_documentos_transportes rdt
                                                    WHERE rdt.documento_transporte_id = DocumentosTransportes.id) ) = 1
                            THEN 'informar_chegada' end"
                        ])
                        ->contain(['ResvsDocumentosTransportesLeft', 'DocumentosMercadorias' => ['DocumentosMercadoriasItens' => ['Produtos']]])
                        ->leftJoinWith('DocumentosMercadorias')
                        ->leftJoinWith('DocumentosMercadorias.Clientes')
                        ->leftJoinWith('DocumentosMercadorias.Beneficiarios')
                        ->leftJoinWith('ItemContainers.Containers')
                        ->leftJoinWith('FormacaoLotesConsolidado')
                        ->leftJoinWith('DocumentoTransporteSituacoes')
                        ->where($aExtraConditions)
                        ->group([
                            'DocumentosTransportes.id', 
                            'DocumentosTransportes.data_emissao',
                            'DocumentosTransportes.numero',
                            'DocumentosTransportes.navio_aeronave',
                            'documento_transporte_situacao' => env('DB_ADAPTER') == 'sqlsrv' ? 'CAST(DocumentoTransporteSituacoes.descricao AS VARCHAR(100))' : 'DocumentoTransporteSituacoes.descricao'
                        ])
                        ->order([
                            'DocumentosTransportes.id' => 'DESC'
                        ]);

        if($bPrecisaEmpresaVinculadas){
            $aDocumentos = $aDocumentos->innerJoinWith('DocumentosMercadorias.Clientes.Usuarios', function($q){
                return $q->where(['Usuarios.id' => SessionUtil::getUsuarioConectado()]);
            });
        }
                

        // $sSql = 'SELECT transporte_numero
        //                 , transporte_id 
        //                 , JSON_ARRAYAGG(master_numero_documento) master_numero_documento
        //                 , master_id
        //                 , situacao
        //                 , acao
        //             FROM (SELECT dt.numero transporte_numero
        //                         , dt.id transporte_id
        //                         , dm.numero_documento master_numero_documento
        //                         , dm.id master_id
        //                         , CASE 
        //                                 WHEN (SELECT 1 
        //                                         FROM resvs_documentos_transportes rdt, resvs r, ordem_servicos os
        //                                         WHERE dt.id       = rdt.documento_transporte_id
        //                                             AND rdt.resv_id = r.id
        //                                             AND os.resv_id  = rdt.resv_id
        //                                             AND os.data_hora_inicio IS NOT NULL
        //                                             AND os.data_hora_fim    IS NOT NULL
        //                                             AND r.data_hora_chegada IS NOT NULL
        //                                             AND r.data_hora_saida   IS NOT NULL
        //                                         ORDER BY rdt.id DESC
        //                                         LIMIT 1)
        //                                         THEN "os_finalizada_resvs_finalizada"
        //                                 WHEN (SELECT 1 
        //                                         FROM resvs_documentos_transportes rdt, resvs r, ordem_servicos os
        //                                         WHERE dt.id       = rdt.documento_transporte_id
        //                                             AND rdt.resv_id = r.id
        //                                             AND os.resv_id  = rdt.resv_id
        //                                             AND os.data_hora_inicio IS NOT NULL
        //                                             AND os.data_hora_fim    IS NOT NULL
        //                                             AND r.data_hora_chegada IS NOT NULL
        //                                             AND r.data_hora_entrada IS NOT NULL
        //                                             AND r.data_hora_saida   IS NULL
        //                                         ORDER BY rdt.id DESC
        //                                         LIMIT 1)
        //                                         THEN "os_finalizada"
        //                                 WHEN (SELECT 1 
        //                                         FROM resvs_documentos_transportes rdt, resvs r
        //                                         WHERE dt.id = rdt.documento_transporte_id
        //                                             AND rdt.resv_id = r.id
        //                                             AND data_hora_chegada IS NOT NULL
        //                                             AND data_hora_entrada IS NULL
        //                                             AND data_hora_saida IS NULL
        //                                         LIMIT 1)
        //                                 THEN "chegada_informada"
        //                                 WHEN (SELECT 1 
        //                                         FROM resvs_documentos_transportes rdt, resvs r
        //                                         WHERE dt.id = rdt.documento_transporte_id
        //                                             AND rdt.resv_id = r.id
        //                                             AND data_hora_chegada IS NOT NULL
        //                                             AND data_hora_entrada IS NOT NULL
        //                                             AND data_hora_saida IS NULL
        //                                         LIMIT 1)
        //                                 THEN "em_descarga"
        //                                 WHEN (SELECT 1 
        //                                         FROM resvs_documentos_transportes rdt, resvs r
        //                                         WHERE dt.id = rdt.documento_transporte_id
        //                                             AND rdt.resv_id = r.id
        //                                             AND data_hora_chegada IS NOT NULL
        //                                             AND data_hora_entrada IS NOT NULL
        //                                             AND data_hora_saida IS NOT NULL
        //                                         LIMIT 1)
        //                                 THEN "finalizado"
        //                                 WHEN (SELECT 1
        //                                         FROM dual
        //                                         WHERE NOT EXISTS (SELECT 1
        //                                                         FROM resvs_documentos_transportes rdt
        //                                                         WHERE rdt.documento_transporte_id = dt.id) )
        //                                 THEN "informar_chegada"
        //                                 ELSE "no_data_found"
        //                             END situacao
        //                         , "action" acao
        //                     FROM documentos_mercadorias dm
        //                         , documentos_transportes dt
        //                     WHERE dm.documento_mercadoria_id_master IS NULL 
        //                     AND dm.documento_transporte_id = dt.id) docs
        //     '.$where.'
        //     GROUP BY transporte_id, transporte_numero, master_id, situacao, acao
        //     ORDER BY transporte_id DESC';

        // $connection = ConnectionManager::get('default');
        // $aDocumentos = $connection->execute( $sSql )->fetchAll('assoc');
        
        return $aDocumentos;
    }

    public function getDocumentoTransporteArrays($that, $oTransportes, $iTransporteID = null, $bRetornaSomatorioQtdItens = false)
    {
        $conhecimentos_masters = array();
        $iTransporteID = $iTransporteID ?: $oTransportes->id;

        $oConhecimentosMasters = $that->DocumentosMercadorias->find('all')
            ->where(['documento_transporte_id' => $iTransporteID,
                     'documento_mercadoria_id_master is null'])
            ->order(['DocumentosMercadorias.id' => 'ASC'])
            ->hydrate(false)
            ->toArray();

        //faz o carregamento dos vetores
        foreach ($oConhecimentosMasters as $keyMaster => $oConhecimentoMaster) {
            $conhecimentos_masters[$keyMaster] = $oConhecimentoMaster;

            $oConhecimentosHouses = $that->DocumentosMercadorias->find('all');

            $oConhecimentosHouses
                ->select($that->DocumentosMercadorias)
                ->where([
                    'documento_mercadoria_id_master' => $oConhecimentoMaster['id'],
                    'documento_transporte_id'        => $iTransporteID])
                ->hydrate(false)->toArray();
            
            foreach ($oConhecimentosHouses as $keyHouse => $oConhecimentoHouse) {
                $dQtdItens = 0.0;
                $conhecimentos_masters[$keyMaster]['conhecimento_house'][$keyHouse] = $oConhecimentoHouse;

                $oConhecimentosMercadoriasItens = $that->DocumentosMercadoriasItens->find()
                    ->where(['documentos_mercadoria_id' => $oConhecimentoHouse['id']])
                    ->hydrate(false)
                    ->toArray();

                foreach ($oConhecimentosMercadoriasItens as $keyItens => $oConhecimentoMercadoriaItem) {
                    $conhecimentos_masters[$keyMaster]['conhecimento_house'][$keyHouse]['documento_mercadoria_item'][$keyItens] = $oConhecimentoMercadoriaItem;
                    $dQtdItens += $oConhecimentoMercadoriaItem['quantidade'];

                    $oItemContainers = $that->ItemContainers->find()
                        ->contain([
                            'Containers' => [
                                'Lacres' => function ($q) use ($iTransporteID) {
                                    return $q
                                        ->where(['Lacres.documento_transporte_id' => $iTransporteID]);
                                }, 
                                'ContainerEntradas' => function ($q) use ($iTransporteID) {
                                    return $q
                                        ->where(['ContainerEntradas.documento_transporte_id' => $iTransporteID]);
                                }
                            ]
                        ])
                        ->where(['ItemContainers.documento_mercadoria_item_id' => $oConhecimentoMercadoriaItem['id']])
                        ->hydrate(false)
                        ->toArray();
                    
                    foreach ($oItemContainers as $keyItemContainers => $oItemContainer) {
                        $conhecimentos_masters[$keyMaster]['conhecimento_house'][$keyHouse]['documento_mercadoria_item'][$keyItens]['item_container'][$keyItemContainers] = $oItemContainer; 
                    }

                }

                if ($bRetornaSomatorioQtdItens) {
                    $conhecimentos_masters[$keyMaster]['conhecimento_house'][$keyHouse]['volume'] = $dQtdItens;
                }
                $conhecimentos_masters[$keyMaster]['conhecimento_house'][$keyHouse]['volume_doc'] = $oConhecimentoHouse['volume'];
            }   
        }

        return $conhecimentos_masters;
    }

    public function saveTransporte($that, $aPost) 
    {
        $aPost['transporte']['empresa_id'] = $that->getEmpresaAtual();

        if ($aPost['transporte']['tipo_documento_id'] == EntityUtil::getIdByParams('TipoDocumentos', 'tipo_documento', 'NF')) {

            $oResponse = self::verifyExistsDocumentoTransporte($aPost['transporte']['numero'], @$aPost['conhecimento_master']['1']['conhecimento_house']['1']['cliente_id'], @$aPost['transporte']['id']);
            if ($oResponse->getStatus() != 200) {
                $that->countErrorsAdd++;
                $that->Flash->error($oResponse->getTitle(),
                    [
                        'params' => [
                            'html'  => $oResponse->getMessage(),
                            'timer' => 9000
                        ]
                    ]
                );
                return $that->redirect($that->referer());
            }

        }
        
        $oTransportes = $that->setEntity('DocumentosTransportes', $aPost['transporte'] );
        $oTransportes = $that->DocumentosTransportes->patchEntity($oTransportes, $aPost['transporte']);
        
        if (!$result = $that->DocumentosTransportes->save($oTransportes)){
            $that->countErrorsAdd++;
            $that->Flash->error( __('Não foi possível salvar o documento de transporte, favor valide novamente os campos!'),
                [
                    'params' => [
                        'html'  => EntityUtil::dumpErrors($oTransportes),
                        'timer' => 9000
                    ]
                ]
            );
            return $that->redirect( $that->referer() );
        }
        
        $iDocumentoTransporte_id = @$result->id;
        $this->iDocumentoTransporteIdSalvo = $iDocumentoTransporte_id;

        $this->saveMaster($that, $iDocumentoTransporte_id, $aPost);
    }

    private function saveMaster($that, $iDocumentoTransporte_id, $aPost) 
    {
        unset($aPost['conhecimento_master']['$']);
        
        foreach ($aPost['conhecimento_master'] as $aConhecimentos) {
            //se esse master tiver algum house
            if (isset($aConhecimentos['conhecimento_house'])) {
                $dadosConhecimentoHouse = $aConhecimentos['conhecimento_house'];
                unset($aConhecimentos['conhecimento_house']);
            }else {
                $dadosConhecimentoHouse = null;
            }

            $entidadeConhecimentoMaster = $that->setEntity('DocumentosMercadorias', $aConhecimentos );

            $dadosConhecimentoMaster = $aConhecimentos;
            $dadosConhecimentoMaster['documento_transporte_id'] = $iDocumentoTransporte_id;
            $dadosConhecimentoMaster['data_emissao'] = DateUtil::dateTimeToDB(
                @$dadosConhecimentoMaster['data_emissao']
            );
            $dadosConhecimentoMaster['empresa_id'] = $that->getEmpresaAtual();

            $entidadeConhecimentoMaster = $that->DocumentosMercadorias->patchEntity($entidadeConhecimentoMaster, $dadosConhecimentoMaster);
            $entidadeConhecimentoMaster->tipo_mercadoria_id = $entidadeConhecimentoMaster->tipo_mercadoria_id
                ? $entidadeConhecimentoMaster->tipo_mercadoria_id
                : null;

            if (!$result = $that->DocumentosMercadorias->save($entidadeConhecimentoMaster)){
                $that->countErrorsAdd++;
                $that->Flash->error( __('Não foi possível salvar o documento Master Documento #'. $entidadeConhecimentoMaster->numero .', favor valide novamente os campos!') );
            }
            
            $iMaster_id = @$result->id;
            
            $this->saveHouse($that, $iDocumentoTransporte_id, $iMaster_id, $dadosConhecimentoHouse, @$result);
        }
    }

    private function saveHouse($that, $iDocumentoTransporte_id, $iMaster_id, $dadosConhecimentoHouse, $oMaster)
    {
        $oDocumentosMercadoria = new DocumentosMercadoria;

        if ($iMaster_id && @count($dadosConhecimentoHouse)) {

            foreach ($dadosConhecimentoHouse as $aConhecimentosHouse) {
                unset($aConhecimentosHouse['documento_mercadoria_item']['$$$']);
                $dadosConhecimentoHouseItem = isset($aConhecimentosHouse['documento_mercadoria_item']) ? $aConhecimentosHouse['documento_mercadoria_item'] : null;
                unset($aConhecimentosHouse['documento_mercadoria_item']);

                $entidadeConhecimentoHouse = $that->setEntity('DocumentosMercadorias', $aConhecimentosHouse );

                $dadosConhecimentoHouse = $aConhecimentosHouse;
                $dadosConhecimentoHouse['documento_mercadoria_id_master'] = $iMaster_id;
                $dadosConhecimentoHouse['documento_transporte_id'] = $iDocumentoTransporte_id;
                $dadosConhecimentoHouse['data_emissao'] = DateUtil::dateTimeToDB($dadosConhecimentoHouse['data_emissao']);
                $dadosConhecimentoHouse['peso_bruto'] = DoubleUtil::toDBUnformat($dadosConhecimentoHouse['peso_bruto']);
                $dadosConhecimentoHouse['volume'] = DoubleUtil::toDBUnformat($dadosConhecimentoHouse['volume']);
                $dadosConhecimentoHouse['empresa_id'] = $that->getEmpresaAtual();
                $dadosConhecimentoHouse['procedencia_origem_id']  = @$oMaster->procedencia_origem_id;
                $dadosConhecimentoHouse['procedencia_destino_id'] = @$oMaster->procedencia_destino_id;

                $entidadeConhecimentoHouse = $that->DocumentosMercadorias->patchEntity($entidadeConhecimentoHouse, $dadosConhecimentoHouse);
                
                if (!$result = $that->DocumentosMercadorias->save($entidadeConhecimentoHouse)){
                    $that->countErrorsAdd++;
                    $that->Flash->error( __('Não foi possível salvar o documento House Documento #'. $entidadeConhecimentoHouse->numero .', favor valide novamente os campos!') );
                }

                $iHouse_id = @$result->id;

                $this->saveMercadoria($that, $iHouse_id, $dadosConhecimentoHouseItem, $iDocumentoTransporte_id);
            }

            $oDocumentosMercadoria->generateLoteCodigo( $that, $iDocumentoTransporte_id, true );
        }
    }

    private function saveMercadoria($that, $iHouse_id, $dadosConhecimentoHouseItem, $iDocumentoTransporte_id)
    {
        if ($iHouse_id && is_array($dadosConhecimentoHouseItem)) {

            foreach ($dadosConhecimentoHouseItem as $aMercadoria) {
                $entidadeMercadorias = $that->setEntity('DocumentosMercadoriasItens', $aMercadoria );

                $dadosMercadorias = $aMercadoria;
                $dadosMercadorias['documentos_mercadoria_id'] = $iHouse_id;
                $dadosMercadorias['empresa_id'] = $that->getEmpresaAtual();
                $dadosMercadorias['quantidade']   = DoubleUtil::toDBUnformat($dadosMercadorias['quantidade']);
                $dadosMercadorias['peso_liquido'] = DoubleUtil::toDBUnformat($dadosMercadorias['peso_liquido']);
                $dadosMercadorias['peso_bruto']   = DoubleUtil::toDBUnformat($dadosMercadorias['peso_bruto']);


                $entidadeMercadorias = $that->DocumentosMercadoriasItens->patchEntity($entidadeMercadorias, $dadosMercadorias);
                
                if (!$that->DocumentosMercadoriasItens->save($entidadeMercadorias)){
                    $that->countErrorsAdd++;
                    $that->Flash->error( __('Não foi possível salvar a Mercadoria Documento #'. $entidadeMercadorias->descricao .', favor valide novamente os campos!') );
                }
                unset($aMercadoria['containers']['$$$$']);
                ItemContainer::saveItemContainer($that, $aMercadoria, $entidadeMercadorias, $iDocumentoTransporte_id);
            }
        }
    }

    public function carregaCombos( $that, $iTransporteID = null, $aEmpresaIds = [] )
    {
        $that->loadModel('DocumentosTransportes');
        $that->loadModel('DocumentosMercadorias');
        $that->loadModel('DocumentosMercadoriasItens');
        $that->loadModel('Produtos');
        $that->loadModel('Procedencias');
        $that->loadModel('TipoMercadorias');
        $that->loadModel('LacreTipos');
        $that->loadModel('TipoIsos');
        $that->loadModel('Empresas');

        $aCombos = array();

        $aRegimes = $that->DocumentosMercadorias->RegimesAduaneiros
            ->find('list', ['keyField' => 'id', 'valueField' => 'descricao'])
            ->select(['id', 'descricao'])->toArray();

        $aCombos['RegimesAduaneiroDefault'] = empty($aRegimes) ? '' : key($aRegimes);
        $aCombos['RegimesAduaneiros_options'] = [''=>'Selecione'] + $aRegimes;
        
        $aCombos['Procedencias_options'] = $that->DocumentosMercadorias->Procedencias
            ->find('list', ['keyField' => 'id', 'valueField' => 'sigla'])
            ->select(['id', 'sigla'])->toArray();

        $aCombos['TipoMercadorias_options'] = $that->DocumentosMercadorias->TipoMercadorias
            ->find('list', ['keyField' => 'id', 'valueField' => 'codigo'])
            ->select(['id', 'codigo'])->toArray();

        $aCombos['Modais_options'] = $that->DocumentosTransportes->Modais
            ->find('list', ['keyField' => 'id', 'valueField' => 'descricao'])
            ->select(['id', 'descricao'])->toArray();

        $aCombos['TipoDocumentos_options'] = $that->DocumentosTransportes->TipoDocumentos
            ->find('list', ['keyField' => 'id', 'valueField' => 'tipo_documento'])
            ->select(['id', 'descricao']);

        $aCombos['TratamentosCargas_options'] = $that->DocumentosMercadorias->TratamentosCargas
            ->find('list', ['keyField' => 'id', 'valueField' => 'codigo'])
            ->select(['id', 'descricao']);

        $aCombos['Clientes_options'] = $that->DocumentosMercadorias->Empresas
            ->find('list', ['keyField' => 'id', 'valueField' => 'descricao_cnpj'])
            ->select([
                'id', 
                'descricao_cnpj' => LgDbUtil::getFind('Empresas')->func()->concat([
                    'descricao' => 'identifier', 
                    ' - ', 
                    'cnpj' => 'identifier'
                ])
            ])
            ->select(['id', 'descricao']);

        if ($aEmpresaIds)
            $aCombos['Clientes_options']->where(['Empresas.id IN' => $aEmpresaIds]);

        $aCombos['NaturezasCargas_options'] = $that->DocumentosMercadorias->NaturezasCargas
            ->find('list', ['keyField' => 'id', 'valueField' => 'codigo'])
            ->select(['id', 'descricao']);
            
        $aCombos['LacreTipos_options'] = $that->LacreTipos
            ->find('list', ['keyField' => 'id', 'valueField' => 'descricao'])
            ->select(['id', 'descricao']);

        $aCombos['TipoIsos_options'] = $that->TipoIsos
            ->find('list', ['keyField' => 'id', 'valueField' => 'sigla_tamanho'])
            ->contain(['ContainerTamanhos'])
            ->select(['id', 'sigla_tamanho' => LgDbUtil::getFind('TipoIsos')->func()->concat([
                'TipoIsos.sigla' => 'identifier', 
                ' - ', 
                'ContainerTamanhos.tamanho' => 'identifier'
            ])]);

        $aCombos['Armador_options'] = $that->Empresas
            ->find('list', ['keyField' => 'id', 'valueField' => 'descricao'])
            ->select(['id', 'descricao']);

        $aCombos['Ncms_options'] = $that->DocumentosMercadorias->Ncms
            ->find('list', ['keyField' => 'id', 'valueField' => 'codigo'])
            ->select(['id', 'codigo']);

        $oProdutosTable = LgDbUtil::get('Produtos');

        if ($iTransporteID) {
            $aProdutosOnMercItens = $oProdutosTable
                ->find('list', ['keyField' => 'id', 'valueField' => 'descricao'])
                ->select(['id', 'descricao'])
                ->innerJoinWith('DocumentosMercadoriasItens.DocumentosMercadorias')
                ->where([
                    'DocumentosMercadorias.documento_transporte_id' => $iTransporteID
                ])
                ->order([env('DB_ADAPTER', 'mysql') == 'sqlsrv' ? 'CAST(Produtos.descricao AS VARCHAR(100))' : 'Produtos.descricao' => 'ASC'])
                ->toArray();
            
            $aProdutosID = [];
            
            foreach ($aProdutosOnMercItens as $key => $sProduto) {
                $aProdutosID[] = $key;
            }

            // $aProdutosOutMercItens = $oProdutosTable
            //     ->find('list', ['keyField' => 'id', 'valueField' => 'descricao'])
            //     ->select(['id', 'descricao'])
            //     ->where(
                
            //         ($aProdutosID 
            //             ? ['Produtos.id NOT IN' => $aProdutosID] 
            //             : [] 
            //         )
                
            //     )->toArray();

            // foreach ($aProdutosOutMercItens as $key => $sProduto) {
            //     $aProdutosID[] = $key;
            // }

            $aCombos['Produtos_options'] = ['' => ['' => '-- Selecione --']] + [
                __('Documental') => $aProdutosOnMercItens,
                // __('Não Documental') => $aProdutosOutMercItens
                __('Não Documental') => []
            ];

            $aCombos['Produtos_controles'] = Produto::getProdutosControles($aProdutosID);
            
        }else {
            $aCombos['Produtos_options'] = ['' => '-- Selecione --'] + $oProdutosTable
                ->find('list', ['keyField' => 'id', 'valueField' => 'codigo_descricao'])
                ->select([
                    'id', 
                    'codigo_descricao' => "CONCAT(codigo, ' - ', descricao)"
                ])
                ->order([env('DB_ADAPTER', 'mysql') == 'sqlsrv' ? 'CAST(Produtos.descricao AS VARCHAR(100))' : 'Produtos.descricao' => 'ASC'])
                ->toArray();
        }
        

        $oUnidadesMedidas = $that->DocumentosMercadoriasItens->UnidadeMedidas->find()
            ->toArray();
            
        foreach ($oUnidadesMedidas as $key => $oUnidadeMedida) {
            $aCombos['UnidadeMedidas_options'][$oUnidadeMedida->id] = $oUnidadeMedida->codigo . ' - ' . $oUnidadeMedida->descricao;
        }

        $aCombos['Embalagens_options'] = LgDbUtil::get('Embalagens')
            ->find('list', ['keyField' => 'id', 'valueField' => 'codigo'])
            ->select(['id', 'codigo']);

        $aCombos['PlanejamentoMaritimos_options'] = LgDbUtil::get('PlanejamentoMaritimos')
            ->find('list', ['keyField' => 'id', 'valueField' => 'descricao'])
            ->contain(['Veiculos'])
            ->select(['id', 'descricao' => "CONCAT(PlanejamentoMaritimos.numero, ' - ', PlanejamentoMaritimos.viagem_numero, ' - ', Veiculos.veiculo_identificacao)"]);

        return $aCombos;
    }

    public function getTermoMantra($aData)
    {
        $iTentativas = 1;
        $bContinuaTentando = true;
        $oHttp = new Client;
        $aRetorno = array();

        while ($bContinuaTentando && $iTentativas > 0) {
            $aResponse = $oHttp->get( $this->sLinksApiMantra['host'] . $this->sLinksApiMantra['requisita_documentos'] , [
                'aeroporto' => $aData['aeroporto'],
                'termo'     => $aData['termo'],
                'cpf'       => $aData['cpf'],
                'senha'     => $aData['senha'],
            ], [
                'timeout' => 320
            ]);
            
            // dd($aResponse->getJson());
            // die;

            $aResponseJson = json_decode($aResponse->body, true);
            
            if ($aResponseJson && $aResponseJson['status']) {
                $bContinuaTentando = false;
                return [
                    'message' => __('OK'),
                    'status' => 200,
                    'dataExtra' => $aResponseJson
                ];
            }

            $iTentativas--;
        }

        return [
            'message' => 
                '<div class="color-red">' . 
                    __('A requisição falhou retornando a mensagem: ') . 
                '</div>' . 
                __($aResponseJson['msg']) .
                '<br>' .
                '<b>' . __('Favor tentar novamente em alguns minutos!') . '</b>',
            'status' => 500,
            'dataExtra' => $aResponseJson
        ];
    }

    public function saveDataFromMantra( $that, $aData )
    {
        $oProcedencia = new Procedencia;
        $oTratamentosCarga = new TratamentosCarga;
        $oNaturezasCarga = new NaturezasCarga;
        $aData = $aData['dados'];
        $aMercadoriasTransacoes = array();

        $aValidate = $this->validacoesImportacaoMantra($that, $aData);
        
        if ($aValidate['status'] != 200)
            return $aValidate;

        $aDataTransporte = [     
            'numero'            => $aData['termoEntrada'],
            'numero_voo'        => $aData['ufPlaca'],
            'data_emissao'      => DateUtil::dateTimeToDB($aData['dataEmissao'], 'Y-m-d', ''),
            'modal_id'          => 1,
            'tipo_documento_id' => 1,
            'empresa_id'        => $that->getEmpresaAtual()
        ];
        $oNewTermo = $that->DocumentosTransportes->newEntity($aDataTransporte);
        
        $aNewDocumentosMercadorias = array();

        $aAgrupamentoCleaned = [];

        $aAgrupamentoCleaned = self::cleanAgrupamento($aData['agrupamento']);
        
        $aData['agrupamento'] = $aAgrupamentoCleaned;

        foreach ($aData['agrupamento'] as $keyAgroup => $aMercadoria) {

            $oTipoMercadoria = EntityUtil::getOrSave([
                'descricao' => 'não definido',
                'codigo' => $aMercadoria['tipo']
            ], 'TipoMercadorias', ['codigo']);

            $aDataMaster = [
                'tipo_documento_id'      => 2,
                'numero_documento'       => $aMercadoria['numero'],
                'data_emissao'           => $aDataTransporte['data_emissao'],
                'tipo_mercadoria_id'     => @$oTipoMercadoria->id ?: null,
                'procedencia_origem_id'  => $oProcedencia->getProcViaMantra( $that, $aMercadoria['houses'][0]['aeroportos'], 0 ),
                'procedencia_destino_id' => $oProcedencia->getProcViaMantra( $that, $aMercadoria['houses'][0]['aeroportos'], 1 ),
                'empresa_id'             => $that->getEmpresaAtual()
            ];
            $aNewDocumentosMercadorias[ $aMercadoria['numero'] ]['master'] = $that->DocumentosMercadorias->newEntity($aDataMaster);
            //dump('1', $aDataMaster, $aNewDocumentosMercadorias[ $aMercadoria['numero'] ]['master']);

            foreach ($aMercadoria['houses'] as $key => $aHouse) {
                if ( in_array($aDataMaster['tipo_mercadoria_id'], [1, 2] )) {
                    $sNumeroDocHouse = $aDataMaster['numero_documento'];
                }else {
                    $sNumeroDocHouse = $aHouse['house'];
                }

                if (!$sNumeroDocHouse) {
                    $sNumeroDocHouse = $aDataMaster['numero_documento'];
                }

                $aDataHouse = [
                    'tipo_documento_id'      => 3,
                    'numero_documento'       => $sNumeroDocHouse,
                    'data_emissao'           => $aDataTransporte['data_emissao'],
                    'cliente_mantra'         => $aHouse['cosignatario'],
                    'cliente_id'             => 1,
                    'natureza_carga_id'      => $oNaturezasCarga->getNaturezaViaMantra( $that, $aHouse['naturezaCarga'] ), 
                    'tratamento_carga_id'    => $oTratamentosCarga->getTratamentoViaMantra( $that, $aHouse['tratamentoCarga'] ), 
                    'peso_bruto'             => (double) str_replace(',', '.', $aHouse['peso']),
                    'volume'                 => $aHouse['volumes'],
                    'empresa_id'             => $that->getEmpresaAtual(),
                    'regimes_aduaneiro_id'   => 1
                ];                
                $aNewDocumentosMercadorias[ $aMercadoria['numero'] ]['houses'][] = $that->DocumentosMercadorias->newEntity($aDataHouse);

            }
        }

        //insere no banco
        $oResultTermo = $that->DocumentosTransportes->save($oNewTermo);

        if (!$oResultTermo)
            return [
                'message' => __('Termo não pode ser inserido!') . ' ' . EntityUtil::dumpErrors($oNewTermo),
                'status'  => 400 
            ];

        foreach ($aNewDocumentosMercadorias as $key => $aMercadoria) {
            $oMaster = $aMercadoria['master'];
            $oMaster->documento_transporte_id = $oResultTermo->id;

            $oMasterExiste = $that->DocumentosMercadorias->find()
                ->where([
                    'numero_documento'        => $oMaster->numero_documento,
                    'tipo_mercadoria_id'      => $oMaster->tipo_mercadoria_id ? $oMaster->tipo_mercadoria_id : null,
                    'procedencia_origem_id'   => $oMaster->procedencia_origem_id,
                    'procedencia_destino_id'  => $oMaster->procedencia_destino_id,
                    'documento_transporte_id' => $oMaster->documento_transporte_id,
                    'data_emissao'            => $oMaster->data_emissao,
                    'empresa_id'              => $that->getEmpresaAtual()
                ])
                ->first();

            if (!$oMasterExiste){
                //dump('2', $oMaster);
                $oResultMaster = $that->DocumentosMercadorias->save($oMaster);
                //dump('3', $oResultMaster);

                $aMercadoriasTransacoes['masters']['success'][] = $oResultMaster;
            }else {
                $oResultMaster = $oMasterExiste;
                $oMaster = $oResultMaster;
                $aMercadoriasTransacoes['masters']['exists'][] = $oResultMaster;
            }

            if (!$oResultMaster) {
                $aMercadoriasTransacoes['masters']['errors'][] = $oMaster;
                continue;
            }

            foreach ($aMercadoria['houses'] as $key => $aHouse) {
                $oHouse = $aHouse;
                $oHouse->documento_transporte_id = $oResultTermo->id;
                $oHouse->documento_mercadoria_id_master = $oResultMaster->id;

                $oHouseExiste = $that->DocumentosMercadorias->find()
                    ->where([
                        'numero_documento'               => $oHouse->numero_documento,
                        'documento_transporte_id'        => $oHouse->documento_transporte_id,
                        'documento_mercadoria_id_master' => $oHouse->documento_mercadoria_id_master,
                        'data_emissao'                   => $oHouse->data_emissao,
                        'cliente_mantra'                 => $oHouse->cliente_mantra,
                        'cliente_id'                     => $oHouse->cliente_id,
                        'natureza_carga_id'              => $oHouse->natureza_carga_id,
                        'tratamento_carga_id'            => $oHouse->tratamento_carga_id,
                        'peso_bruto'                     => $oHouse->peso_bruto,
                        'volume'                         => $oHouse->volume,
                        'empresa_id'                     => $that->getEmpresaAtual()
                    ])
                    ->first();

                if (!$oHouseExiste){
                    $oResultHouse = $that->DocumentosMercadorias->save($oHouse);
                    $aMercadoriasTransacoes['houses']['success'][$oMaster->numero_documento][] = $oResultHouse;
                }else {
                    $oResultHouse = $oHouseExiste;
                    $oHouse = $oResultHouse;
                    $aMercadoriasTransacoes['houses']['exists'][$oMaster->numero_documento][] = $oResultHouse;
                }
    
                if (!$oResultHouse) {
                    $aMercadoriasTransacoes['houses']['errors'][$oMaster->numero_documento][] = $oHouse;
                    continue;
                }
            }
        }
        
        return [
            'message' => 'OK',
            'status'  => 200,
            'dataExtra' => $aMercadoriasTransacoes
        ];
    }

    private static function cleanAgrupamento($aAgrupamentos)
    {
        $aAgrupamentosCleaned = [];

        foreach ($aAgrupamentos as $iKey => $aMaster) {
            $bMantem = true;

            //se o master atual for de desconsolidacao
            if (@$aMaster['tipo'] == '02') {

                foreach ($aAgrupamentos as $jKey => $aMasterComparar) {

                    if ($iKey == $jKey) continue;

                    // procura se tem outra linha de master igual a esse, onde não seja de desconsolidação, 
                    // se tiver, não mantem esse master de desconsolidacao no vetor
                    if ($aMasterComparar['numero'] === $aMaster['numero'] && $aMasterComparar['tipo'] != '02') {
                        $bMantem = false;
                        break;
                    }

                }
            }

            if ($bMantem)
                $aAgrupamentosCleaned[] = $aMaster;
            
        }

        return $aAgrupamentosCleaned;
    }

    private function validacoesImportacaoMantra( $that, $aData )
    {        
        if (!isset($aData) || !isset($aData['agrupamento']) || !count($aData['agrupamento']))
            return [
                'message' => __('A API não retornou sem os dados do Mantra!'),
                'status'  => 401
            ];
            
        $oTermo = $that->DocumentosTransportes->find()
            ->where([
                'numero' => $aData['termoEntrada'],
                'data_emissao' => DateUtil::dateTimeToDB($aData['dataEmissao'], 'Y-m-d', '')
            ])
            ->first();
        
        if ($oTermo)
            return [
                'message' => __('O Termo') . ' ' . $aData['termoEntrada'] . ' ' . __('já foi importado!'),
                'status'  => 405
            ];

        return [
            'status' => 200
        ];
    }

    public static function generateByXmlNf($aData)
    {
        $oResponse = new ResponseUtil();

        if(isset($aData['saveEntity']['xml'])) {
            $oFileParsed = simplexml_load_string(
                $aData['saveEntity']['xml']
            );
        }

        if(isset($aData['saveEntity']['arquivo'])){
            $dir_app = explode('src', dirname(__FILE__))[0];
            $oFileParsed = simplexml_load_file(
                $dir_app . $aData['saveEntity']['arquivo']
            );
        }
        
        if(empty($oFileParsed)){
            return $oResponse
                ->setMessage('Falha ao carregar NF.')
                ->setStatus(400);
        }

        $Clienteid = @$aData['saveEntity']['cliente_id']?: null;
        $Clienteid = $Clienteid ?: Empresa::getEmpresaByCnpj(
            @$oFileParsed->NFe->infNFe->emit
        );

        $bPrecisaEmpresasVinculadas = Perfil::precisaEmpresasVinculadas();
        $oFileParsed = json_decode(json_encode($oFileParsed));
        $iPesoBruto = ((double) @$oFileParsed->NFe->infNFe->transp->vol->pesoB);
        $iPesoLiquido = ((double) @$oFileParsed->NFe->infNFe->transp->vol->pesoL);
        $iParamBuscaQdeItens = ParametroGeral::getParametroWithValue('PARAM_BUSCA_QTDE_ITENS_DOC_ENTRADA');

        if($bPrecisaEmpresasVinculadas){

            $oEmpresaVinculada = LgDbUtil::getFirst('EmpresasUsuarios', [
                'empresa_id' => $Clienteid, 
                'usuario_id' => SessionUtil::getUsuarioConectado()
            ]);

            if(empty($oEmpresaVinculada)){
                return $oResponse
                    ->setMessage('O cliente da NF, não está vinculado com o seu usuário.')
                    ->setStatus(400);
            }
        }

        $aProdutos = self::findColumnArray(json_decode(json_encode(@$oFileParsed->NFe->infNFe), true), ['det'], 0, []);

        if (array_key_exists('@attributes', $aProdutos)) {
            $aProdutos = [$aProdutos];
        }
        
        $oProcedenciaNac = TableRegistry::get('Procedencias')->find()
            ->where([
                'sigla' => 'NAC'
            ])
            ->first();

        $iTipoDocumentoID = ($x = ParametroGeral::getParameterByUniqueName('ID_TIPO_DOC_IMPORT_XML_NF')) ? $x->valor : 6;
        $sDataEmissao = DateUtil::dateTimeToDB(explode('T', @$oFileParsed->NFe->infNFe->ide->dhEmi)[0], 'Y-m-d', '');

        if ($iTipoDocumentoID == EntityUtil::getIdByParams('TipoDocumentos', 'tipo_documento', 'NF')) {
            $oResponseExists = self::verifyExistsDocumentoTransporte(@$oFileParsed->NFe->infNFe->ide->nNF, $Clienteid);
            if ($oResponseExists->getStatus() != 200)
                return $oResponseExists;
        }

        $oTransporte = TableRegistry::get('DocumentosTransportes')->newEntity([
            'numero'            => @$oFileParsed->NFe->infNFe->ide->nNF,
            'data_emissao'      => $sDataEmissao,
            'tipo_documento_id' => $iTipoDocumentoID,
            'modal_id'          => 2,
            'empresa_id'        => Empresa::getEmpresaPadrao(),
            'chave_nf'          => @$oFileParsed->protNFe->infProt->chNFe,
            'serie_nf'          => @$oFileParsed->NFe->infNFe->ide->serie,
        ]);
        TableRegistry::get('DocumentosTransportes')->save($oTransporte);

        if ($oTransporte->getErrors())
            return $oResponse->setMessage(__('Não foi possivel cadastrar o Doc. Transporte! ' . EntityUtil::dumpErrors($oTransporte)));

        $aDataMaster = [
            'numero_documento'        => @$oFileParsed->NFe->infNFe->ide->nNF,
            'serie_nf'                => @$oFileParsed->NFe->infNFe->ide->serie,
            'data_emissao'            => $sDataEmissao,
            'tipo_documento_id'       => $iTipoDocumentoID,
            'tipo_mercadoria_id'      => 1,
            'procedencia_origem_id'   => $oProcedenciaNac->id,
            'procedencia_destino_id'  => $oProcedenciaNac->id,
            'documento_transporte_id' => $oTransporte->id,
            'empresa_id'              => Empresa::getEmpresaPadrao()
        ];

        $oMaster = TableRegistry::get('DocumentosMercadorias')->newEntity($aDataMaster);
        TableRegistry::get('DocumentosMercadorias')->save($oMaster);

        if ($oMaster->getErrors())
            return $oResponse->setMessage(__('Não foi possivel cadastrar o Master! ' . EntityUtil::dumpErrors($oMaster)));

        $aDataHouse = $aDataMaster + [
            'documento_mercadoria_id_master' => $oMaster->id,
            'peso_bruto'   => $iPesoBruto,
            'peso_liquido' => $iPesoLiquido,
            'cliente_id' => $Clienteid,
            'volume' => @$oFileParsed->NFe->infNFe->transp->vol->qVol
        ];

        $oHouse = TableRegistry::get('DocumentosMercadorias')->newEntity($aDataHouse);
        TableRegistry::get('DocumentosMercadorias')->save($oHouse);

        if ($oHouse->getErrors())
            return $oResponse->setMessage(__('Não foi possivel cadastrar o House! ' . EntityUtil::dumpErrors($oHouse)));
        
        foreach ($aProdutos as $key => $aProduto) {
            $oProduto = @Produto::getProdutoByCodigo($aProduto['prod'], @$oFileParsed->NFe->infNFe->emit);
            $oItem = TableRegistry::get('DocumentosMercadoriasItens')->newEntity([
                'documentos_mercadoria_id' => $oHouse->id,
                'sequencia_item'           => $aProduto['@attributes']['nItem'],
                'descricao'                => $aProduto['prod']['xProd'],
                'quantidade'               => isset($iParamBuscaQdeItens) && $iParamBuscaQdeItens ? $aProduto['prod']['qCom'] : 0,
                'peso_bruto'               => $aProduto['prod']['qCom'],
                'peso_liquido'             => $aProduto['prod']['qCom'],
                'valor_unitario'           => $aProduto['prod']['vUnCom'],
                'valor_total'              => $aProduto['prod']['vProd'],
                'valor_frete_total'        => 0,
                'valor_seguro_total'       => 0,
                'produto_id'               => $oProduto->id,
                'unidade_medida_id'        => $oProduto->unidade_medida_id,
                'cfop_nf'                  => @$aProduto['prod']['CFOP'] ?: @$oFileParsed->NFe->infNFe->ide->nNF,
                'empresa_id'               => Empresa::getEmpresaPadrao()
            ]);
            
            TableRegistry::get('DocumentosMercadoriasItens')->save($oItem);
        }
        
        return $oResponse->setMessage('OK')->setStatus(200)->setDataExtra(['documento_transporte_id' => $oTransporte->id]);
    }

    public static function findColumnArray($aInfNf, $position, $index = 0, $uDefault = '')
    {
        if (!$aInfNf || !is_array($aInfNf))
            return $uDefault; 

        foreach ($aInfNf as $key => $column) {

            $percent = 0;
            if ($position[$index]) {

                similar_text($position[$index], $key, $percent);
                $key = preg_replace('/\d+/', '', $key);

                if ($key == $position[$index]) {

                    unset($position[$index]);

                    if (count($position)) {
                        return self::findColumnArray($column, $position, $index + 1);
                    } else {
                        return $column;
                    }
                }
            }
        }
        return [];
    }

    public static function deleteDocumentosTransportes($iTransporteID)
    {
        $oResponse = new ResponseUtil();

        $ResvsDocumentosTransportes = TableRegistry::getTableLocator()->get('ResvsDocumentosTransportes')->find()
            ->where(['documento_transporte_id' => $iTransporteID])
            ->first();

        
        if ($ResvsDocumentosTransportes)
            return $oResponse
                ->setStatus(400)
                ->setMessage('Já existe uma RESV para esse Documento de Transporte!')
                ->setTitle('Ops...');


        $PlanoCargaDocumentos = TableRegistry::getTableLocator()
                ->get('PlanoCargaDocumentos' )
                ->find()
                ->contain(['DocumentosMercadorias'])
                ->where(['DocumentosMercadorias.documento_transporte_id' => $iTransporteID])
                ->first();

        if ($PlanoCargaDocumentos)
            return $oResponse
                ->setStatus(400)
                ->setMessage('Já existe um Plano de Carga para esse Documento de Transporte!')
                ->setTitle('Ops...');

        $oDocumentoTransporte = TableRegistry::getTableLocator()->get('DocumentosTransportes')->find()
            ->contain(['DocumentosMercadoriasMany' => ['DocumentosMercadoriasItens' => ['ItemContainers']]])
            ->where(['DocumentosTransportes.id' => $iTransporteID])
            ->first();

        $aDocumentoMercadoriaItensIDs                  = [];
        $aDocumentoMercadoriaHouseIDs                  = [];
        $aDocumentoMercadoriaMasterIDs                 = [];
        $aDocumentoMercadoriaItemContainersIDs         = [];
        $aDocumentoMercadoriaItemContainersEntradasIDs = [];
        $aDocumentoMercadoriaItemContainersLacresIDs   = [];

        if (!$oDocumentoTransporte)
            return $oResponse
                ->setStatus(400)
                ->setMessage('Não foi possível obter o Documento de Transporte!');

        foreach ($oDocumentoTransporte->documentos_mercadorias as $oDocumentoMercadoria) { // documentos_mecadorias 

            if ($oDocumentoMercadoria->documento_mercadoria_id_master) { // house

                foreach ($oDocumentoMercadoria->documentos_mercadorias_itens as $oItem) { // documentos_mecadorias_itens 

                    if ($oItem->item_containers) { // item_containers

                        foreach ($oItem->item_containers as $oItemContainer) { // item_containers

                            $entityContainerEntradas = TableRegistry::getTableLocator()->get('ContainerEntradas');
                            $aContainerEntradas = $entityContainerEntradas->find()->where([
                                'documento_transporte_id' => $oItemContainer->documento_transporte_id,
                                'container_id'            => $oItemContainer->container_id
                            ])->toArray();
    
                            if ($aContainerEntradas) { // container_entradas
                                foreach ($aContainerEntradas as $aContainerEntrada) {
                                    $aDocumentoMercadoriaItemContainersEntradasIDs[] = $aContainerEntrada->id; // deletar container_entradas
                                }
                            }
                            
                            $entityLacres = TableRegistry::getTableLocator()->get('Lacres');
                            $aLacres = $entityLacres->find()->where([
                                'documento_transporte_id' => $oItemContainer->documento_transporte_id,
                                'container_id'            => $oItemContainer->container_id
                            ]);
    
                            if ($aLacres) { // lacres
                                foreach ($aLacres as $aLacre) {
                                    $aDocumentoMercadoriaItemContainersLacresIDs[] = $aLacre->id; // deletar os lacres
                                }
                            }
                            
                            $aDocumentoMercadoriaItemContainersIDs[] = $oItemContainer->id; // deletar item_containers
    
                        }

                    }
                    
                    $aDocumentoMercadoriaItensIDs[] = $oItem->id; // deletar os itens do house
                }

                $aDocumentoMercadoriaHouseIDs[] = $oDocumentoMercadoria->id; // deletar o house

            } elseif (!$oDocumentoMercadoria->documento_mercadoria_id_master) { // master
                
                $aDocumentoMercadoriaMasterIDs[] = $oDocumentoMercadoria->id; // deletar o master
            }
        
        }

        $aAnexosIDs                    = [];
        $aDocumentoTransporteAnexosIDs = [];
        $aDocumentoTransporteAnexos = TableRegistry::getTableLocator()->get('DocumentoTransporteAnexos')->find()
            ->contain('Anexos')
            ->where(['documento_transporte_id' => $oDocumentoTransporte->id])
            ->toArray();

        foreach ($aDocumentoTransporteAnexos as $oDocumentoTransporteAnexo) {
            $aAnexosIDs[]                    = $oDocumentoTransporteAnexo->anexo->id;
            $aDocumentoTransporteAnexosIDs[] = $oDocumentoTransporteAnexo->id;
        }

        if ($aDocumentoMercadoriaItemContainersLacresIDs)
            TableRegistry::getTableLocator()->get('Lacres')->deleteAll(array('Lacres.id IN' => $aDocumentoMercadoriaItemContainersLacresIDs), false);
        if ($aDocumentoMercadoriaItemContainersEntradasIDs)
            TableRegistry::getTableLocator()->get('ContainerEntradas')->deleteAll(array('ContainerEntradas.id IN' => $aDocumentoMercadoriaItemContainersEntradasIDs), false);
        if ($aDocumentoMercadoriaItemContainersIDs)
            TableRegistry::getTableLocator()->get('ItemContainers')->deleteAll(array('ItemContainers.id IN' => $aDocumentoMercadoriaItemContainersIDs), false);
        if ($aDocumentoMercadoriaItensIDs)
            TableRegistry::getTableLocator()->get('DocumentosMercadoriasItens')->deleteAll(array('DocumentosMercadoriasItens.id IN' => $aDocumentoMercadoriaItensIDs), false);
        if ($aDocumentoMercadoriaHouseIDs)
            TableRegistry::getTableLocator()->get('DocumentosMercadorias')->deleteAll(array('DocumentosMercadorias.id IN' => $aDocumentoMercadoriaHouseIDs), false);
        if ($aDocumentoMercadoriaMasterIDs)
            TableRegistry::getTableLocator()->get('DocumentosMercadorias')->deleteAll(array('DocumentosMercadorias.id IN' => $aDocumentoMercadoriaMasterIDs), false);
        if ($aDocumentoTransporteAnexosIDs)
            TableRegistry::getTableLocator()->get('DocumentoTransporteAnexos')->deleteAll(array('DocumentoTransporteAnexos.id IN' => $aDocumentoTransporteAnexosIDs), false);
        if ($aAnexosIDs)
            TableRegistry::getTableLocator()->get('Anexos')->deleteAll(array('Anexos.id IN' => $aAnexosIDs), false);
        if ($oDocumentoTransporte->id)
            TableRegistry::getTableLocator()->get('DocumentosTransportes')->deleteAll(array('DocumentosTransportes.id' => $oDocumentoTransporte->id), false);

        return $oResponse
            ->setStatus(200)
            ->setMessage('Documento de Transporte deletado com sucesso!')
            ->setTitle('Sucesso!');
    }

    private static function verifyExistsDocumentoTransporte($sNumero, $iClienteID, $iDocTransporteID = null)
    {
        $oResponse = new ResponseUtil();

        $aWhere = ['DocumentosTransportes.numero' => $sNumero];

        if ($iDocTransporteID)
            $aWhere += ['DocumentosTransportes.id !='  => $iDocTransporteID];
        
        $oDocumentoTransporte = LgDbUtil::getFind('DocumentosTransportes')
            ->contain(['DocumentosMercadoriasMany'])
            ->where($aWhere)
            ->first();

        if (!$oDocumentoTransporte)
            return $oResponse->setStatus(200);

        foreach ($oDocumentoTransporte->documentos_mercadorias as $oDocMerc) {
            
            if ($oDocMerc->cliente_id == $iClienteID)
                return $oResponse
                    ->setStatus(400)
                    ->setTitle('Ops!')
                    ->setMessage('Impossível prosseguir. Já existe um documento com mesmo número e cliente!');

        }

        return $oResponse->setStatus(200);
    }

    public static function getDocTransporteIdByProdutoId($iProdutoID)
    {
        $oResponse = new ResponseUtil();

        $DocMercItem = LgDbUtil::getFind('DocumentosMercadoriasItens')
            ->contain(['DocumentosMercadorias'])
            ->where(['DocumentosMercadoriasItens.produto_id' => $iProdutoID])
            ->order(['DocumentosMercadoriasItens.id' => 'DESC'])
            ->first();

        if (!$DocMercItem)
            return $oResponse
                ->setStatus(400)
                ->setMessage('Não foi possível encontrar um Documento de Tranporte para o produto do Planejamento Movimentação de Produtos referente!');

        return $oResponse
            ->setStatus(200)
            ->setDataExtra($DocMercItem->documentos_mercadoria->documento_transporte_id);
    }
    
    public static function registraTermo($oDocumentoTransporte, $sCpf, $sSenha, $sAeroporto)
    {
        $oThis = new DocumentosTransporte;
        return RegistraEncerraTermo::doRegistro($oDocumentoTransporte, $oThis->sLinksApiMantra, $sCpf, $sSenha, $sAeroporto);
    }
    
    public static function encerraTermo($oDocumentoTransporte, $sCpf, $sSenha, $sAeroporto)
    {
        $oThis = new DocumentosTransporte;
        return RegistraEncerraTermo::doEncerramento($oDocumentoTransporte, $oThis->sLinksApiMantra, $sCpf, $sSenha, $sAeroporto);
    }
    
    public static function entregaLiberacao($oLiberacaoDocumental, $sCpf, $sSenha, $sAeroporto, $sUl, $sTipoDocumentoMantra)
    {
        $oThis = new DocumentosTransporte;
        return EntregaLiberacao::doEntrega($oLiberacaoDocumental, $oThis->sLinksApiMantra, $sCpf, $sSenha, $sAeroporto, $sUl, $sTipoDocumentoMantra);
    }

    public static function setNumeroDocumentoTransporte($aData) 
    {
        $oResponse = new ResponseUtil();

        $oDocTransporte = LgDbUtil::getByID('DocumentosTransportes', $aData['documento_transporte_id']);

        $oResponse = self::verifyExistsDocumentoTransporte($aData['numero_documento'], $oDocTransporte->cliente_id, $oDocTransporte->id);
        if ($oResponse->getStatus() != 200)
            return $oResponse;
        
        $oDocTransporte->numero = $aData['numero_documento'];
        $bSaveDocTransporte = LgDbUtil::save('DocumentosTransportes', $oDocTransporte, true);
        if ($bSaveDocTransporte->hasErrors())
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('Não foi possível salvar o Documento de Transporte!');

        return $oResponse
            ->setStatus(200)
            ->setTitle('Sucesso!')
            ->setMessage('Numero do Documento de Transporte alterado com sucesso!');
    }

    public static function getFiltersDocSemNumero()
    {
        return [
            [
                'name'  => 'numero_voo',
                'divClass' => 'col-lg-3',
                'label' => 'Viagem / Voo',
                'table' => [
                    'className' => 'DocumentosTransportes',
                    'field'     => 'numero_voo',
                    'operacao'  => 'contem'
                ]
            ],
            [
                'name'  => 'navio_aeronave',
                'divClass' => 'col-lg-3',
                'label' => 'Navio / Aeronave',
                'table' => [
                    'className' => 'DocumentosTransportes',
                    'field'     => 'navio_aeronave',
                    'operacao'  => 'contem'
                ]
            ],
        ];
    }

    public static function saveNumerosDocsTransportes($aDocumentosNumeros)
    {
        $oResponse = new ResponseUtil();
        

        foreach ($aDocumentosNumeros as $iDoc => $iNumero) {

            if (!$iNumero)
                continue;

            $oDocTransporte = LgDbUtil::getFind('DocumentosTransportes')
                ->contain(['DocumentosMercadoriasMany'])
                ->where(['DocumentosTransportes.id' => $iDoc])
                ->first();

            $aDocMercadorias = $oDocTransporte->documentos_mercadorias;

            $oDocTransporte->numero = $iNumero;
            $bSaveDocTransporte = LgDbUtil::save('DocumentosTransportes', $oDocTransporte, true);
            if ($bSaveDocTransporte->hasErrors())
                return $oResponse
                    ->setStatus(400)
                    ->setTitle('Ops!')
                    ->setMessage('Não foi possível salvar o Documento de Transporte!');

            if (!$aDocMercadorias)
                continue;
            
            foreach ($aDocMercadorias as $oDocMercadoria) {
                $oDocMercadoria->numero_documento = $iNumero;
                $bSaveDocMercadoria = LgDbUtil::save('DocumentosMercadorias', $oDocMercadoria, true);
                if ($bSaveDocMercadoria->hasErrors())
                    return $oResponse
                        ->setStatus(400)
                        ->setTitle('Ops!')
                        ->setMessage('Não foi possível salvar o Documento de Mercadoria!');
            }

        }

        return $oResponse
            ->setStatus(200)
            ->setTitle('Sucesso!')
            ->setMessage('Numero (os) do (os) Documento (os) de Transporte (es) alterado (os) com sucesso!');
    }

}
