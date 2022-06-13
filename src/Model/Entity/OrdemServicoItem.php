<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use App\Model\Entity\TermoAvaria;
use App\Model\Entity\DocumentosMercadoriasItem;
use App\Model\Entity\EtiquetaProduto;
use App\Model\Entity\Etiqueta;
use App\Model\Entity\EstoqueEndereco;
use App\Model\Entity\Estoque;
use App\Model\Entity\MovimentacoesEstoque;
use App\RegraNegocio\GerenciamentoEstoque\ProdutosControlados;
use App\Util\DateUtil;
use App\Util\EntityUtil;
use App\Util\DoubleUtil;
use App\Util\LgDbUtil;
use App\Util\ObjectUtil;
use App\Util\ResponseUtil;
use Cake\ORM\TableRegistry;
use stdClass;

/**
 * OrdemServicoItem Entity
 *
 * @property int $id
 * @property int $doc_merc_seq_item
 * @property float $quantidade
 * @property float $peso
 * @property float $m2
 * @property float $m3
 * @property int $ordem_servico_id
 * @property int $unidade_medida_id
 * @property int $embalagem_id
 *
 * @property \App\Model\Entity\OrdemServico $ordem_servico
 * @property \App\Model\Entity\UnidadeMedida $unidade_medida
 * @property \App\Model\Entity\Embalagem $embalagem
 * @property \App\Model\Entity\TermoAvaria[] $termo_avarias
 */
class OrdemServicoItem extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * Default fields:
     * 
     * 'sequencia_item' => true,
     * 'quantidade' => true,
     * 'peso' => true,
     * 'temperatura' => true,
     * 'm2' => true,
     * 'm3' => true,
     * 'documento_mercadoria_item_id' => true,
     * 'ordem_servico_id' => true,
     * 'unidade_medida_id' => true,
     * 'embalagem_id' => true,
     * 'ordem_servico' => true,
     * 'unidade_medida' => true,
     * 'embalagem' => true,
     * 'termo_avarias' => true,
     * 'produto_id' => true,
     * 'produto' => true,
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public function saveItens( $that, $aData, $iHouseAtivo, $iEntradaAtiva )
    {
        $oDocumentosMercadoriasItem = new DocumentosMercadoriasItem;
        $oEtiquetaProduto           = new EtiquetaProduto;
        $oTermoAvaria               = new TermoAvaria;
        $oEstoque                   = new Estoque;
        $oEstoqueEndereco           = new EstoqueEndereco;

        $iNumTermo = $aData['transporte']['numero'];
        $iAchados  = 0;

        foreach ($aData['conhecimento_master'] as $keyMaster => $aMaster) {
            foreach ($aMaster['conhecimento_house'] as $keyHouse => $aHouse) {
                unset($aHouse['entrada_fisica']['__entrada_increment__']);

                if ($aHouse['id'] == $iHouseAtivo) {
                    
                    $aEntradasFisicas = $aHouse['entrada_fisica'];
                    
                    if (!$aEntradasFisicas)
                        return [
                            'message' => __('Não foi informado uma entrada física!'),
                            'status'  => 206
                        ];

                    $aDataReturn = array();

                    foreach ($aEntradasFisicas as $keyEntrada => $aEntrada) {
                        if ($keyEntrada != $iEntradaAtiva) 
                        continue;
                        if (ParametroGeral::getParametroWithValue('PARAM_VALIDA_QUANTIDADE_OS_DESCARGA')) {
                            $iSumEntradaQuantidade = array_reduce($aEntradasFisicas, function($carry, $aItem){return $carry + DoubleUtil::toDBUnformat($aItem['quantidade']);});
                            $iDocumentoEntradaQuantidade = DoubleUtil::toDBUnformat($aHouse['volume']);
                            if($iSumEntradaQuantidade > $iDocumentoEntradaQuantidade) {
                                return [
                                    'message' => __("Quantidade máxima do documento de entrada foi excedida!"),
                                    'configSwal' => ['type' => 'error'],
                                    'status'  => 400
                                ];
                            }
                        }

                        $aEntrada['validade'] = $aEntrada['validade'] ? DateUtil::dateTimeToDB($aEntrada['validade']) : null;

                        $aReturn = $oDocumentosMercadoriasItem->saveOrIncrementItem( $that, $aEntrada );

                        if ($aReturn['status'] != 200)
                            return $aReturn;

                        $iMercadoriaItemID = $aReturn['dataExtra']['id'];
                        $iMercadoriaID     = $aReturn['dataExtra']['documento_mercadoria_id'];
                        $aEntrada['sequencia_item'] = $aReturn['dataExtra']['sequencia_item'];
                        $aEntrada['ordem_servico_item_id_frontend'] = @$aEntrada['id'];

                        if (@$aEntrada['controle_especifico_id']) {
                            $oControleEspecifico = LgDbUtil::getByID('ControleEspecificos', $aEntrada['controle_especifico_id']);
                            $aEntrada['serie']   = $oControleEspecifico->codigo;
                        }
                        
                        $aReturn = $this->saveOrdemServicoItem( $that, $aEntrada, $iMercadoriaItemID );
                        
                        if ($aReturn['status'] != 200)
                            return $aReturn;

                        $iOSItemID = $aReturn['dataExtra']['id'];
                        $aEntrada['ordem_servico_item_id'] = $iOSItemID;
                        $aEntrada['ordem_servico_item_old'] = $aReturn['dataExtra']['ordem_servico_item_old'];
                        
                        $aDataReturn['os_id'] = $iOSItemID;
                        unset($aEntrada['avarias']['__avaria_increment__']);
                        
                        $aReturn = $oTermoAvaria->saveTermoAvaria( $that, $aEntrada['avarias'], $iOSItemID, $iNumTermo );

                        if ($aReturn['status'] != 200)
                            return $aReturn;

                        $aDataReturn['avarias'] = isset($aReturn['dataExtra']['avarias']) ? $aReturn['dataExtra']['avarias'] : null;
                        $aReturn = $oEtiquetaProduto->saveEtiquetaProduto( $that, $aEntrada, $iMercadoriaItemID, $iMercadoriaID );
                        
                        if ($aReturn['status'] != 200)
                            return $aReturn;

                        $aEntrada['etiqueta_produto_old'] = $aReturn['dataExtra']['etiqueta_produto_old'];
                        $aDataReturn['etiqueta_produto']  = $aReturn['dataExtra']['etiqueta_produto_id'];
                        $aEntrada['lote_codigo']          = $aReturn['dataExtra']['lote_codigo'];
                        $aEntrada['lote_item']            = $aReturn['dataExtra']['lote_item'];
                        $aEntrada['unidade_medida_id']    = $aReturn['dataExtra']['unidade_medida_id'];

                        self::updateLotesOrdemServicoItem($iOSItemID, $aEntrada['lote_codigo'], $aEntrada['lote_item']);

                        $aReturn = $oEstoque->saveEstoque( $that, $aEntrada );
                        
                        if ($aReturn['status'] != 200)
                            return $aReturn;

                        $aReturn = $oEstoqueEndereco->saveEstoqueEndereco( $that, $aEntrada, $aReturn['dataExtra']['id'] );
                        
                        if ($aReturn['status'] != 200)
                            return $aReturn;

                        $iAchados++;

                        return [
                            'dataExtra' => $aDataReturn,
                            'status'    => 200
                        ];
                    }
                }
            }
        }

        if (!$iAchados) 
            return [
                'message' => __('Não foi encontrado essa entrada física no banco!'),
                'status'  => 206
            ];
    }

    private static function updateLotesOrdemServicoItem($iOSItemID, $sLoteCodigo, $sLoteItem)
    {
        if (!$iOSItemID || !$sLoteCodigo || !$sLoteItem) return;

        $oOrdemServicoItem = TableRegistry::getTableLocator()->get('OrdemServicoItens')->find()->where(['id' => $iOSItemID])->first();

        if (!$oOrdemServicoItem) return;

        $oOrdemServicoItem->lote_codigo = $sLoteCodigo;
        $oOrdemServicoItem->lote_item = $sLoteItem;

        TableRegistry::getTableLocator()->get('OrdemServicoItens')->save($oOrdemServicoItem);
    }

    public function saveOrdemServicoItem( $that, $aItem, $iMercadoriaItemID )
    {
        unset($aItem['avarias']);
        $aItem['documento_mercadoria_item_id'] = $iMercadoriaItemID;
        $aItem['peso']        = DoubleUtil::toDBUnformat($aItem['peso_bruto']);
        $aItem['quantidade']  = DoubleUtil::toDBUnformat($aItem['quantidade']);
        $aItem['temperatura'] = DoubleUtil::toDBUnformat($aItem['temperatura']);
        $aItem['m2'] = isset($aItem['m2']) ? DoubleUtil::toDBUnformat($aItem['m2']) : 0;
        $aItem['m3'] = isset($aItem['m3']) ? DoubleUtil::toDBUnformat($aItem['m3']) : 0;
        $oOrdemServicoItem = $that->setEntity('OrdemServicoItens', $aItem);
        $oOrdemServicoItemOld = ObjectUtil::getAsObject($oOrdemServicoItem);

        if ( $oOrdemServicoItem->isNew() ){
            $oOrdemServicoItem = $that->OrdemServicoItens->patchEntity($oOrdemServicoItem, $aItem);
        }else {

            if ( $aItem['quantidade'] > $oOrdemServicoItem->quantidade){
                $oOrdemServicoItem->quantidade += $aItem['quantidade'] - $oOrdemServicoItem->quantidade;
            }elseif ($aItem['quantidade'] < $oOrdemServicoItem->quantidade) {
                $oOrdemServicoItem->quantidade -= $oOrdemServicoItem->quantidade - $aItem['quantidade'];
            }

            if ( $aItem['peso'] > $oOrdemServicoItem->peso){
                $oOrdemServicoItem->peso += $aItem['peso'] - $oOrdemServicoItem->peso;
            }elseif ($aItem['peso'] < $oOrdemServicoItem->peso) {
                $oOrdemServicoItem->peso -= $oOrdemServicoItem->peso - $aItem['peso'];
            }
            
        }

        if ($result = $that->OrdemServicoItens->save($oOrdemServicoItem))
            return [
                'message' => 'OK',
                'status' => 200,
                'dataExtra' => [ 
                    'id' => $result->id,
                    'ordem_servico_item' => $oOrdemServicoItem,
                    'ordem_servico_item_old' => $oOrdemServicoItemOld
                ]
            ];

        return [
            'message' => 'Houve algum problema ao salvar Item da Ordem de servico! ' . EntityUtil::dumpErrors($oOrdemServicoItem),
            'status' => 406
        ];
    }

    private function checkExistsOSItem($that, $aItem)
    {
        return $that->OrdemServicoItens->find()
            ->where([
                'documento_mercadoria_item_id' => $aItem['documento_mercadoria_item_id'],
                'ordem_servico_id'             => $aItem['ordem_servico_id'],
                'unidade_medida_id'            => $aItem['unidade_medida_id']
            ])
            ->first();
    }

    private function getLastSequenciaOS($that, $aItem, $iMercadoriaItemID)
    {
        return $that->OrdemServicoItens->find()
                ->where([
                    'documento_mercadoria_item_id' => $iMercadoriaItemID,
                    'unidade_medida_id' => $aItem['unidade_medida_id']
                ])
                ->order('id', 'ASC')
                ->first(); 
    }

    public function removeEntradaFisica($that, $aData)
    {
        if ( !isset($aData['id']) || !isset($aData['endereco_id']) || !isset($aData['etiqueta_produto_id']) )
            return [
                'message' => __('<br><br>Faltam parâmetros para poder deletar a Entrada Física! <br><br> Favor entrar em contato com os administradores!'),
                'status'  => 406
            ];

        $bIncrementaDocMercItem = ($x = ParametroGeral::getParametro($that, 'DESCARGA_INCREMENTA_DOC_MERC_ITEM')) ? (int) $x->valor : 0;

        $oOrdemServicoItem = $that->OrdemServicoItens->get($aData['id']);
        $bGeraEtiqueta = !$oOrdemServicoItem->produto_id 
            ? true 
            : Produto::getParam('gera_etiqueta', $oOrdemServicoItem->produto_id);
     
        $that->TermoAvarias->deleteAll(
            [
                'TermoAvarias.ordem_servico_item_id' => $aData['id']
            ],
            false 
        );
        
        $oDocumentosMercadoriasItem = $that->DocumentosMercadoriasItens->find('all')
            ->where([
                'id' => $oOrdemServicoItem->documento_mercadoria_item_id
            ])
            ->first();
                
        $sLoteCodigo = $that->DocumentosMercadorias->get($oDocumentosMercadoriasItem->documentos_mercadoria_id)->lote_codigo;
        
        if ($bGeraEtiqueta) {
            $oEtiquetaProdutos = $that->EtiquetaProdutos->find()
                ->where([
                    'endereco_id'                  => $aData['endereco_id'],
                    'documento_mercadoria_item_id' => $oOrdemServicoItem->documento_mercadoria_item_id,
                    'unidade_medida_id'            => $oOrdemServicoItem->unidade_medida_id,
                    'produto_id IS'                => $oOrdemServicoItem->produto_id,
                    'sequencia'                    => $oOrdemServicoItem->sequencia_item,
                    'lote_codigo'                  => $sLoteCodigo,
                    'empresa_id'                   => $that->getEmpresaAtual(),
                    'qtde'                         => $oOrdemServicoItem->quantidade,
                    'peso'                         => $oOrdemServicoItem->peso,
                    'id'                           => $aData['etiqueta_produto_id']
                ])
                ->first();
        }else {
            $oEtiquetaProdutos = new stdClass;
        }
        
        $oOrdemServicoItem->lote_codigo = $oOrdemServicoItem->lote_codigo ?: $oEtiquetaProdutos->lote_codigo;
        $oOrdemServicoItem->lote_item   = $oOrdemServicoItem->lote_item   ?: $oEtiquetaProdutos->lote_item;

        $oEstoque = $that->Estoques->find()
            ->where([
                'lote_item'         => $oOrdemServicoItem->lote_item,
                'lote_codigo'       => $oOrdemServicoItem->lote_codigo,
                'unidade_medida_id' => $oOrdemServicoItem->unidade_medida_id,
                'empresa_id'        => $that->getEmpresaAtual(),
                'qtde_saldo >= 0',
                'peso_saldo >= 0'
            ] + ProdutosControlados::getProdutoControlesValuesToQuery($oOrdemServicoItem, false, false, true, 'Estoques') )
            ->first();

        //Caso haja estoque
        if ($oEstoque) {
            $oEstoque->qtde_saldo -= $oOrdemServicoItem->quantidade;
            $oEstoque->peso_saldo -= $oOrdemServicoItem->peso;
            $oEstoque->qtde_saldo = $oEstoque->qtde_saldo < 0 ? 0 : $oEstoque->qtde_saldo;
            $oEstoque->peso_saldo = $oEstoque->peso_saldo < 0 ? 0 : $oEstoque->peso_saldo;
            
            $oEstoqueEnderecos = $that->EstoqueEnderecos->find()
                ->where([
                    'estoque_id'        => $oEstoque->id,
                    'endereco_id'       => $oOrdemServicoItem->endereco_id,
                    'unidade_medida_id IS' => $oOrdemServicoItem->unidade_medida_id,
                    'lote_codigo IS'       => $oEstoque->lote_codigo,
                    'lote_item IS'         => $oEstoque->lote_item,
                    'qtde_saldo'        => $oOrdemServicoItem->quantidade,
                    'peso_saldo'        => $oOrdemServicoItem->peso
                ] + ProdutosControlados::getProdutoControlesValuesToQuery([
                    'produto_id' => $oOrdemServicoItem->produto_id,
                    'validade'   => $oOrdemServicoItem->validade,
                    'serie'      => $oOrdemServicoItem->serie,
                    'lote'       => $oOrdemServicoItem->lote,
                ]) )
                ->toArray();

            if (!$oEstoqueEnderecos)
                return [
                    'message' => __('Não foi possível encontrar o estoque endereço deste item, favor voltar o item para o endereço de origem!'),
                    'status'  => 400
                ];

            foreach ($oEstoqueEnderecos as $key => $oEstoqueEndereco) {
                $oEstoqueEndereco->qtde_saldo -= $oOrdemServicoItem->quantidade;
                $oEstoqueEndereco->peso_saldo -= $oOrdemServicoItem->peso;
                $oEstoqueEndereco->m2_saldo   -= $oOrdemServicoItem->m2;
                $oEstoqueEndereco->m3_saldo   -= $oOrdemServicoItem->m3;
                
                MovimentacoesEstoque::saveMovimentacao($that, [
                    'quantidade_movimentada' => $oOrdemServicoItem->quantidade,
                    'estoque_id'             => $oEstoqueEndereco->estoque_id,
                    'endereco_origem_id'     => $oEstoqueEndereco->endereco_id,
                    'tipo_movimentacao_id'   => 8
                ]);
                
                $that->EstoqueEnderecos->save($oEstoqueEndereco);

                if (!$oEstoqueEndereco->qtde_saldo) 
                    $that->EstoqueEnderecos->delete($oEstoqueEndereco);
            }
            
            $that->Estoques->save($oEstoque);

            if (!$oEstoque->qtde_saldo)
                $that->Estoques->delete($oEstoque);
        }

        if ($bGeraEtiqueta && @$oEtiquetaProdutos) {
            $that->EtiquetaProdutos->delete($oEtiquetaProdutos);
        }

        $that->OrdemServicoItens->delete($oOrdemServicoItem);

        if ($bIncrementaDocMercItem) {
            $oDocumentosMercadoriasItem->quantidade  -= $oOrdemServicoItem->quantidade;
            $oDocumentosMercadoriasItem->peso_bruto  -= $oOrdemServicoItem->peso;

            $that->DocumentosMercadoriasItens->save($oDocumentosMercadoriasItem);
        }

        return [
            'message' => __('Sucesso!'),
            'status'  => 200
        ];
    }

    public static function getByOrdemServico($iOrderServico){

        return TableRegistry::get('OrdemServicoItens')
            ->find()
            ->where(['ordem_servico_id'=>$iOrderServico]);

    }

    public static function getItensDescarregados ( $that, $iTransporteID, $iOSID )
    {
        //deprecated
        //$sParam = ParametroGeral::getParametro($that, 'LISTA_ENTRADAS_FISICAS_CONFORME_DOC_ENTRADA');
        //$aExibeItensDocumentacao = (isset($sParam->valor) && $sParam->valor == '1') ? true : false;
        $aExibeItensDocumentacao = false;
        $aItens = array();
        
        $aOrdemServicoItens = TableRegistry::getTableLocator()->get('OrdemServicoItens')->find()
            ->select(TableRegistry::getTableLocator()->get('EtiquetaProdutos'))
            ->select(TableRegistry::getTableLocator()->get('DocumentosMercadorias'))
            ->select(TableRegistry::getTableLocator()->get('DocumentosMercadoriasItens'))
            ->select(TableRegistry::getTableLocator()->get('OrdemServicoItens'))
            ->select(TableRegistry::getTableLocator()->get('UnidadeMedidas'))
            ->select(TableRegistry::getTableLocator()->get('Enderecos'))
            ->select(TableRegistry::getTableLocator()->get('Areas'))
            ->select(TableRegistry::getTableLocator()->get('Locais'))
            ->select(TableRegistry::getTableLocator()->get('ControleEspecificos'))
            ->join([
                'EtiquetaProdutos' => [
                    'table' => 'etiqueta_produtos',
                    'type' => 'LEFT',
                    'conditions' => [
                        'EtiquetaProdutos.documento_mercadoria_item_id = OrdemServicoItens.documento_mercadoria_item_id ',
                        'EtiquetaProdutos.lote_codigo = OrdemServicoItens.lote_codigo ',
                        'EtiquetaProdutos.lote_item = OrdemServicoItens.lote_item ',
                        '((OrdemServicoItens.produto_id IS NOT NULL AND EtiquetaProdutos.produto_id = OrdemServicoItens.produto_id) OR (OrdemServicoItens.produto_id IS NULL AND EtiquetaProdutos.produto_id IS NULL )) ',
                        'EtiquetaProdutos.endereco_id = OrdemServicoItens.endereco_id ',
                        '((OrdemServicoItens.lote IS NOT NULL AND EtiquetaProdutos.lote = OrdemServicoItens.lote) OR (OrdemServicoItens.lote IS NULL AND EtiquetaProdutos.lote IS NULL ))',
                        '((OrdemServicoItens.validade IS NOT NULL AND EtiquetaProdutos.validade = OrdemServicoItens.validade) OR (OrdemServicoItens.validade IS NULL AND EtiquetaProdutos.validade IS NULL ))',
                        '((OrdemServicoItens.serie IS NOT NULL AND EtiquetaProdutos.serie = OrdemServicoItens.serie) OR (OrdemServicoItens.serie IS NULL AND EtiquetaProdutos.serie IS NULL ))'
                    ]
                ]
            ])
            ->contain([
                'TermoAvariasLeft',
                'DocumentosMercadoriasItens' => [
                    'DocumentosMercadorias'
                ],
                'UnidadeMedidas',
                'Enderecos' => [
                    'Areas' => [
                        'Locais'
                    ]
                ],
                'ControleEspecificos'
            ])
            ->where([
                'DocumentosMercadorias.documento_transporte_id' => $iTransporteID,
                'OrdemServicoItens.ordem_servico_id' => $iOSID
            ])
            ->toArray();

        //Preenche as avarias
        // foreach ($aOrdemServicoItens as $key => $oOrdemServicoItem) {
        //     $aOrdemServicoItens[$key]->termo_avarias = $that->TermoAvarias->find()
        //         ->contain('OrdemServicoItens')
        //         ->where([
        //             'OrdemServicoItens.quantidade' => $aOrdemServicoItens[$key]->qtde,
        //             'OrdemServicoItens.peso' => $aOrdemServicoItens[$key]->peso,
        //             'OrdemServicoItens.id = TermoAvarias.ordem_servico_item_id',
        //             'OrdemServicoItens.documento_mercadoria_item_id' => $oOrdemServicoItem->documento_mercadoria_item_id
        //         ])
        //         ->toArray();
        // }

        $aItensAgroup = [];

        //agrupa por ordem_servico_item
        foreach ($aOrdemServicoItens as $key => $oOrdemServicoItem) {
            $oOrdemServicoItem->EtiquetaProdutos = ObjectUtil::getAsObject($oOrdemServicoItem->EtiquetaProdutos);
            $aItensAgroup[ $oOrdemServicoItem->id ] = $oOrdemServicoItem;
        }

        //agrupa por house
        foreach ($aItensAgroup as $key => $oOrdemServicoItem) {
            $aItens[ $oOrdemServicoItem->documentos_mercadorias_item->documentos_mercadoria_id ][] = $oOrdemServicoItem;
        }

        if ($aExibeItensDocumentacao) {
            $aItens = DocumentosMercadoriasItem::getItensDescarga($aItens, $iTransporteID);
        }
        
        return $aItens;
    }

    public function getContainersDescarregar($oOrdemServico)
    {
        $aContainersDescarregar = [];
        foreach ($oOrdemServico->resv->resvs_containers as $aContainer) {

            if ($aContainer->operacao_id == EntityUtil::getIdByParams('Operacoes', 'descricao', 'Carga'))
                continue;

            $oContainerDescarregado = LgDbUtil::getFind('OrdemServicoItens')
                ->where([
                    'ordem_servico_id' => $oOrdemServico->id,
                    'container_id'     => $aContainer->container->id
                ])
                ->first();

            if (!$oContainerDescarregado)
                $aContainersDescarregar[$aContainer->container->id] = $aContainer->container->numero . ' - ' . $aContainer->tipo;
            
        }

        return $aContainersDescarregar;
    }

    public function getContainersDescarregados($oOrdemServico)
    {
        $aContainers = LgDbUtil::getFind('OrdemServicoItens')
            ->select(['container_id', 'Containers.numero'])
            ->contain(['Containers'])
            ->where([
                'ordem_servico_id' => $oOrdemServico->id
            ])
            ->group(['container_id', 'Containers.numero'])->toArray();

        $aContainersDescarregados = [];
        foreach ($aContainers as $aContainer) {
            $aContainersDescarregados[$aContainer->container_id] = $aContainer->container->numero;
        }

        return $aContainersDescarregados;
    }

    public static function saveContainerOrdemServicoItens($iOSID, $oContainer)
    {
        $oResponse = new ResponseUtil();

        $aData = $oContainer->estoque_endereco_container_vazio;
        $aDataInsert = [
            'lote_codigo'       => $aData->lote_codigo,
            'lote_item'         => $aData->lote_item,
            'sequencia_item'    => 1,
            'quantidade'        => $aData->qtde_saldo,
            'peso'              => $aData->peso_saldo,
            'm2'                => $aData->m2_saldo,
            'm3'                => $aData->m3_saldo,
            'ordem_servico_id'  => $iOSID,
            'unidade_medida_id' => $aData->unidade_medida_id,
            'produto_id'        => $aData->produto_id,
            'lote'              => $aData->lote,
            'serie'             => $aData->serie,
            'validade'          => $aData->validade,
            'endereco_id'       => $aData->endereco_id,
            'status_estoque_id' => $aData->status_estoque_id,
            'container_id'      => $oContainer->id
        ];

        if (LgDbUtil::saveNew('OrdemServicoItens', $aDataInsert))
            return $oResponse
                ->setStatus(200)
                ->setMessage('Container salvo com sucesso!')
                ->setTitle('Sucesso!');

        return $oResponse
            ->setStatus(400)
            ->setMessage('Não foi possível adicionar o container!')
            ->setTitle('Ops...!');
    }

    public static function saveLotesOrdemServicoItens($iOSID, $aEnderecoeEstoqueQuantidades)
    {
        $oResponse = new ResponseUtil();

        foreach ($aEnderecoeEstoqueQuantidades as $key => $value) {

            if ($value) {

                $value = DoubleUtil::toDBUnformat($value);
                if ($value == 0)
                    return $oResponse
                        ->setStatus(400)
                        ->setMessage('Digite um valor maior que zero!')
                        ->setTitle('Ops...!');
                
                $oEstoqueEndereco = LgDbUtil::getFirst('EstoqueEnderecos', ['id' => $key]);
                
                $iSeguenciaItem = substr($oEstoqueEndereco->lote_item, -1);
                $oDocumentoMercadoria = LgDbUtil::getFind('DocumentosMercadorias')
                    ->contain([
                        'DocumentosMercadoriasItens' => function ($q) use ($oEstoqueEndereco, $iSeguenciaItem) {
                            return $q->where([
                                'DocumentosMercadoriasItens.produto_id'        => $oEstoqueEndereco->produto_id,
                                'DocumentosMercadoriasItens.unidade_medida_id' => $oEstoqueEndereco->unidade_medida_id,
                                'DocumentosMercadoriasItens.sequencia_item'    => $iSeguenciaItem,
                            ]);
                        }
                    ])
                    ->where([
                        'DocumentosMercadorias.lote_codigo' => $oEstoqueEndereco->lote_codigo,
                    ])
                    ->first();

                $oOrdemServicoItem = LgDbUtil::getFind('OrdemServicoItens')
                    ->where([
                        'lote_codigo'      => $oEstoqueEndereco->lote_codigo,
                        'lote_item'        => $oEstoqueEndereco->lote_item,
                        'endereco_id'      => $oEstoqueEndereco->endereco_id,
                        'ordem_servico_id' => $iOSID,
                    ])->first();

                if (!$oOrdemServicoItem) {
                    $aDataInsert = [
                        'lote_codigo'       => $oEstoqueEndereco->lote_codigo,
                        'lote_item'         => $oEstoqueEndereco->lote_item,
                        'sequencia_item'    => 1,
                        'quantidade'        => $value,
                        'peso'              => $oEstoqueEndereco->peso_saldo,
                        'm2'                => $oEstoqueEndereco->m2_saldo,
                        'm3'                => $oEstoqueEndereco->m3_saldo,
                        'ordem_servico_id'  => $iOSID,
                        'unidade_medida_id' => $oEstoqueEndereco->unidade_medida_id,
                        'produto_id'        => $oEstoqueEndereco->produto_id,
                        'lote'              => $oEstoqueEndereco->lote,
                        'serie'             => $oEstoqueEndereco->serie,
                        'validade'          => $oEstoqueEndereco->validade,
                        'endereco_id'       => $oEstoqueEndereco->endereco_id,
                        'status_estoque_id' => $oEstoqueEndereco->status_estoque_id,
                        'documento_mercadoria_item_id' => @$oDocumentoMercadoria->documentos_mercadorias_itens[0]->id
                    ];
    
                    if (!LgDbUtil::saveNew('OrdemServicoItens', $aDataInsert))
                        return $oResponse
                            ->setStatus(400)
                            ->setMessage('Não foi possível adicionar o item: ' . $oEstoqueEndereco->lote_item . ' do lote: ' . $oEstoqueEndereco->lote_item)
                            ->setTitle('Ops...!');
                } else {
                    $oOrdemServicoItem->quantidade += $value;
                    if (!LgDbUtil::save('OrdemServicoItens', $oOrdemServicoItem))
                        return $oResponse
                            ->setStatus(400)
                            ->setMessage('Não foi possível adicionar o item: ' . $oEstoqueEndereco->lote_item . ' do lote: ' . $oEstoqueEndereco->lote_item)
                            ->setTitle('Ops...!');
                }
            }
        }

        return $oResponse
            ->setStatus(200)
            ->setMessage('Lotes salvos com sucesso!')
            ->setTitle('Sucesso!');
    }

    public static function getContainersOvar($oOrdemServico)
    {
        if (!$oOrdemServico)
            return null;

        if ($oOrdemServico->ordem_servico_itens) {

            $aContainersOvar = [];
            foreach ($oOrdemServico->ordem_servico_itens as $oItem) {
                if ($oItem->container) {
                    $aContainersOvar[$oItem->container->id] = [
                        'ordem_servico_item_id' => $oItem->id,
                        'container_id'          => $oItem->container->id,
                        'container_numero'      => $oItem->container->numero
                    ]; 
                }
            }

            foreach ($oOrdemServico->ordem_servico_itens as $oItem) {
                if ($oItem->container && $oItem->produto) {
                    $oContainerLotes = [];
                    $oContainerLotes = [
                        'lote_codigo'           => $oItem->lote_codigo,
                        'lote_item'             => $oItem->lote_item,
                        'produto_descricao'     => $oItem->produto->descricao,
                        'endereco'              => $oItem->endereco,
                        'quantidade'            => $oItem->quantidade,
                        'ordem_servico_item_id' => $oItem->id,
                        'volumes'               => $oItem->volumes,
                        'unidade_medida'        => LgDbUtil::getByID('UnidadeMedidas', $oItem->unidade_medida_id)->codigo
                    ];

                    $aContainersOvar[$oItem->container->id]['container_lotes'][] = $oContainerLotes;

                }
            }

            return $aContainersOvar;
        }

        return null;
    }

    public static function getLotesOvar($oOrdemServico)
    {
        if (!$oOrdemServico)
            return null;

        if ($oOrdemServico->ordem_servico_itens) {
            $aLotesOvar = [];
            foreach ($oOrdemServico->ordem_servico_itens as $oItem) {
                if (!$oItem->container) {

                    $aConditions = ProdutosControlados::getProdutoControlesValuesToQuery($oItem, false, false, true, 'EtiquetaProdutos');
                    if (array_key_exists('status_estoque_id IS', $aConditions))
                        unset($aConditions['status_estoque_id IS']);
                        
                    $oEtiquetaProduto = LgDbUtil::getFirst('EtiquetaProdutos', $aConditions);

                    $aLotesOvar[] = [
                        'lote_codigo'           => $oItem->lote_codigo,
                        'lote_item'             => $oItem->lote_item,
                        'produto_descricao'     => $oItem->produto->descricao,
                        'endereco'              => $oItem->endereco,
                        'quantidade'            => $oItem->quantidade,
                        'ordem_servico_item_id' => $oItem->id,
                        'etiqueta_produto_id'   => $oEtiquetaProduto ? $oEtiquetaProduto->id : null,
                        'codigo_barras'         => $oEtiquetaProduto ? $oEtiquetaProduto->codigo_barras : null,
                        'volumes'               => $oItem->volumes,
                        'unidade_medida'        => LgDbUtil::getByID('UnidadeMedidas', $oItem->unidade_medida_id)->codigo
                    ];
                }
            }
            return $aLotesOvar;
        }

        return null;
    }

    public static function getLotesIdsFromContainer($ordemServicoItem)
    {
        $oOrdemServicoItemContainer = LgDbUtil::getFind('OrdemServicoItens')
            ->where([
                'container_id IS NOT' => null,
                'container_id !='     => $ordemServicoItem->container_id,
                'ordem_servico_id'    => $ordemServicoItem->ordem_servico_id,
            ])->first();

        if ($oOrdemServicoItemContainer)
            return null;

        $oOrdemServicoItemCargaGeral = LgDbUtil::getFind('OrdemServicoItens')
            ->where([
                'container_id IS ' => null,
                'ordem_servico_id' => $ordemServicoItem->ordem_servico_id,
            ])->toArray();

        if ($oOrdemServicoItemCargaGeral) {
            $aOsItensIDs = [];
            foreach ($oOrdemServicoItemCargaGeral as $oItem) {
                $aOsItensIDs[] = $oItem->id;
            }

            return $aOsItensIDs;
        }

        return null;
    }

    public static function saveContainerOrdemServicoItensOsContainer($iOSID, $oContainer)
    {
        $oResponse = new ResponseUtil();

        $aDataInsert = [
            'sequencia_item'    => 1,
            'quantidade'        => $oContainer->estoque_enderecos[0]->qtde_saldo,
            'peso'              => $oContainer->estoque_enderecos[0]->peso_saldo,
            'm2'                => $oContainer->estoque_enderecos[0]->m2_saldo,
            'm3'                => $oContainer->estoque_enderecos[0]->m3_saldo,
            'ordem_servico_id'  => $iOSID,
            'endereco_id'       => $oContainer->estoque_enderecos[0]->endereco_id,
            'unidade_medida_id' => $oContainer->estoque_enderecos[0]->unidade_medida_id,
            'container_id'      => $oContainer->id
        ];

        if (LgDbUtil::saveNew('OrdemServicoItens', $aDataInsert))
            return $oResponse
                ->setStatus(200)
                ->setMessage('Container salvo com sucesso!')
                ->setTitle('Sucesso!');

        return $oResponse
            ->setStatus(400)
            ->setMessage('Não foi possível adicionar o container!')
            ->setTitle('Ops...!');
    }

    public static function getOsServicoContainers($oOrdemServico)
    {
        if (!$oOrdemServico)
            return null;

        if ($oOrdemServico->ordem_servico_itens) {

            $aContainersOvar = [];
            foreach ($oOrdemServico->ordem_servico_itens as $oItem) {
                if ($oItem->container) {
                    $aContainersOvar[$oItem->container->id] = [
                        'ordem_servico_item_id' => $oItem->id,
                        'container_id'          => $oItem->container->id,
                        'container_numero'      => $oItem->container->numero
                    ]; 
                }
            }

            return $aContainersOvar;

        }

        return null;
    }

    public static function deleteOsItem($iOsItemID)
    {
        $oResponse = new ResponseUtil();

        $oOrdemServicoItemEntity = LgDbUtil::get('OrdemServicoItens');
        $oOrdemServicoItem       = LgDbUtil::getFirst('OrdemServicoItens', ['id' => $iOsItemID]);

        if (!$oOrdemServicoItem)
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('Ordem Serviço Item não encontrado!');

        if (!$oOrdemServicoItemEntity->delete($oOrdemServicoItem))
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('Erro ao remover Ordem Serviço Item!');

        return $oResponse
            ->setStatus(200)
            ->setTitle('Sucesso!')
            ->setMessage('Ordem Serviço Item removido com sucesso!');
    }

    public static function divergencias($iOs, $iTransporte){

        $fPorcentagem = ParametroGeral::getParametroWithValue(
            'PARAM_PORCENTAGEM_DIVERGEMCIA_PESO'
        );

        $fPorcentagem = $fPorcentagem ? (double) $fPorcentagem : 0;
        $fValorPorcentagem = $fPorcentagem ? $fPorcentagem / 100 : 0;
        
        $oTransporte = LgDbUtil::getFind('DocumentosTransportes')
            ->contain(['TipoDocumentos'])
            ->where(['DocumentosTransportes.id' => $iTransporte])
            ->first();

        $sTipoDocumento = $oTransporte->tipo_documento->tipo_documento;

        $aData = LgDbUtil::getFind('DocumentosMercadorias')
            ->contain([
                'DocumentosTransportes',
                'DocumentosMercadoriasAWB',
                'OrdemServicoItemManyLeft' => function($q) use($iOs){
                    return $q->where([
                        'ordem_servico_id' => $iOs
                    ]);
                }
            ])
            ->where([
                'DocumentosMercadorias.documento_mercadoria_id_master is NOT NULL',
                'DocumentosMercadorias.documento_transporte_id' => $iTransporte,
            ])
            ->toArray();

        $aDivergencias = [];

        foreach ($aData as $key => $oDoc) {

            if(empty($oDoc->ordem_servico_itens)){
                $aDivergencias [$oDoc->id] = $oDoc;
                continue;
            }

            $fQtdeTotal = 0;
            $fPesoTotal = 0;
            foreach ($oDoc->ordem_servico_itens as $value) {
                $fQtdeTotal += (double) $value->quantidade;
                $fPesoTotal += (double) $value->peso;
            }

            $fDocumentoPeso = $oDoc->peso_bruto ?:1;
            
            if(round($fQtdeTotal, 2) != round($oDoc->volume, 2)){
                $aDivergencias [$oDoc->id] = $oDoc;
                continue;
            }

            if(round($fPesoTotal, 2) == round($oDoc->peso_bruto, 2)){
                continue;
            }
            
            if(!$fPorcentagem && round($fPesoTotal, 2) != round($oDoc->peso_bruto, 2)){
                $aDivergencias [$oDoc->id] = $oDoc;
                continue;
            }

            $fPorcentagemCarregada = ($fPesoTotal / $fDocumentoPeso) * 100;
                       
            if($fPorcentagemCarregada >  ($fPorcentagem + 100) ) {
                $aDivergencias [$oDoc->id] = $oDoc;
                continue;
            }

            $fPorcentagemSemCarregar = 100 - $fPorcentagemCarregada;
        
            if($fPorcentagemSemCarregar > $fPorcentagem){
                $aDivergencias [$oDoc->id] = $oDoc;
                continue;
            }
        }
    
        if(empty($aDivergencias)) return (new ResponseUtil())
            ->setStatus(200)
            ->setTitle('Deseja prosseguir?')
            ->setMessage('A Ordem de Serviço será finalizada ao prosseguir');

        $aTexto = [];
        foreach ($aDivergencias as $key => $value) {
            $sMaster    = (string) @$value->DocumentosMercadorias->numero_documento;
            $sHouse     = (string) @$value->numero_documento;
            $key =  $sMaster.'_'.$sHouse;
            $aTexto[$key] = 'Master => ' . $sMaster. ' - '.'House => '.$sHouse;
        }

        ksort($aTexto);

        $sDivergencias = implode('<br>', $aTexto);

        if($sTipoDocumento == 'NF'){
            return (new ResponseUtil())
                ->setTitle('Você tem certeza?')
                ->setMessage("Há divergências na descarga da NF." );
        }

        return (new ResponseUtil())
            ->setTitle('Você tem certeza?')
            ->setMessage('Há divergências entre os Conhecimentos: <br> '. $sDivergencias);

    }
}

