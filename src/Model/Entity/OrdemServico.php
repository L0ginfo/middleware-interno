<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use App\Util\EntityUtil;
use App\Util\DateUtil;
use Cake\Datasource\ConnectionManager;
use App\Model\Entity\OrdemServicoItem;
use App\Model\Entity\OrdemServicoCarregamento;
use App\RegraNegocio\Carregamento\IndexCargas\ListagemCargas;
use App\TraitClass\ClosureAsMethodClass;
use Cake\ORM\TableRegistry;
use App\Model\Entity\Empresa;
use App\RegraNegocio\AutoExecucaoOrdemServico\ExecuteCarga;
use App\RegraNegocio\AutoExecucaoOrdemServico\ExecuteDescarga;
use App\RegraNegocio\Carregamento\Operacao\ManageAutoCarregamentoContainer;
use App\RegraNegocio\GerenciamentoEstoque\DecrementoEstoqueProdutos;
use App\RegraNegocio\GerenciamentoEstoque\IncrementoEstoqueProdutos;
use App\RegraNegocio\GerenciamentoEstoque\ProdutosControlados;
use App\Util\LgDbUtil;
use App\Util\ObjectUtil;
use App\Util\RealNumberUtil;
use App\Util\ResponseUtil;
use App\Util\SessionUtil;
use App\Util\UniversalCodigoUtil;
use Cake\I18n\Time;

/**
 * OrdemServico Entity
 *
 * @property int $id
 * @property \Cake\I18n\Time $data_hora_programada
 * @property \Cake\I18n\Time $data_hora_inicio
 * @property \Cake\I18n\Time $data_hora_fim
 * @property string $observação
 * @property int $empresa_id
 * @property int $ordem_servico_tipo_id
 * @property int $resv_id
 *
 * @property \App\Model\Entity\Empresa $empresa
 * @property \App\Model\Entity\OrdemServicoTipo $ordem_servico_tipo
 * @property \App\Model\Entity\Resv $resv
 * @property \App\Model\Entity\OrdemServicoItem[] $ordem_servico_itens
 * @property \App\Model\Entity\OrdemServicoServexec[] $ordem_servico_servexecs
 * @property \App\Model\Entity\TermoAvaria[] $termo_avarias
 */
class OrdemServico extends Entity
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
        '*' => true,
        'id' => false
    ];

    private $_iCountHousesCriados = 0;
    private $_iCountItensReCriados = 0;
    private $_iCountItensAtualizados = 0;
    
    // Salva a relacao de lotes que foram desconsolidados e precisam ser atualizados nas tabelas do sistema
    private static $_aRelacaoLoteCodigoToUpdate = []; 

    // Salva a relacao do antigo/novo lote_item com o novo lote_codigo
    private static $_aRelacaoLoteItemToUpdate = []; 

    // Salva a relacao de documentos mercadoria itens que tem que deletar
    private static $_aRelacaoDocMercItemToDelete = []; 

    // Salva a relacao de incrementos que terá que ser feito após tudo ser desconsolidado
    private static $_aIncrementoEstoqueDesconsolidado = []; 

    // Salva a relacao de incrementos que terá que ser feito após tudo ser desconsolidado
    private static $_aDecrementosEstoquesConsolidados = []; 


    public function checkExistsOS( $that, $aData )
    {
        return $oOrdemServico = $that->OrdemServicos->find()
            ->where($aData + ['data_hora_fim IS NULL'])
            ->first();
    }

    public function deleteOS( $that, $oOrdemServico )
    {
        return $that->OrdemServicos->delete($oOrdemServico);
    }

    public function loadModels()
    {
        $oThat = new ClosureAsMethodClass;

        $aModels = [
            'OrdemServicos'
        ];

        $aMethods = [
            'getEmpresaAtual' => function() {
                return Empresa::getEmpresaAtual();
            }
        ];

        foreach ($aModels as $sModel) {
            $oThat->{$sModel} = TableRegistry::get($sModel);
        }

        foreach ($aMethods as $sMethod => $fMethod) {
            $oThat->{$sMethod} = $fMethod;
        }

        return $oThat;
    }

    public function gerarOS($that = null, $aData, $bCheckOS = false, $oOrdemServico = null, $iContainerID = null)
    {
        if (!$that)
            $that = $this->loadModels();

        //se deve checar existencia de OS
        if ($bCheckOS) {
            //se tem uma OS para aquele RESV que ainda nao finalizou, nao cria
            $oOrdemServico = $this->checkExistsOS( $that, $aData );

            if ($oOrdemServico) {
                return [
                    'message' => __('Já existe uma Ordem de Serviço criada para esse RESV ainda não finalizada!'),
                    'status' => false
                ];
            }
        }

        $aData['empresa_id'] = Empresa::getEmpresaPadrao();
        $aData['retroativo'] = isset($aData['retroativo']) ? $aData['retroativo'] : 0;
        unset($aData['container_exclusivo_id IS']);
        if ($iContainerID)
            $aData['container_exclusivo_id'] = $iContainerID;

        $oOrdemServico = $oOrdemServico ? $oOrdemServico : $that->OrdemServicos->newEntity();
        $oOrdemServico = $that->OrdemServicos->patchEntity($oOrdemServico, $aData);

        if ($that->OrdemServicos->save($oOrdemServico))
            return [
                'message' => __('Ordem de Serviço') . ' <b>#' . $oOrdemServico->id . '</b> ' . __('gerada com sucesso!'),
                'status' => true,
                'dataExtra' => $oOrdemServico
            ];

        return [
            'message' => __('Não foi possível gravar a OS, pelos motivos: <br>' . EntityUtil::dumpErrors($oOrdemServico) ),
            'status' => false
        ];
    }

    public function getOSPendentesDescarga($bHabitadoConferente = false, $iOsTipoId = 1)
    {
        /* fazer depois

    , (SELECT JSON_OBJECTAGG((SELECT JSON_ARRAYAGG(dm.numero_documento) master
                            FROM documentos_mercadorias dm
                            WHERE dm.documento_mercadoria_id_master IS NULL
                            AND dm.documento_transporte_id = dt.id),
                            (SELECT CONCAT( (SELECT GROUP_CONCAT( CONVERT((SELECT JSON_ARRAYAGG(dh.numero_documento)
                                                FROM documentos_mercadorias dh
                                            WHERE dh.documento_mercadoria_id_master = dm.id
                                                AND dh.documento_transporte_id = dt.id
                                            GROUP BY dh.documento_mercadoria_id_master), CHAR(255))  )house
                            FROM documentos_mercadorias dm
                            WHERE dm.documento_mercadoria_id_master IS NULL
                            AND dm.documento_transporte_id = dt.id))))
            ) house_numero_documento

        */

        $oSubQuery = LgDbUtil::getFind('EntradaSaidaContainers')
            ->select('super_testado')
            ->where([
                'EntradaSaidaContainers.container_id = Containers.id',
                'EntradaSaidaContainers.resv_entrada_id IS NOT NULL',
                'EntradaSaidaContainers.resv_saida_id IS NULL',
            ])->limit(1)->sql();

        $aResvs = TableRegistry::getTableLocator()->get('Resvs')->find()
            ->contain([
                'Veiculos',
                'ResvsContainers' => [
                    'Containers' => function($q) use ($oSubQuery){
                        return $q
                        ->select(LgDbUtil::get('Containers'))
                        ->select(['super_testado' => LgDbUtil::getFind('Containers')->newExpr()->add($oSubQuery)]);
                    },
                    'EntradaSaidaContainers' => function($q){
                        return $q
                        ->where([
                            'EntradaSaidaContainers.resv_entrada_id = ResvsContainers.resv_id',
                            'EntradaSaidaContainers.container_id = ResvsContainers.container_id',
                            'EntradaSaidaContainers.resv_saida_id is NULL',
                        ])
                        ->contain([
                            'DriveEspacosAtual' =>[
                                'ContainerFormaUsos',
                                'TipoIsos', 
                                'Empresas'
                            ]
                        ])
                        ->order([
                            'EntradaSaidaContainers.id' => 'DESC'
                        ]);
                    } 
                ],
                'ResvsDocumentosTransportes' => [
                    'DocumentosTransportes' => [
                        'DocumentosMercadoriasMany' => [
                            'Clientes',
                            'Beneficiarios',
                            'DocumentosMercadoriasItens' => 'Produtos',
                            'NaturezasCargas'
                        ]
                    ]
                ], 
                'OrdemServicos' => function ($q) use ($iOsTipoId) {
                    return $q->contain([
                        'OrdemServicoTipos',
                        'OrdemServicoItens',
                        'Usuarios'
                    ])
                    ->where([
                        'OrdemServicos.ordem_servico_tipo_id' => $iOsTipoId,
                        'OrdemServicos.data_hora_fim IS'      => null,
                        'OrdemServicos.cancelada'             => 0
                    ]);
                }
            ])
            ->matching('OrdemServicos', function($q) use($iOsTipoId){
                return $q->where([
                    'OrdemServicos.ordem_servico_tipo_id' => $iOsTipoId,
                    'OrdemServicos.data_hora_fim IS'      => null,
                    'OrdemServicos.cancelada'             => 0
                ]);
            });

        if($bHabitadoConferente && !Perfil::isAdmin()){
            $aResvs = $aResvs->matching('OrdemServicos.Usuarios', function($q){
                return $q->where([
                    'Usuarios.id' => SessionUtil::getUsuarioConectado()
                ]);
            });
        }

        $aResvs = $aResvs->toArray();

        $aDocumentos = [];
        $iCount = 0;
        foreach ($aResvs as $aResv) {
            $oOrdemServico = @$aResv->ordem_servicos[0];
            if (!$oOrdemServico['id'])
                continue;

            $aDocumentos[$iCount]['dados']['placa'] = @$aResv->veiculo->descricao;
            
            if(!empty($aResv->resvs_containers)){
                $aContainer = [];
                foreach ($aResv->resvs_containers as $containers){
                    $oContainer = @$containers
                        ->container;
                    $oDriveEspaco = @$containers
                        ->entrada_saida_container->drive_espaco_atual;
                    $aContainer[$containers->container_id]['super_testado'] = @$containers->super_testado;
                    $aContainer[$containers->container_id]['container'] = 
                        @$oContainer->numero;
                    $aContainer[$containers->container_id]['armador'] =    
                        @$oContainer->armador->descricao; 
                    $aContainer[$containers->container_id]['reserva_arm'] =  @$oDriveEspaco->empresa->descricao;
                    $aContainer[$containers->container_id]['reserva_iso'] =  @$oDriveEspaco->tipo_iso->sigla;
                    $aContainer[$containers->container_id]['reserva_uso'] = @$oDriveEspaco->container_forma_uso->descrcao;
                } 

                $aDocumentos[$iCount]['containers'] = $aContainer;
            }

            if ($aResv->resvs_documentos_transportes) {
                $sDocumentos = '';
                foreach ($aResv->resvs_documentos_transportes as $aResvDocTransporte) {

                    $sDocumentos .= @$aResvDocTransporte->documentos_transporte->numero . '; ';
                    $aDocumentoMercadorias = @$aResvDocTransporte->documentos_transporte->documentos_mercadorias;
                    $aDocumentoMercadorias?:[];

                    $bDocJaDescarregado = false;
                    if (@$aResv->ordem_servicos[0]->ordem_servico_itens) {
                        $aLoteCodigoJaDescarregados = array_reduce($aResv->ordem_servicos[0]->ordem_servico_itens, function($carry, $oOsItem) {
                            $carry[] = $oOsItem->lote_codigo;
                            return $carry;
                        }, []);
                        foreach ($aDocumentoMercadorias as $key => $oDocMercadoria) {
                            if ($oDocMercadoria->documento_mercadoria_id_master != null
                                && in_array($oDocMercadoria->lote_codigo, $aLoteCodigoJaDescarregados)) {
                                $bDocJaDescarregado = true;

                            }
                        }
                    }

                    $aDocumentos[$iCount]['os_id']                 = $oOrdemServico['id'];
                    $aDocumentos[$iCount]['transporte_id']         = @$aResvDocTransporte->documentos_transporte->id;
                    $aDocumentos[$iCount]['ordem_servico_tipo_id'] = $oOrdemServico['ordem_servico_tipo_id'];
                    $aDocumentos[$iCount]['existe_itens']          = $oOrdemServico['ordem_servico_itens'] ? 1 : null;
                    $aDocumentos[$iCount]['situacao']              = $oOrdemServico['data_hora_fim'] ? "no_data_found" : "aguardando_descarga";

                    $aDocumentos[$iCount]['itens'] = array_reduce($aDocumentoMercadorias, 
                        function($sum, $element){
                        if(is_array($element->documentos_mercadorias_itens)){
                            $sum+=$element->documentos_mercadorias_itens;
                        }
                        return $sum;
                    }, []);

                    if ($bDocJaDescarregado && !$oOrdemServico->reaberta_por)
                        continue;

                    $aDocumentos[$iCount]['perigosa'] = array_reduce($aDocumentoMercadorias, 
                        function($sum, $element){
                        return (@$element->naturezas_carga->perigosa);
                    }, false);
                }

                $aDocumentos[$iCount]['transporte_numero'] = $sDocumentos;

                foreach ($aResvDocTransporte->documentos_transporte->documentos_mercadorias as $oDocMercadoria) {

                    if ($oDocMercadoria->documento_mercadoria_id_master != null) {
                        $aDocumentos[$iCount]['dados']['numero']  = $oDocMercadoria->numero_documento;
                        $aDocumentos[$iCount]['dados']['cliente'] = @$oDocMercadoria->cliente->descricao;
                        $aDocumentos[$iCount]['dados']['beneficiario'] = @$oDocMercadoria->beneficiario->descricao;
                    }

                }


                $iCount++;

            } else if ($aResv->resvs_containers) {
                $aDocumentos[$iCount]['transporte_numero']     = null;
                $aDocumentos[$iCount]['transporte_id']         = null;
                $aDocumentos[$iCount]['os_id']                 = $oOrdemServico['id'];
                $aDocumentos[$iCount]['ordem_servico_tipo_id'] = $oOrdemServico['ordem_servico_tipo_id'];
                $aDocumentos[$iCount]['existe_itens']          = $oOrdemServico['ordem_servico_itens'] ? 1 : null;
                $aDocumentos[$iCount]['situacao']              = $oOrdemServico['data_hora_fim'] ? "no_data_found" : "aguardando_descarga";

                $sContainers = '';
                foreach ($aResv->resvs_containers as $aContainer) {

                    if ($aContainer->operacao_id == EntityUtil::getIdByParams('Operacoes', 'descricao', 'Carga'))
                        break;

                    $sContainers .= @$aContainer->container->numero . '; ';
                }
                $aDocumentos[$iCount]['lista_containers'] = 'Resv ID: ' . $aResv->id . ' - ' . $sContainers;

                $iCount++;
            }
        }

        /*$aDocumentos = array();
        $sSql = 'SELECT
                    dt.numero transporte_numero,
                    dt.id transporte_id,
                    (SELECT JSON_OBJECTAGG(dm.id, dm.numero_documento)
                        FROM documentos_mercadorias dm
                        WHERE dm.documento_mercadoria_id_master IS NULL
                        AND dm.documento_transporte_id = dt.id
                        GROUP BY documento_transporte_id) master_numero_documento,
                    ('.'"#"'.' | os.id | " - " | ost.descricao) ordem_servico,
                    os.id os_id,
                    os.ordem_servico_tipo_id,
                    CASE WHEN os.data_hora_fim IS NULL
                        THEN "aguardando_descarga"
                        ELSE "no_data_found" END situacao,
                    ("action") acao,
                    (SELECT DISTINCT 1 FROM
                            documentos_mercadorias AS DocumentosMercadorias
                        INNER JOIN documentos_mercadorias_itens AS DocumentosMercadoriasItens ON
                            DocumentosMercadoriasItens.documentos_mercadoria_id = DocumentosMercadorias.id
                        INNER JOIN ordem_servico_itens AS OrdemServicoItens ON
                            OrdemServicoItens.documento_mercadoria_item_id = DocumentosMercadoriasItens.id
                        WHERE
                            DocumentosMercadorias.documento_transporte_id = dt.id) AS existe_itens
                FROM documentos_transportes dt,
                    resvs rvs,
                    ordem_servicos os,
                    resvs_documentos_transportes rdt,
                    ordem_servico_tipos ost
                WHERE rvs.id = rdt.resv_id
                    AND dt.id = rdt.documento_transporte_id
                    AND rdt.resv_id = os.resv_id
                    AND os.data_hora_fim IS null
                    AND ordem_servico_tipo_id = 1
                    AND os.cancelada = 0
                    AND ost.id = os.ordem_servico_tipo_id';

        $oConnection = ConnectionManager::get('default');
        $aDocumentos = $oConnection->execute($sSql)->fetchAll('assoc');

        if ($aDocumentos) {
            foreach ($aDocumentos as $key => $aDocumento) {
                $aDocumentos[$key]['master_numero_documento'] = DocumentosMercadoria::beautifyListingMercadorias($aDocumento['master_numero_documento']);
                //$aDocumentos[$key]['house_numero_documento']  = DocumentosMercadoria::beautifyListingMercadorias($aDocumento['house_numero_documento']);
                $aDocumentos[$key]['house_numero_documento']  = '';
            }
        }*/
        return $aDocumentos;
    }

    public function getOSPendentesCarga()
    {
        $aDadosListagemByOS = ListagemCargas::preparaListagem();

        return $aDadosListagemByOS;
    }

    public function saveInicioOS( $that, $iOSID )
    {
        $aData = $that->request->getData('os');
        $aData['id'] = $iOSID;

        if (!isset($aData)) {
            $that->Flash->error( __('Faltam parâmetros a serem passados: "Data de Emissão" e/ou "Código do Usuário"') );
            return $that->redirect( $that->referer() );
        }

        $oOrdemServico = $that->setEntity('OrdemServicos', $aData );
        $isNew         = $oOrdemServico->isNew();

        $bEntrou = false;
        if ($isNew || !$aData['data_hora_inicio']) {
            $aData['data_hora_inicio'] = !DateUtil::dateTimeToDB($aData['data_hora_inicio']);
            $bEntrou = true;
        }

        if ($isNew){
            $aData['empresa_id'] = $that->getEmpresaAtual();
        }else {
            unset($aData['empresa_id']);
            unset($aData['retroativo']);
        }

        $oOrdemServico = $that->OrdemServicos->patchEntity( $oOrdemServico, $aData );
        $oOrdemServico->data_hora_inicio = !$bEntrou ? DateUtil::dateTimeToDB($aData['data_hora_inicio']) : $aData['data_hora_inicio'];

        if (!$that->OrdemServicos->save( $oOrdemServico )) {
            $that->Flash->error( __('Faltam parâmetros a serem passados corretamente: '), [
                'param' => [
                    'html' => EntityUtil::dumpErrors($oOrdemServico),
                    'timer' =>  8000
                ]
            ]);
            return $that->redirect( $that->referer() );
        }

        return true;
    }

    public function carregaCombos( $that )
    {
        $that->loadModel('UnidadeMedidas');
        $that->loadModel('Locais');
        $that->loadModel('Enderecos');
        $that->loadModel('Avarias');

        $aCombos = array();

        $aCombos['UnidadeMedidas_options'] = $that->UnidadeMedidas
            ->find('list', ['keyField' => 'id', 'valueField' => 'descricao'])
            ->select( ['id', 'descricao', 'codigo'] );

        $oAvarias = $that->Avarias
            ->find('all')
            ->select( ['id', 'descricao', 'codigo'] );

        $aCombos['Avarias_options'] = array();

        foreach ($oAvarias as $key => $oAvaria) {
            $aCombos['Avarias_options'][$oAvaria->codigo][$oAvaria->id] = $oAvaria->descricao;
        }

        $aCombos['Locais_options'] = $that->Locais
            ->find('list', ['keyField' => 'id', 'valueField' => 'descricao'])
            ->select( ['id', 'descricao'] )
            ->where(['empresa_id' => $that->getEmpresaAtual()]);
        
        $aCombos['LacreTipos_options'] = LgDbUtil::get('LacreTipos')
            ->find('list', ['keyField' => 'id', 'valueField' => 'descricao'])
            ->select(['id', 'descricao']);

        return $aCombos;
    }

    public function getOSDescargaArrays( $that, $iTransporteID, $iOSID )
    {
        die('descarga arrays');
        return;
        $oOrdemServicoItens = $that->OrdemServicoItens->find()
            ->contain([
                'DocumentosMercadoriasItens'
            ])
            ->where('ordem_servico_id', $iOSID)
            ->toArray();

        $aEntradas = array();

        foreach ($oOrdemServicoItens as $keyOSItem => $oOSItem) {

            foreach ($oOSItem->documentos_mercadorias_item as $keyMercItem => $oMercItem) {

                $aEntradas[$oMercItem->documentos_mercadoria_id]['id'] = $oOSItem->id;
                $aEntradas[$oMercItem->documentos_mercadoria_id]['documentos_mercadoria_id'] = $oMercItem->documentos_mercadoria_id;
                $aEntradas[$oMercItem->documentos_mercadoria_id]['ordem_servico_id'] = $oOSItem->ordem_servico_id;
                $aEntradas[$oMercItem->documentos_mercadoria_id]['quantidade'] = $oOSItem->quantidade;
                $aEntradas[$oMercItem->documentos_mercadoria_id]['peso_bruto'] = $oOSItem->peso;
                $aEntradas[$oMercItem->documentos_mercadoria_id]['temperatura'] = $oMercItem->temperatura;
                $aEntradas[$oMercItem->documentos_mercadoria_id]['local_id'] = $oOSItem->local_id;

            }

        }

        dump($oOrdemServicoItens);
        die;
    }


    public function modificar($operacao)
    {
        $oDateTime = new Time();
        $iUsuario = @$_SESSION['Auth']['User']['id'];
        
        if(!$operacao){
            $this->permiteReAbrir();
            $this->data_hora_inicio = null;
            $this->data_hora_fim = null;
            $this->cancelada = 0;
            $this->reaberta_por = $iUsuario;
            $this->reaberta_at = $oDateTime;
        }else{
            $this->permiteCancelar();
            $this->cancelada = 1;
            $this->cancelada_por = $iUsuario;
            $this->cancelada_at = $oDateTime;
        }
    }

    public function permiteReAbrir(){

        if($this->notExisteMovimentacoesEstoquesRelacionadaOrdemServico()){
            return;
        }
        throw new \Exception(__("Error").__(" is not possible to re-open the").__('Ordem Serviço'), 1);
    }

    public function permiteCancelar(){
        if($this->notExisteItensANDCarregamento()){
            return;
        }
        throw new \Exception(__("Error").__(" is not possible to re-open the").__('Ordem Serviço'), 1);
    }


    public function notExisteMovimentacoesEstoquesRelacionadaOrdemServico(){

    //   $aResultados = ConnectionManager::get('default')
    //     ->execute("SELECT MovimentacoesEstoques.id
    //         FROM movimentacoes_estoques as MovimentacoesEstoques
    //         INNER JOIN estoques as Estoques ON Estoques.id = MovimentacoesEstoques.estoque_id
    //         INNER JOIN documentos_mercadorias as DocumentosMercadorias ON Estoque.lote_codigo = DocumentosMercadorias.lote_codigo
    //         INNER JOIN documentos_mercadorias_itens as DocumentosMercadoriasItens ON DocumentosMercadoriasItens.documentos_mercadoria_id = DocumentosMercadorias.id
    //         INNER JOIN ordem_servico_itens as OrdemServicoItens ON OrdemServicoItens.documento_mercadoria_item_id = DocumentosMercadoriasItens.id
    //         WHERE OrdemServicoItens.ordem_servico_id = ".$this->id)
    //     ->fetchAll('assoc');

    //    return empty($aResultados);

        return true;
    }

    public function notExisteItensANDCarregamento(){
        return
            empty(OrdemServicoItem::getByOrdemServico($this->id)->toArray()) &&
            empty(OrdemServicoCarregamento::getOrdensServicosCarregamentosByOrdensServicos($this->id)->toArray());
    }

    public static function getDataFimByLiberacaoDocumental( $that, $oLiberacaoDocumental, $iTipoOS )
    {
        if ($iTipoOS == 1) {

            $oEstoque = $that->Estoques->find()
                ->contain('LiberacoesDocumentaisItens')
                ->where([
                    'liberacao_documental_id' => $oLiberacaoDocumental->id
                ])
                ->first();

            $oOS = $that->OrdemServicos->find()
                ->select([
                    'data_hora_fim'
                ])
                ->innerJoinWith('Resvs', function( $q )  {
                    return $q->innerJoinWith('ResvsDocumentosTransportes', function( $q )  {
                        return $q->innerJoinWith('DocumentosTransportes', function( $q )  {
                            return $q->innerJoinWith('DocumentosMercadorias', function( $q )  {
                                return $q->innerJoinWith('DocumentosMercadoriasItens', function( $q )  {
                                    return $q->innerJoinWith('EtiquetaProdutos', function( $q )  {
                                        return $q->innerJoinWith('Estoques', function( $q )  {
                                            return $q;
                                        });
                                    });
                                });
                            });
                        });
                    });
                })
                ->where([
                    'ordem_servico_tipo_id' => $iTipoOS,
                    'Estoques.id' => @$oEstoque->id
                ])
                ->first();

        }elseif ($iTipoOS == 2) {

            $oOS = $that->OrdemServicos->find()
                ->select([
                    'data_hora_fim'
                ])->innerJoinWith('Resvs', function( $q )  {
                    return $q->innerJoinWith('ResvsLiberacoesDocumentais', function( $q )  {
                        return $q;
                    });
                })->where([
                    'ordem_servico_tipo_id' => $iTipoOS,
                    'ResvsLiberacoesDocumentais.liberacao_documental_id' => $oLiberacaoDocumental->id
                ])->first();
        }

        return isset($oOS->data_hora_fim) ? $oOS->data_hora_fim : null;
    }

    public function manageActionsOSInterna( $that, $aData, $sAction )
    {
        $aDataReturn = [
            'message' => __('Nada a fazer'),
            'status'  => 300
        ];

        if (!isset($aData) || !$aData)
            return $aDataReturn;

        $oOrdemServico = $aData['ordem_servico'];

        if ($sAction == 'finalizar') {

            //Desconsolidacao
            if ($oOrdemServico->ordem_servico_tipo_id == 4)
                $aDataReturn = $this->doDesconsolidacao( $that, $oOrdemServico );

            if ($oOrdemServico->ordem_servico_tipo_id == EntityUtil::getIdByParams('OrdemServicoTipos', 'descricao', 'Ova')
                && ParametroGeral::getParametroWithValue('PARAM_HABILITA_CARGA_FINAL_OVA')) {
                $oResponse = ManageAutoCarregamentoContainer::do($that, $oOrdemServico->id);
                $aDataReturn = ObjectUtil::getAsArray($oResponse);
            }
        }

        return $aDataReturn;
    }

    private function doDesconsolidacao( $that, $oOrdemServico )
    {
        $aEtiquetaHousesDesconsolidar = array();
        $aNomesHouses = array();
        $aEtiquetaProdutoID = array();
        $aEtiquetaHousesRecriarMercItem = array();

        $aEtiquetaProdutos = $that->EtiquetaProdutos->find()
            ->contain([
                'DocumentosMercadoriasItens' => [
                    'DocumentosMercadorias' => [
                        'DocumentosMercadoriasMastersFilter'
                    ]
                ]
            ])
            ->where([
                'DocumentosMercadoriasMastersFilter.tipo_mercadoria_id IN' => TipoMercadoria::getTiposDesconsolidacao(),
                'DocumentosMercadorias.id' => $oOrdemServico->documentos_mercadoria_id
            ])
            ->toArray();


        foreach ($aEtiquetaProdutos as $key => $aEtiquetaProduto) {
            if (!in_array($aEtiquetaProduto->house_desconsolidacao, $aNomesHouses))
                $aNomesHouses[] = $aEtiquetaProduto->house_desconsolidacao;

            $aEtiquetaProdutoID[] = $aEtiquetaProduto->id;
        }

        foreach ($aEtiquetaProdutos as $key => $aEtiquetaProduto) {

            $oExisteItemEmOutroHouse = $that->EtiquetaProdutos->find()
                ->where([
                    'EtiquetaProdutos.id IN' => $aEtiquetaProdutoID,
                    'EtiquetaProdutos.house_desconsolidacao IN' => $aNomesHouses,
                    'EtiquetaProdutos.house_desconsolidacao NOT IN' => $aEtiquetaProduto->house_desconsolidacao,
                    'EtiquetaProdutos.unidade_medida_id' => $aEtiquetaProduto->unidade_medida_id,
                    'EtiquetaProdutos.documento_mercadoria_item_id' => $aEtiquetaProduto->documento_mercadoria_item_id
                ])
                ->toArray();

            if ($oExisteItemEmOutroHouse) {
                $query = $that->EtiquetaProdutos->find();

                $oSomatorioQtdEPeso = $query
                    ->select([
                        'quantidade' => $query->func()->sum('qtde'),
                        'peso_bruto' => $query->func()->sum('peso'),
                        'unidade_medida_id',
                        'documento_mercadoria_item_id',
                        'house_desconsolidacao',
                        'temperatura' => 'DocumentosMercadoriasItens.temperatura',
                        'sequencia_item' => 'DocumentosMercadoriasItens.sequencia_item',
                        'documentos_mercadoria_id' => 'DocumentosMercadoriasItens.documentos_mercadoria_id',
                        'descricao' => 'DocumentosMercadoriasItens.descricao',
                        'house_desconsolidacao',
                        'etiquetas' => $query->newExpr()->add('group_concat(EtiquetaProdutos.id SEPARATOR ",")')
                    ])
                    ->contain([
                        'DocumentosMercadoriasItens'
                    ])
                    ->where([
                        'EtiquetaProdutos.id IN' => $aEtiquetaProdutoID,
                        'EtiquetaProdutos.unidade_medida_id' => $aEtiquetaProduto->unidade_medida_id,
                        'EtiquetaProdutos.documento_mercadoria_item_id' => $aEtiquetaProduto->documento_mercadoria_item_id,
                        'EtiquetaProdutos.house_desconsolidacao IN' => $aEtiquetaProduto->house_desconsolidacao
                    ])
                    ->group([
                        'EtiquetaProdutos.unidade_medida_id',
                        'EtiquetaProdutos.documento_mercadoria_item_id',
                        'house_desconsolidacao'
                    ])
                    ->first();

                $aEtiquetaHousesRecriarMercItem[
                    $aEtiquetaProduto->house_desconsolidacao.'_'.
                    $aEtiquetaProduto->unidade_medida_id.'_'.
                    $aEtiquetaProduto->documento_mercadoria_item_id] = $oSomatorioQtdEPeso;
            }
        }

        $aux = [];
        //Agrupa por houses os itens a desconsolidar
        foreach ($aEtiquetaProdutos as $key => $aEtiquetaProduto) {
            $aEtiquetaProduto->etiquetas = $aEtiquetaProduto->id;
            $aEtiquetaProduto->documentos_mercadoria_id = $that->DocumentosMercadoriasItens
                ->get($aEtiquetaProduto->documento_mercadoria_item_id)
                ->documentos_mercadoria_id;

            $aEtiquetaHousesDesconsolidar[
                $aEtiquetaProduto->house_desconsolidacao.'_'.
                $aEtiquetaProduto->unidade_medida_id.'_'.
                $aEtiquetaProduto->documento_mercadoria_item_id][] = $aEtiquetaProduto;
        }

        return $this->reCreateRelations( $that, $aEtiquetaHousesRecriarMercItem, $aEtiquetaHousesDesconsolidar, $oOrdemServico );
    }

    private function reCreateRelations( $that, $aEtiquetaHousesRecriarMercItem, $aEtiquetaHousesDesconsolidar, $oOrdemServico )
    {
        $iCountHousesCriados = 0;
        $aHousesOldDelete = array();
        $aRelacaoJaRecriada = array();

        //todo test: dump('0 $zero arrays', $aEtiquetaHousesRecriarMercItem, $aEtiquetaHousesDesconsolidar);

        foreach ($aEtiquetaHousesDesconsolidar as $keyConcatAgroup => $aHouseDesconsolidarAgroup) {

            if (isset($aEtiquetaHousesRecriarMercItem[$keyConcatAgroup]) && !in_array($keyConcatAgroup, $aRelacaoJaRecriada)){
                
                $oEtiquetaProduto = $aEtiquetaHousesRecriarMercItem[$keyConcatAgroup];
                //todo test: dump('1 $oEtiquetaProduto', $oEtiquetaProduto);

                if ( !in_array($oEtiquetaProduto->documentos_mercadoria_id, $aHousesOldDelete) )
                    $aHousesOldDelete[] = $oEtiquetaProduto->documentos_mercadoria_id;

                //todo test: dump('2 $aHousesOldDelete', $aHousesOldDelete);

                $oHouseAlreadyCreated = $this->checkIfExistsDocumentoMercadoria($that, $oEtiquetaProduto);
                //todo test: dump('3 $oHouseAlreadyCreated', $oHouseAlreadyCreated);
                $oDocumentoMercadoriaNew = $this->getNewHouse($that, $oEtiquetaProduto, $oHouseAlreadyCreated );
                //todo test: dump('4 $oDocumentoMercadoriaNew', $oDocumentoMercadoriaNew);
                $oDocumentoMercadoriaItemNew = $this->getNewMercItem( $that, $oEtiquetaProduto, $oDocumentoMercadoriaNew );
                //todo test: dump('5 $oDocumentoMercadoriaItemNew', $oDocumentoMercadoriaItemNew);
                $this->updateEtiquetasRelationsMercItem( $that, $oEtiquetaProduto, $oDocumentoMercadoriaItemNew );

                self::desconsolidaEtiquetaEnderecos($oEtiquetaProduto->etiquetas, $oDocumentoMercadoriaNew);

                $aRelacaoJaRecriada[] = $keyConcatAgroup;
            }else {
                //todo test: dump('6 $aHouseDesconsolidarAgroup', $aHouseDesconsolidarAgroup);

                foreach ($aHouseDesconsolidarAgroup as $key => $oEtiquetaProduto) {

                    //todo test: dump('7 $oEtiquetaProduto', $oEtiquetaProduto);

                    if ( !in_array($oEtiquetaProduto->documentos_mercadoria_id, $aHousesOldDelete) )
                        $aHousesOldDelete[] = $oEtiquetaProduto->documentos_mercadoria_id;

                    //todo test: dump('8 $aHousesOldDelete', $aHousesOldDelete);

                    $oHouseAlreadyCreated = $this->checkIfExistsDocumentoMercadoria($that, $oEtiquetaProduto);
                    //todo test: dump('9 $oHouseAlreadyCreated', $oHouseAlreadyCreated);
                    $oDocumentoMercadoriaNew = $this->getNewHouse($that, $oEtiquetaProduto, $oHouseAlreadyCreated );
                    //todo test: dump('10 $oDocumentoMercadoriaNew', $oDocumentoMercadoriaNew);
                    $this->setUpdatedMercItem( $that, $oEtiquetaProduto, $oDocumentoMercadoriaNew );

                    self::desconsolidaEtiquetaEnderecos($oEtiquetaProduto->etiquetas, $oDocumentoMercadoriaNew);
                }
            }
        }

        //self::atualizaOsLotesParaNovoDesconsolidado();
        //self::atualizaLoteItens();

        // Re-liga a OS com o master do house criado e vinculado nessa OS em sua abertura
        $oOrdemServicoUpdateToMaster = $oOrdemServico;
        $oOrdemServicoUpdateToMaster->documentos_mercadoria_id = $that->DocumentosMercadorias->get($oOrdemServicoUpdateToMaster->documentos_mercadoria_id)->documento_mercadoria_id_master;

        if ($oOrdemServicoUpdateToMaster->documentos_mercadoria_id)
            $that->OrdemServicos->save( $oOrdemServicoUpdateToMaster );

        //todo test: dump('52 self::$_aRelacaoDocMercItemToDelete', self::$_aRelacaoDocMercItemToDelete);

        foreach (self::$_aRelacaoDocMercItemToDelete as $iDocMercItemID => $uValue) {
            try {
                LgDbUtil::deleteByID('DocumentosMercadoriasItens', $iDocMercItemID);
            } catch (\Throwable $thi) {
                $isCatch = true;
            }
        }

        //todo test: dump('dump', @$isCatch, @$thi);

        $bAindaFaltaDesconsolidarMercadorias = false;

        foreach ($aHousesOldDelete as $key => $iHouseID) {
            try {
                $oDocumentoMercadoriaOldHouse = $that->DocumentosMercadorias->get( $iHouseID );
                self::removeOldEstoques($oDocumentoMercadoriaOldHouse->lote_codigo);
                $that->DocumentosMercadorias->delete( $oDocumentoMercadoriaOldHouse );
            } catch (\Throwable $th) {
                $bAindaFaltaDesconsolidarMercadorias = true;
            }
        }

        //todo test: dd('final', $bAindaFaltaDesconsolidarMercadorias, @$th);

        if (!$bAindaFaltaDesconsolidarMercadorias)
            return [
                'message' => __('Desconsolidação feita com sucesso') . ', ' .
                __('o processo criou') . ' ' . $this->_iCountHousesCriados . ' ' .
                __('House(s)!'),
                'status'  => 200
            ];

        return [
            'message' => __('Desconsolidação feita com sucesso') . ', ' .
            __('o processo criou') . ' ' . $this->_iCountHousesCriados . ' ' .
            __('House(s), mas ainda existem vínculos do House desconsolidado em outras Ordens de Serviço, mantendo o House!'),
            'status'  => 205
        ];
    }

    /**
     * incrementa estoque com base nos novos dados
     * 
     */
    private static function desconsolidaEtiquetaEnderecos($sEtiquetasTrunc, $oDocumentoMercadoria)
    {
        $aEtiquetaProdutoIDs = explode(',', $sEtiquetasTrunc);
        $aEtiquetaProdutos = LgDbUtil::getAll('EtiquetaProdutos', ['id IN' => $aEtiquetaProdutoIDs]);

        if (!$aEtiquetaProdutos)
            dd(['id IN' => $aEtiquetaProdutoIDs]);

        foreach ($aEtiquetaProdutos as $oEtiquetaProduto) {
            $oDocumentoMercadoriaItem = LgDbUtil::getFirst('DocumentosMercadoriasItens', [
                'documentos_mercadoria_id' => $oDocumentoMercadoria->id,
                'unidade_medida_id' => $oEtiquetaProduto->unidade_medida_id,
            ]);

            $iDocumentoMercadoriaItemID = $oDocumentoMercadoriaItem
                ? $oDocumentoMercadoriaItem->id
                : $oEtiquetaProduto->documento_mercadoria_item_id;

            $sLoteItem = @self::$_aRelacaoLoteItemToUpdate[$oDocumentoMercadoria->lote_codigo][$oEtiquetaProduto->unidade_medida_id]
                ? @self::$_aRelacaoLoteItemToUpdate[$oDocumentoMercadoria->lote_codigo][$oEtiquetaProduto->unidade_medida_id]
                : $oEtiquetaProduto->lote_item;

            LgDbUtil::updateAll('OrdemServicoItens', [
                //'lote_codigo' => $oEtiquetaProduto->lote_codigo,
                //'unidade_medida_id' => $oEtiquetaProduto->unidade_medida_id,
                'id' => $oEtiquetaProduto->ordem_servico_item_id
            ], [
                'lote_codigo' => $oDocumentoMercadoria->lote_codigo,
                'lote_item' => $sLoteItem,
                'documento_mercadoria_item_id' => $iDocumentoMercadoriaItemID
            ]);

            $oEtiquetaProduto->lote_codigo = $oDocumentoMercadoria->lote_codigo;
            $oEtiquetaProduto->lote_item = $sLoteItem;
            $oEtiquetaProduto->documento_mercadoria_item_id = $iDocumentoMercadoriaItemID;

            LgDbUtil::save('EtiquetaProdutos', $oEtiquetaProduto);

            self::$_aIncrementoEstoqueDesconsolidado = [
                'conditions' => [
                    'produto_id' => $oEtiquetaProduto->produto_id,
                    'lote'       => @$oEtiquetaProduto->lote,
                    'serie'      => @$oEtiquetaProduto->serie,
                    'validade'   => @$oEtiquetaProduto->validade ? DateUtil::dateTimeToDB($oEtiquetaProduto->validade) : null,
                    'unidade_medida_id' => $oEtiquetaProduto->unidade_medida_id,
                    'empresa_id'  => 1,
                    'endereco_id' => $oEtiquetaProduto->endereco_id
                ],
                'order' => [
                    'qtde' => 'ASC'
                ],
                'dataExtra' => [
                    'status_estoque_id' => @$oEtiquetaProduto->status_estoque_id ?: null,
                    'qtde' => $oEtiquetaProduto->qtde,
                    'peso' => $oEtiquetaProduto->peso,
                    'm2' => $oEtiquetaProduto->m2,
                    'm3' => $oEtiquetaProduto->m3,
                    'lote_codigo' => $oDocumentoMercadoria->lote_codigo,
                    'lote_item'   => $sLoteItem,
                ]
            ];

            //todo test: dump('0101 self::$_aIncrementoEstoqueDesconsolidado', self::$_aIncrementoEstoqueDesconsolidado);
            
            $oResponse = IncrementoEstoqueProdutos::manageIncrementoEstoque(
                [self::$_aIncrementoEstoqueDesconsolidado], 
                false, 
                [
                    'ignora_lote_documental' => false,
                    'nao_gera_etiqueta' => 1
                ]
            );
    
            //todo test: dump('0101 oResponse', $oResponse);
        }

            

    }

    private static function removeOldEstoques($sOldLoteCodigo)
    {
        //@TODO: mudar para select via sOldLoteCodigo

        $aOldEstoqueEnderecos = LgDbUtil::getAll('EstoqueEnderecos', ['lote_codigo' => $sOldLoteCodigo]);

        foreach ($aOldEstoqueEnderecos as $oEstoqueEndereco) {
            self::$_aDecrementosEstoquesConsolidados[] = [
                'conditions' => [
                    'produto_id' => $oEstoqueEndereco->produto_id,
                    'lote'       => @$oEstoqueEndereco->lote,
                    'serie'      => @$oEstoqueEndereco->serie,
                    'validade'   => @$oEstoqueEndereco->validade ? DateUtil::dateTimeToDB($oEstoqueEndereco->validade) : null,
                    'unidade_medida_id' => $oEstoqueEndereco->unidade_medida_id,
                    'empresa_id'  => 1,
                    'endereco_id' => $oEstoqueEndereco->endereco_id
                ],
                'order' => [
                    'qtde' => 'ASC'
                ],
                'dataExtra' => [
                    'status_estoque_id' => @$oEstoqueEndereco->status_estoque_id ?: null,
                    'qtde' => $oEstoqueEndereco->qtde_saldo,
                    'peso' => $oEstoqueEndereco->peso_saldo,
                    'm2' => $oEstoqueEndereco->m2_saldo,
                    'm3' => $oEstoqueEndereco->m3_saldo,
                    'lote_codigo' => $oEstoqueEndereco->lote_codigo,
                    'lote_item'   => $oEstoqueEndereco->lote_item,
                ]
            ];
        }
        
        //todo test: dump('self::$_aDecrementosEstoquesConsolidados', self::$_aDecrementosEstoquesConsolidados);

        $oResponseDecremento = DecrementoEstoqueProdutos::manageRetiradaEstoque(
            self::$_aDecrementosEstoquesConsolidados,
            false,
            [
                'ignora_lote_documental' => false,
                'nao_gera_etiqueta' => 1
            ]
        );

        //todo test: dump('oResponseDecremento', $oResponseDecremento);

    }
    private static function atualizaLoteItens()
    {
        foreach (self::$_aRelacaoLoteItemToUpdate as $sNewLoteCodigo => $aUnidadeMedidas) {
            foreach ($aUnidadeMedidas as $iUnidadeMedidaID => $sLoteItem) {
                $aWhereFind = ['lote_codigo' => $sNewLoteCodigo, 'unidade_medida_id IS' => $iUnidadeMedidaID];
                $aFieldsToUpdate = ['lote_item' => $sLoteItem];
    
                LgDbUtil::updateAll('OrdemServicoItens', $aWhereFind, $aFieldsToUpdate);
                LgDbUtil::updateAll('EtiquetaProdutos', $aWhereFind, $aFieldsToUpdate);
            }
        }
        
    }

    private static function atualizaOsLotesParaNovoDesconsolidado()
    {
        //todo test: dump('atualizaOsLotesParaNovoDesconsolidado', self::$_aRelacaoLoteCodigoToUpdate);

        foreach (self::$_aRelacaoLoteCodigoToUpdate as $sOldLoteCodigo => $aUnidadeMedidas) {
            foreach ($aUnidadeMedidas as $iUnidadeMedidaID => $sNewLoteCodigo) {
                $aWhereFind = ['lote_codigo' => $sOldLoteCodigo, 'unidade_medida_id IS' => $iUnidadeMedidaID];
                $aFieldsToUpdate = ['lote_codigo' => $sNewLoteCodigo];
    
                LgDbUtil::updateAll('OrdemServicoItens', $aWhereFind, $aFieldsToUpdate);
            }
        }
    }

    private function updateEtiquetasRelationsMercItem( $that, $oEtiquetaProduto, $oDocumentoMercadoriaItemNew )
    {
        $aEtiquetasIDs = explode(',', $oEtiquetaProduto->etiquetas);
        $aWhereFind = ['id IN' => $aEtiquetasIDs];
        $aFieldsToUpdate = ['documento_mercadoria_item_id' => $oDocumentoMercadoriaItemNew->id];

        $aEtiquetaProdutos = LgDbUtil::getAll('EtiquetaProdutos', $aWhereFind);

        foreach ($aEtiquetaProdutos as $oEtiquetaProduto) {
            LgDbUtil::updateAll('OrdemServicoItens', [
                'documento_mercadoria_item_id' => $oEtiquetaProduto->documento_mercadoria_item_id
            ], $aFieldsToUpdate);
        }

        LgDbUtil::updateAll('EtiquetaProdutos', $aWhereFind, $aFieldsToUpdate);

        return true;
    }

    private function setUpdatedMercItem( $that, $oEtiquetaProduto, $oDocumentoMercadoriaNew )
    {
        $oDocMecItem = $oEtiquetaProduto->documentos_mercadorias_item;
        $oDocMecItem->documentos_mercadoria_id = $oDocumentoMercadoriaNew->id;
        $oDocMecItem = $that->DocumentosMercadoriasItens->save($oDocMecItem);
        $this->_iCountItensAtualizados++;

        self::$_aRelacaoLoteItemToUpdate[$oDocumentoMercadoriaNew->lote_codigo][$oDocMecItem->unidade_medida_id] = UniversalCodigoUtil::codigoLoteItemEtiquetaProduto(null, null, 15, $oDocMecItem->sequencia_item);

        return $oDocMecItem;
    }

    private function getNewMercItem( $that, $oEtiquetaProduto, $oDocumentoMercadoriaNew )
    {
        $aData = json_decode( json_encode($oEtiquetaProduto), true );
        $oDocumentoMercadoriaItemNew = $that->DocumentosMercadoriasItens->newEntity( $aData );
        $oDocumentoMercadoriaItemNew->documentos_mercadoria_id = $oDocumentoMercadoriaNew->id;
        $this->_iCountItensReCriados++;

        //todo test: dump('getNewMercItem: ', $oEtiquetaProduto->documento_mercadoria_item_id);

        self::$_aRelacaoDocMercItemToDelete[@$oEtiquetaProduto->documento_mercadoria_item_id] = true;
        self::$_aRelacaoLoteItemToUpdate[$oDocumentoMercadoriaNew->lote_codigo][$oDocumentoMercadoriaItemNew->unidade_medida_id] = UniversalCodigoUtil::codigoLoteItemEtiquetaProduto(null, null, 15, $oDocumentoMercadoriaItemNew->sequencia_item);

        //todo test: dump('self::$_aRelacaoDocMercItemToDelete: ', self::$_aRelacaoDocMercItemToDelete);

        return $that->DocumentosMercadoriasItens->save( $oDocumentoMercadoriaItemNew );
    }

    private function getNewHouse( $that, $oEtiquetaProduto, $oHouseAlreadyCreated )
    {
        //todo test: dump('11 $oEtiquetaProduto', $oEtiquetaProduto);
        //todo test: dump('12 $oHouseAlreadyCreated', $oHouseAlreadyCreated);

        if (!$oHouseAlreadyCreated) {
            $oHouseOld = $that->DocumentosMercadorias->get( $oEtiquetaProduto->documentos_mercadoria_id );
            $aHouseOld = json_decode(json_encode( $oHouseOld ), true);
            $aHouseOld['data_emissao'] = DateUtil::dateTimeToDB($aHouseOld['data_emissao'], 'Y-m-d', '');
            $oDocumentoMercadoriaNew = $that->DocumentosMercadorias->newEntity( $aHouseOld );
            $oDocumentoMercadoriaNew->numero_documento = $oEtiquetaProduto->house_desconsolidacao;
            $oDocumentoMercadoriaNew->peso_bruto = $oEtiquetaProduto->peso_bruto;
            $oDocumentoMercadoriaNew->volume     = $oEtiquetaProduto->quantidade;
            $oDocumentoMercadoriaNew->lote_codigo = UniversalCodigoUtil::codigoLoteMercadoria();
            $oDocumentoMercadoriaNew = $that->DocumentosMercadorias->save($oDocumentoMercadoriaNew);

            //todo test: dump('13 $oDocumentoMercadoriaNew', $oDocumentoMercadoriaNew);

            self::$_aRelacaoLoteCodigoToUpdate[$oHouseOld->lote_codigo][$oEtiquetaProduto->unidade_medida_id] = $oDocumentoMercadoriaNew->lote_codigo;
            //todo test: dump('14 self::$_aRelacaoLoteCodigoToUpdate', self::$_aRelacaoLoteCodigoToUpdate);

            $this->_iCountHousesCriados++;
        }else {
            $oDocumentoMercadoriaNew = $oHouseAlreadyCreated;
            //todo test: dump('15 $oDocumentoMercadoriaNew', $oDocumentoMercadoriaNew);
        }

        return $oDocumentoMercadoriaNew;
    }

    private function checkIfExistsDocumentoMercadoria ($that, $oAgroupHouse)
    {
        $oMaster = $that->DocumentosMercadorias->get( $oAgroupHouse->documentos_mercadoria_id );

        return $that->DocumentosMercadorias->find()
            ->where([
                'DocumentosMercadorias.numero_documento' => $oAgroupHouse->house_desconsolidacao,
                'DocumentosMercadorias.documento_mercadoria_id_master' => $oMaster->documento_mercadoria_id_master,
                'DocumentosMercadorias.documento_transporte_id' => $oMaster->documento_transporte_id
            ])
            ->first();
    }

    public function getOSPendentesInventarios ()
    {
        $sSql = 'SELECT OrdemServicoInventarios.id, OrdemServicoInventarios.ordem_servico_id, OrdemServicoInventarios.inventario_id, Inventarios.situacao
                FROM ordem_servico_inventarios AS OrdemServicoInventarios
                LEFT JOIN inventarios AS Inventarios ON Inventarios.id = OrdemServicoInventarios.inventario_id
                LEFT JOIN ordem_servicos AS OrdemServico
                    ON OrdemServico.id = OrdemServicoInventarios.ordem_servico_id
                    WHERE  OrdemServico.data_hora_fim IS NULL ';

        $oConnection = ConnectionManager::get('default');
        $aDocumentos = $oConnection->execute($sSql)->fetchAll('assoc');

        return $aDocumentos;
    }

    public static function findContainerOvar($iContainerID, $iOSID)
    {
        $oResponse = new ResponseUtil();

        $oContainer = LgDbUtil::getFind('Containers')
            ->contain(['EstoqueContainerVazio'])
            ->where(['Containers.id' => $iContainerID])
            ->first();

        if (!$oContainer)
            return $oResponse
                ->setStatus(400)
                ->setMessage('Container não cadastrado no sistema!')
                ->setTitle('Ops!');

        if (!$oContainer->estoque_endereco_container_vazio)
            return $oResponse
                ->setStatus(400)
                ->setMessage('Container não está no estoque!')
                ->setTitle('Ops!');

        $oLotesOvar = self::getLotesOvar($oContainer, $iOSID);

        if (!$oLotesOvar)
            return $oResponse
                ->setStatus(400)
                ->setMessage('Não existe produtos no estoque para o cliente do container ' . $oContainer->numero . ', ou este container não está vinculado à um Drive de Espaço (Reserva)!')
                ->setTitle('Ops!');
    
        return $oResponse
            ->setStatus(200)
            ->setMessage('Container encontrado com sucesso!')
            ->setTitle('Sucesso!')
            ->setDataExtra(['oContainer' => $oContainer, 'oLotesOvar' => $oLotesOvar]);
    }

    private static function getLotesOvar($oContainer, $iOSID)
    {
        $oEntradaSaidaContainer = LgDbUtil::getFind('EntradaSaidaContainers')
            ->contain(['ResvEntrada', 'DriveEspacosAtual'])
            ->where([
                'resv_saida_id IS' => null,
                'container_id'     => $oContainer->id,
                'tipo_atual'       => 'VAZIO'
            ])
            ->orderDesc('EntradaSaidaContainers.id')
            ->first();

        if ($oEntradaSaidaContainer) {

            $aWhere = [
                'DocumentosMercadoriasLote.cliente_id IS' => @$oEntradaSaidaContainer->drive_espaco_atual->cliente_id,
                'EstoqueEnderecos.container_id IS' => null
            ];

            if (!@$oEntradaSaidaContainer->drive_espaco_atual->cliente_id)
                unset($aWhere['DocumentosMercadoriasLote.cliente_id IS']);

            $oLotesOvar = LgDbUtil::getFind('EstoqueEnderecos')
                ->contain(['DocumentosMercadoriasLote', 'Produtos', 'Enderecos' => ['Areas' => ['Locais']]])
                ->where($aWhere)
                ->toArray();

            if ($oLotesOvar){
                foreach ($oLotesOvar as $key => $oLoteOvar) {
                    $aConditions = ProdutosControlados::getProdutoControlesValuesToQuery($oLoteOvar);
                    $aConditions['ordem_servico_id'] = $iOSID;
                    $oOrdemServicoItem = LgDbUtil::getFind('OrdemServicoItens')
                        ->where($aConditions)
                        ->first();

                    if ($oOrdemServicoItem) {
                        $iDiferenca = $oLoteOvar->qtde_saldo - $oOrdemServicoItem->quantidade;
                        if ($iDiferenca > 0) {
                            $oLoteOvar->qtde_saldo -= $oOrdemServicoItem->quantidade;
                        } else {
                            unset($oLotesOvar[$key]);
                        }
                    }
                }

                return $oLotesOvar;
            }  
        }
        
        return null;
    }

    public static function findContainerOsServico($iContainerID, $iOSID)
    {
        $oResponse = new ResponseUtil();

        $oContainer = LgDbUtil::getFind('Containers')
            ->contain(['EstoqueEnderecos'])
            ->where(['Containers.id' => $iContainerID])
            ->first();

        if (!$oContainer)
            return $oResponse
                ->setStatus(400)
                ->setMessage('Container não cadastrado no sistema!')
                ->setTitle('Ops...!');

        if (!$oContainer->estoque_enderecos)
            return $oResponse
                ->setStatus(400)
                ->setMessage('Container não está no estoque!')
                ->setTitle('Ops...!');
    
        return $oResponse
            ->setStatus(200)
            ->setMessage('Container encontrado com sucesso!')
            ->setTitle('Sucesso!')
            ->setDataExtra(['oContainer' => $oContainer]);
    }

    public static function setInformacoesAdicionais($aData)
    {
        $oResponse = new ResponseUtil();

        $oOrdemServico = LgDbUtil::getByID('OrdemServicos', $aData['oData']['os_id']);
        if (!$oOrdemServico)
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('Não foi possível encontrar essa Ordem de Serviço!');

        $oOrdemServico->porao       = $aData['oData']['porao'];
        $oOrdemServico->viagem      = $aData['oData']['viagem'];
        $oOrdemServico->camada_tier = $aData['oData']['camada_tier'];
        $oOrdemServico->numero_programacao = $aData['oData']['numero_programacao'];
        $oOrdemServico->posicao = $aData['oData']['posicao'];

        if (!LgDbUtil::save('OrdemServicos', $oOrdemServico, true))
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('Não foi possível salvar as Informações Adicionais!');

        return $oResponse
            ->setStatus(200)
            ->setMessage('Informações Adicionais salvas com sucesso!');
    }

    public static function getInformacoesAdicionais($aData)
    {
        $oResponse = new ResponseUtil();

        $oOrdemServico = LgDbUtil::getByID('OrdemServicos', $aData['oData']['os_id']);
        if (!$oOrdemServico)
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('Não foi possível encontrar essa Ordem de Serviço!');

        $aInfoAdicionais = [
            'porao'       => $oOrdemServico->porao,
            'viagem'      => $oOrdemServico->viagem,
            'camada_tier' => $oOrdemServico->camada_tier,
            'numero_programacao' => $oOrdemServico->numero_programacao,
            'posicao' => $oOrdemServico->posicao
        ];

        return $oResponse
            ->setStatus(200)
            ->setDataExtra($aInfoAdicionais);
    }
    
    public static function saveTipoDesova($iTipoDesovaID, $iOSID)
    {
        $oResponse = new ResponseUtil();

        $oOrdemServico = LgDbUtil::getByID('OrdemServicos', $iOSID);
        $oOrdemServico->tipo_desova_id = $iTipoDesovaID;

        $oOrdemServico = LgDbUtil::save('OrdemServicos', $oOrdemServico, true);
        if ($oOrdemServico->hasErrors())
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('Ocorreu um erro ao salvar o tipo de desova!');

        return $oResponse
            ->setStatus(200);
    }

    public static function saveDesovaCega($iIsDesovaCega, $iOSID)
    {
        $oResponse = new ResponseUtil();

        $oOrdemServico = LgDbUtil::getByID('OrdemServicos', $iOSID);
        $oOrdemServico->is_desova_cega = $iIsDesovaCega;

        $oOrdemServico = LgDbUtil::save('OrdemServicos', $oOrdemServico, true);
        if ($oOrdemServico->hasErrors())
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('Ocorreu um erro ao salvar o tipo de desova!');

        return $oResponse
            ->setStatus(200);
    }

    public static function getDataImprimirCartaoPallet($iDesovaId)
    {
        $oOrdemServico = LgDbUtil::getFind('OrdemServicos')
            ->contain([
                'OrdemServicoItens' => function ($q) { 
                    return $q
                        ->contain([
                            'DocumentosMercadoriasItens' => [
                                'Produtos'
                            ]
                        ])
                        ->order([
                            'DocumentosMercadoriasItens.adicao_di' => 'ASC',
                            'DocumentosMercadoriasItens.item_adicao' => 'ASC',
                        ]);
                },
                'OrdemServicoAvarias',
                'Containers',
                'Resvs' => [
                    'ResvsDocumentosTransportes' => [
                        'DocumentosTransportes' => [
                            'DocumentosMercadoriasMany' => [
                                'Despachantes',
                                'DocumentosMercadoriasItens'
                            ]
                        ]
                    ]
                ]
            ])
            ->where([
                'OrdemServicos.id' => $iDesovaId
            ])
            ->first();

        $oDocTransp = $oOrdemServico->resv->resvs_documentos_transportes[0]->documentos_transporte;

        $aDespachantes = array_reduce($oDocTransp->documentos_mercadorias, function($carry, $oDocMerc) {
            if ($oDocMerc->despachante)
                $carry[$oDocMerc->despachante_id] = $oDocMerc->despachante->cnpj . ' - ' . $oDocMerc->despachante->descricao;

            return $carry;
        }, []);

        $fQtdeTotal = 0;
        $fVolumesTotal = 0;
        foreach ($oDocTransp->documentos_mercadorias as $oDocMerc) {
            $fQtdeTotal = array_reduce($oDocMerc->documentos_mercadorias_itens, function($carry, $oDocMercItem) {
                $carry += $oDocMercItem->quantidade;
    
                return $carry;
            }, 0);
            
            $fVolumesTotal = array_reduce($oDocMerc->documentos_mercadorias_itens, function($carry, $oDocMercItem) {
                $carry += $oDocMercItem->volumes;
    
                return $carry;
            }, 0);
        }

        $fPesoBruto = 0;
        $fPesoBruto = array_reduce($oDocTransp->documentos_mercadorias, function($carry, $oDocMerc) {
            $carry += $oDocMerc->peso_bruto;

            return $carry;
        }, 0);

        $oPesagem = LgDbUtil::getFind('Pesagens')
            ->contain([
                'PesagemVeiculos' => [
                    'Veiculos',
                    'PesagemVeiculoRegistros' => [
                        'PesagemTipos',
                        'Containers'
                    ]
                ],

            ])
            ->where(['Pesagens.resv_id' => $oOrdemServico->resv_id])
            ->first();

        $oEmpresa = LgDbUtil::getFind('Empresas')->contain(['Ufs'])->where(['Empresas.id' => 1])->first();

        $aPesagens = [];
        if ($oPesagem) {
            foreach ($oPesagem->pesagem_veiculos as $oPesagemVeiculo) {
                foreach ($oPesagemVeiculo->pesagem_veiculo_registros as $oPesagemVeiculoRegistro) {
                    $aPesagens[$oPesagemVeiculoRegistro->container->numero][$oPesagemVeiculoRegistro->pesagem_tipo_id] = $oPesagemVeiculoRegistro->peso;
                }
            }
        }

        $aDataContainers = [];
        $iTipoPesoBrutoId = EntityUtil::getIdByParams('PesagemTipos', 'descricao', 'Peso Bruto');
        $iTipoTaraVeiculoId = EntityUtil::getIdByParams('PesagemTipos', 'descricao', 'Tara Veículo');
        $iTipoTaraContainerId = EntityUtil::getIdByParams('PesagemTipos', 'descricao', 'Tara Container');

        foreach ($aPesagens as $sContainer => $aPesagem) {
            
            $aDataContainers[$sContainer] = [
                'peso_liquido' => @$aPesagem[$iTipoPesoBrutoId]
                    && @$aPesagem[$iTipoTaraVeiculoId]
                    && @$aPesagem[$iTipoTaraContainerId]
                    ? $aPesagem[$iTipoPesoBrutoId] - $aPesagem[$iTipoTaraVeiculoId] - $aPesagem[$iTipoTaraContainerId]
                    : 0
            ];
        }

        $aItens = [];
        $fVolumesTotal = 0;
        foreach ($oOrdemServico->ordem_servico_itens as $oOsItem) {
            $aItens[] = [
                'adicao' => $oOsItem->documentos_mercadorias_item->adicao_di,
                'item_adicao' => $oOsItem->documentos_mercadorias_item->item_adicao,
                'produto' => $oOsItem->documentos_mercadorias_item->produto->descricao,
                'qtde' => RealNumberUtil::convertNumberToView($oOsItem->quantidade / ($oOsItem->volumes ?: 1)),
                'qtde_volumes' => RealNumberUtil::convertNumberToView($oOsItem->volumes),
                'qtd_x_volumes' => RealNumberUtil::convertNumberToView(($oOsItem->quantidade / ($oOsItem->volumes ?: 1)) * ($oOsItem->volumes ?: 1))
            ];

            $fVolumesTotal += $oOsItem->volumes;
        }

        $aObsAvarias = [];
        foreach ($oOrdemServico->ordem_servico_avarias as $oOsAvaria) {
            $aObsAvarias[] = $oOsAvaria->observacoes;
        }

        $aData = [
            'os' => $oOrdemServico->id,
            'data_atual' => DateUtil::dateTimeFromDB(date('Y-m-d'), 'd/m/Y'),
            'container' => $oOrdemServico->container->numero,
            'documento' => $oDocTransp->numero,
            'despachantes' => implode('<br>', $aDespachantes),
            'total' => RealNumberUtil::convertNumberToView($fQtdeTotal),
            'volumes_total' => RealNumberUtil::convertNumberToView($fVolumesTotal),
            'qtd_x_volumes_total' => RealNumberUtil::convertNumberToView($fVolumesTotal * $fVolumesTotal),
            'peso_declarado' => $fPesoBruto,
            'peso_liquido' => @$aDataContainers[$oOrdemServico->container->numero]['peso_liquido'] ?: 0,
            'itens' => $aItens,
            'obs_avarias' => implode('<br>&nbsp;&nbsp;&nbsp;&nbsp;', $aObsAvarias)
        ];
        // dd($aData);
        return $aData;
    }

    public static function getDataImprimirGma($iDesovaId)
    {
        $oOrdemServico = LgDbUtil::getFind('OrdemServicos')
            ->contain([
                'OrdemServicoItens' => [
                    'Embalagens',
                    'DocumentosMercadoriasItens' => [
                        'Produtos'
                    ]
                ],
                'OrdemServicoAvarias' => [
                    'Avarias',
                    'AvariaTipos'
                ],
                'Containers',
                'Resvs' => [
                    'ResvsDocumentosTransportes' => [
                        'DocumentosTransportes' => [
                            'DocumentosMercadoriasMany' => [
                                'Despachantes',
                                'Clientes',
                                'DocumentosMercadoriasItens'
                            ]
                        ]
                    ],
                    'OrdemServicos' => [
                        'OrdemServicoItens'
                    ]
                ]
            ])
            ->where([
                'OrdemServicos.id' => $iDesovaId
            ])
            ->first();

        $qtdeTotalOrdens = 0;

        foreach ($oOrdemServico->resv->ordem_servicos as $oOrdemServicoResv) {
            $qtdeTotalOrdens += array_reduce($oOrdemServicoResv->ordem_servico_itens, function($carry, $oOrdemServicoItem) {
                $carry += $oOrdemServicoItem->volumes;

                return $carry;
            }, 0);
        }

        $oDocTransp = $oOrdemServico->resv->resvs_documentos_transportes[0]->documentos_transporte;

        $aDespachantes = array_reduce($oDocTransp->documentos_mercadorias, function($carry, $oDocMerc) {
            if ($oDocMerc->despachante)
                $carry[$oDocMerc->despachante_id] = $oDocMerc->despachante->cnpj . ' - ' . $oDocMerc->despachante->descricao;

            return $carry;
        }, []);

        $aCeMercantes = array_reduce($oDocTransp->documentos_mercadorias, function($carry, $oDocMerc) {
            if ($oDocMerc->ce_mercante)
                $carry[$oDocMerc->ce_mercante] = $oDocMerc->ce_mercante;

            return $carry;
        }, []);

        $aClientes = array_reduce($oDocTransp->documentos_mercadorias, function($carry, $oDocMerc) {
            if ($oDocMerc->cliente)
                $carry[$oDocMerc->cliente_id] = $oDocMerc->cliente->cnpj . ' - ' . $oDocMerc->cliente->descricao;

            return $carry;
        }, []);

        $fQtdeTotalMerc = 0;
        foreach ($oDocTransp->documentos_mercadorias as $oDocMerc) {
            $fQtdeTotal = array_reduce($oDocMerc->documentos_mercadorias_itens, function($carry, $oDocMercItem) {
                $carry += $oDocMercItem->quantidade;
    
                return $carry;
            }, 0);

            $fQtdeTotalMerc += $fQtdeTotal;
        }

        $fQtdeTotalVolumes = array_reduce($oDocTransp->documentos_mercadorias, function($carry, $oDocMerc) {
            if ($oDocMerc->volume)
                $carry += $oDocMerc->volume;

            return $carry;
        }, 0);

        $fQtdeTotalOs = 0;
        foreach ($oOrdemServico->ordem_servico_itens as $oOsItem) {
            $fQtdeTotalOs += $oOsItem->volumes;
        }

        $aDataAvarias = [];
        foreach ($oOrdemServico->ordem_servico_avarias as $oOrdemServicoAvaria) {
            $aDataAvarias[] = [
                'avaria' => $oOrdemServicoAvaria->avaria->descricao,
                'avaria_tipo' => $oOrdemServicoAvaria->avaria_tipo->descricao,
                'volume' => $oOrdemServicoAvaria->volume,
                'obs' => $oOrdemServicoAvaria->observacoes
            ];
        }

        $qtdeTotalOrdens = $oOrdemServico->total_desova ?: $qtdeTotalOrdens;

        $aData = [
            'os' => $oOrdemServico->id,
            'container' => $oOrdemServico->container->numero,
            'ce_mercante' => implode('<br>', $aCeMercantes),
            'despachantes' => implode('<br>', $aDespachantes),
            'clientes' => implode('<br>', $aClientes),
            'atividade' => 'Desunitização',
            'data_inicio' => DateUtil::dateTimeFromDB($oOrdemServico->data_hora_inicio, 'Y-m-d'),
            'hora_inicio' => DateUtil::dateTimeFromDB($oOrdemServico->data_hora_inicio, 'H:i'),
            'data_fim' => DateUtil::dateTimeFromDB($oOrdemServico->data_hora_fim, 'Y-m-d'),
            'hora_fim' => DateUtil::dateTimeFromDB($oOrdemServico->data_hora_fim, 'H:i'),
            'data_avarias' => $aDataAvarias,
            'embalagem' => $oOrdemServico->ordem_servico_itens[0]->embalagem->descricao,
            'declarado' => $fQtdeTotalMerc,
            'contado' => $oOrdemServico->total_desova ?: $fQtdeTotalOs,
            'resultado' => $fQtdeTotalVolumes == $qtdeTotalOrdens ? 'OK' : 'Divergência',
            'contato_total' => $qtdeTotalOrdens,
            'qtde_total_volumes' => $fQtdeTotalVolumes
        ];

        return $aData;
    }

    public static function getDataImprimirRomaneio($iDesovaId)
    {
        $oOrdemServico = LgDbUtil::getFind('OrdemServicos')
            ->contain([
                'OrdemServicoItens' => [
                    'DocumentosMercadoriasItens' => [
                        'Produtos'
                    ]
                ],
                'OrdemServicoConferentes' => [
                    'Usuarios',
                    'Pessoas'
                ],
                'Containers',
                'Resvs' => [
                    'ResvsDocumentosTransportes' => [
                        'DocumentosTransportes' => [
                            'DocumentosMercadoriasMany' => [
                                'Despachantes',
                                'DocumentosMercadoriasItens'
                            ]
                        ]
                    ]
                ]
            ])
            ->where([
                'OrdemServicos.id' => $iDesovaId
            ])
            ->first();

        $oDocTransp = $oOrdemServico->resv->resvs_documentos_transportes[0]->documentos_transporte;

        $aCeMercantes = [];
        foreach ($oDocTransp->documentos_mercadorias as $oDocMerc) {
            if ($oDocMerc->ce_mercante)
                $aCeMercantes[] = $oDocMerc->ce_mercante;
        }

        $sResponsavel = '';
        $aPessoas = [];

        foreach ($oOrdemServico->ordem_servico_conferentes as $oOsConferente) {
            if ($oOsConferente->conferente_id)
                $sResponsavel = $oOsConferente->usuario->nome;

            $aPessoas[] = $oOsConferente->pessoa->descricao;
        }

        $aItens = [];
        foreach ($oOrdemServico->ordem_servico_itens as $oOsItem) {
            $aItens[] = [
                'referencia' => $oOsItem->documentos_mercadorias_item->produto->codigo,
                'descricao' => $oOsItem->documentos_mercadorias_item->produto->descricao,
                'caixas' => $oOsItem->documentos_mercadorias_item->volumes,
                'itens' => $oOsItem->documentos_mercadorias_item->quantidade,
                'total' => $oOsItem->documentos_mercadorias_item->volumes * $oOsItem->documentos_mercadorias_item->quantidade
            ];
        }

        $aData = [
            'ce' => $aCeMercantes ? implode(', ', $aCeMercantes) : '',
            'container' => $oOrdemServico->container->numero,
            'data_atual' => DateUtil::dateTimeFromDB(date('Y-m-d'), 'd/m/Y'),
            'equipe' => $aPessoas ? implode(', ', $aPessoas) : '',
            'responsavel' => $sResponsavel,
            'itens' => $aItens
        ];

        return $aData;
    }
    
    public static function autoExecuteOrdemServicoGateAuto($oThat, $iEnderecoID, $iPesagemVeiculoID, $iTotalBags, $bAcceptedValidate, $sValidateObject)
    {
        $oResponse = new ResponseUtil;

        $bAutoExecuteOs = ParametroGeral::getParametroWithValue('PARAM_AUTO_EXECUTE_OS_GATE_AUTO');
        if (!$bAutoExecuteOs)
            return $oResponse
                ->setStatus(200);

        $oPesagemVeiculo = LgDbUtil::getFind('PesagemVeiculos')->contain([
            'Pesagens' => ['Resvs'],
            'PesagemVeiculoRegistros' => function($q) {
                return $q
                    ->where([
                        'PesagemVeiculoRegistros.pesagem_tipo_id IN' => [1,2]
                    ])
                    ->order([
                        'PesagemVeiculoRegistros.pesagem_tipo_id' => 'ASC',
                        'PesagemVeiculoRegistros.id' => 'DESC'
                    ]);
            }
        ])->where([
            'PesagemVeiculos.id' => $iPesagemVeiculoID
        ])
        ->first();
        
        $oPesagem = $oPesagemVeiculo->pesagem;
        $oResv = $oPesagem->resv;

        if (Resv::isDescarga($oResv)) {
            $oResponse = ExecuteDescarga::doAction($oThat, $oPesagemVeiculo, $oPesagem, $oResv, $iEnderecoID);
            
            PesagemVeiculo::saveLog($oResponse, $oResv, $iEnderecoID, 'Descarga');
            
            return $oResponse;

        }elseif (Resv::isCarga($oResv)) {
            
            $sDateFim = date('Y-m-d H:i:s');
            $oResv->data_hora_saida = $oResv->data_hora_saida ?: $sDateFim;
            LgDbUtil::get('Resvs')->save($oResv);
            
            PesagemVeiculo::saveLogValidate($oResv, $sValidateObject, $bAcceptedValidate, 'CargaValidate');

            if ($bAcceptedValidate == 'false')  
                return $oResponse
                    ->setTitle('Ordem de Serviço não executada!')
                    ->setMessage(
                        'Informar para o setor de Estoque que posteriormente será preciso executar a Ordem de Serviço da RESV #'.$oResv->id.'! <br><br>' .
                        "<i>Prossiga com a impressão do Ticket e volte para a tela de RESV's.</i>"
                    );

            $oResponse = ExecuteCarga::doAction($oPesagemVeiculo, $oPesagem, $oResv, $iEnderecoID, $iTotalBags);

            PesagemVeiculo::saveLog($oResponse, $oResv, $iEnderecoID, 'AutoExecuteCarga');

            return $oResponse;
        }

        return $oResponse
            ->setTitle('Ops')
            ->setMessage('Não está habilitado executar OS para essa operação!');
    }

}
