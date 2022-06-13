<?php
namespace App\Model\Entity;

use App\RegraNegocio\GerenciamentoEstoque\ProdutosControlados;
use Cake\ORM\Entity;
use Cake\Datasource\ConnectionManager;

use App\Util\DateUtil;
use App\Util\EntityUtil;
use App\Util\DoubleUtil;
use App\Util\LgDbUtil;
use App\Util\ResponseUtil;
use stdClass;

/**
 * LiberacoesDocumental Entity
 *
 * @property int $id
 * @property string $nome
 * @property string|null $numero_documento_liberacao
 * @property string $numero
 * @property \Cake\I18n\Time $data_registro
 * @property \Cake\I18n\Time $data_desembaraco
 * @property int $quantidade_adicoes
 * @property float $valor_fob_moeda
 * @property float $valor_frete_moeda
 * @property float $valor_seguro_moeda
 * @property float $valor_cif_moeda
 * @property float|null $quantidade_total
 * @property float $peso_bruto
 * @property float $peso_liquido
 * @property string $observacao
 * @property int $empresa_id
 * @property int $cliente_id
 * @property int $tipo_documento_id
 * @property int $moeda_fob_id
 * @property int $moeda_frete_id
 * @property int $moeda_seguro_id
 * @property int $moeda_cif_id
 * @property int $canal_id
 * @property int $regime_aduaneiro_id
 * @property int|null $aftn_id
 * @property int|null $tipo_documento_liberacao_id
 *
 * @property \App\Model\Entity\Empresa $empresa
 * @property \App\Model\Entity\TipoDocumento $tipo_documento
 * @property \App\Model\Entity\Moeda $moeda
 * @property \App\Model\Entity\Canal $canal
 * @property \App\Model\Entity\RegimesAduaneiro $regimes_aduaneiro
 * @property \App\Model\Entity\Aftm $aftm
 */
class LiberacoesDocumental extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * Default Fields:
     * 
     *  'nome' => true,
     *  'numero_documento_liberacao' => true,
     *  'numero' => true,
     *  'data_registro' => true,
     *  'data_desembaraco' => true,
     *  'quantidade_adicoes' => true,
     *  'valor_fob_moeda' => true,
     *  'valor_frete_moeda' => true,
     *  'valor_seguro_moeda' => true,
     *  'valor_cif_moeda' => true,
     *  'quantidade_total' => true,
     *  'peso_bruto' => true,
     *  'peso_liquido' => true,
     *  'observacao' => true,
     *  'empresa_id' => true,
     *  'cliente_id' => true,
     *  'tipo_documento_id' => true,
     *  'moeda_fob_id' => true,
     *  'moeda_frete_id' => true,
     *  'moeda_seguro_id' => true,
     *  'moeda_cif_id' => true,
     *  'canal_id' => true,
     *  'regime_aduaneiro_id' => true,
     *  'aftn_id' => true,
     *  'tipo_documento_liberacao_id' => true,
     *  'empresa' => true,
     *  'moeda_cif' => true,
     *  'tipo_documento' => true,
     *  'moeda' => true,
     *  'canal' => true,
     *  'regimes_aduaneiro' => true,
     *  'aftm' => true,
     *  'cotacao_fob_moeda' => true,
     *  'cotacao_frete_moeda' => true,
     *  'cotacao_seguro_moeda' => true,
     *  'cotacao_cif_moeda' => true,
     *  'pessoa_id' =>true
     * 
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function setData($oThat, $liberacoesDocumental)
    {
        $sDataHoje = $liberacoesDocumental->data_registro;
        
        $liberacoesDocumental->peso_bruto         = DoubleUtil::fromDBUnformat($liberacoesDocumental->peso_bruto, 4);
        $liberacoesDocumental->peso_liquido       = DoubleUtil::fromDBUnformat($liberacoesDocumental->peso_liquido, 4);
        
        $cotacao_fob = LgDbUtil::get('MoedasCotacoes')->find()
            ->where([
                'moeda_id' => $liberacoesDocumental->moeda_fob_id, 
                'data_cotacao' => $sDataHoje
            ])
            ->order('data_cotacao', 'DESC')
            ->first();
        $cotacao_frete = LgDbUtil::get('MoedasCotacoes')->find()
            ->where([
                'moeda_id' => $liberacoesDocumental->moeda_frete_id, 
                'data_cotacao' => $sDataHoje
            ])
            ->order('data_cotacao', 'DESC')
            ->first();
        $cotacao_seguro = LgDbUtil::get('MoedasCotacoes')->find()
            ->where([
                'moeda_id' => $liberacoesDocumental->moeda_seguro_id, 
                'data_cotacao' => $sDataHoje
            ])
            ->order('data_cotacao', 'DESC')
            ->first();
        $cotacao_cif = LgDbUtil::get('MoedasCotacoes')->find()
            ->where([
                'moeda_id' => $liberacoesDocumental->moeda_cif_id, 
                'data_cotacao' => $sDataHoje
            ])
            ->order('data_cotacao', 'DESC')
            ->first();

        $oReal = LgDbUtil::getFirst('Moedas', ['sigla' => 'BRL']);

        $iFobDefault    = $liberacoesDocumental->moeda_fob_id      == $oReal->id ? 1 : 0;
        $iFreteDefault  = $liberacoesDocumental->moeda_frete_id    == $oReal->id ? 1 : 0;
        $iSeguroDefault = $liberacoesDocumental->moeda_seguro_id   == $oReal->id ? 1 : 0;
        $iCifDefault    = $liberacoesDocumental->moeda_cif_id      == $oReal->id ? 1 : 0;

        $cotacao_fob    = $cotacao_fob    ? $cotacao_fob->valor_cotacao    : $iFobDefault;
        $cotacao_frete  = $cotacao_frete  ? $cotacao_frete->valor_cotacao  : $iFreteDefault;
        $cotacao_seguro = $cotacao_seguro ? $cotacao_seguro->valor_cotacao : $iSeguroDefault;
        $cotacao_cif    = $cotacao_cif    ? $cotacao_cif->valor_cotacao    : $iCifDefault;

        $liberacoesDocumental->resultado_moeda_fob    = DoubleUtil::fromDBUnformat(
           $cotacao_fob * $liberacoesDocumental->valor_fob_moeda
        );
        $liberacoesDocumental->resultado_moeda_frete  = DoubleUtil::fromDBUnformat(
           $cotacao_frete * $liberacoesDocumental->valor_frete_moeda
        );
        $liberacoesDocumental->resultado_moeda_seguro = DoubleUtil::fromDBUnformat(
            $cotacao_seguro * $liberacoesDocumental->valor_seguro_moeda
        );
        $liberacoesDocumental->resultado_moeda_cif    = DoubleUtil::fromDBUnformat(
            $cotacao_cif * $liberacoesDocumental->valor_cif_moeda
        );

        $liberacoesDocumental->cotacao_moeda_fob    = DoubleUtil::fromDBUnformat(
            $cotacao_fob, 4
        );
        $liberacoesDocumental->cotacao_moeda_frete  = DoubleUtil::fromDBUnformat(
            $cotacao_frete, 4
        );
        $liberacoesDocumental->cotacao_moeda_seguro = DoubleUtil::fromDBUnformat(
            $cotacao_seguro, 4
        );
        $liberacoesDocumental->cotacao_moeda_cif    = DoubleUtil::fromDBUnformat(
            $cotacao_cif, 4
        );

        $liberacoesDocumental->valor_fob_moeda    = DoubleUtil::fromDBUnformat(
            $liberacoesDocumental->valor_fob_moeda
        );
        $liberacoesDocumental->valor_frete_moeda  = DoubleUtil::fromDBUnformat(
            $liberacoesDocumental->valor_frete_moeda
        );
        $liberacoesDocumental->valor_seguro_moeda = DoubleUtil::fromDBUnformat(
            $liberacoesDocumental->valor_seguro_moeda
        );
        $liberacoesDocumental->valor_cif_moeda    = DoubleUtil::fromDBUnformat(
            $liberacoesDocumental->valor_cif_moeda
        );

        #$liberacoesDocumental->cif_por_peso_liquido = $liberacoesDocumental->resultado_moeda_cif / $liberacoesDocumental->peso_bruto;
    }


    public static function initPostData($dataPost)
    {
        

        $dataPost['numero'] = trim(str_replace(['-', '.', '/'], ['', '', ''],
            $dataPost['numero']
        ));

        $dataPost['empresa_id']         = Empresa::getEmpresaPadrao();
        $dataPost['peso_bruto']         = DoubleUtil::toDBUnformat($dataPost['peso_bruto']);
        $dataPost['peso_liquido']       = DoubleUtil::toDBUnformat($dataPost['peso_liquido']);

        $sDataHoje = $dataPost['data_registro'] = DateUtil::dateTimeToDB(
            $dataPost['data_registro']
        );

        $dataPost['data_desembaraco']   = DateUtil::dateTimeToDB(
            $dataPost['data_desembaraco']
        );

        $dataPost['data_entrega_retroativa'] = DateUtil::dateTimeToDB(
            $dataPost['data_entrega_retroativa']
        );

        $dataPost['valor_fob_moeda']    = DoubleUtil::toDBUnformat(
            $dataPost['valor_fob_moeda']
        );

        $dataPost['valor_frete_moeda']  = DoubleUtil::toDBUnformat(
            $dataPost['valor_frete_moeda']
        );

        $dataPost['valor_seguro_moeda'] = DoubleUtil::toDBUnformat(
            $dataPost['valor_seguro_moeda']
        );

        $dataPost['valor_cif_moeda']    = DoubleUtil::toDBUnformat(
            $dataPost['valor_cif_moeda']
        );

        $dataPost['quantidade_total'] = isset($dataPost['quantidade_total']) ? 
            DoubleUtil::toDBUnformat($dataPost['quantidade_total']) : null;

        $cotacao_fob = LgDbUtil::get('MoedasCotacoes')->find()
            ->where([
                'moeda_id'      => $dataPost['moeda_fob_id'], 
                'data_cotacao'  => $sDataHoje
            ])
            ->order('data_cotacao', 'DESC')
            ->first();

        $cotacao_frete = LgDbUtil::get('MoedasCotacoes')->find()
            ->where([
                'moeda_id'      => $dataPost['moeda_frete_id'], 
                'data_cotacao'  => $sDataHoje
            ])
            ->order('data_cotacao', 'DESC')
            ->first();

        $cotacao_seguro = LgDbUtil::get('MoedasCotacoes')->find()
            ->where([
                'moeda_id'      => $dataPost['moeda_seguro_id'], 
                'data_cotacao'  => $sDataHoje
            ])
            ->order('data_cotacao', 'DESC')
            ->first();

        $cotacao_cif = LgDbUtil::get('MoedasCotacoes')->find()
            ->where([
                'moeda_id'      => $dataPost['moeda_cif_id'], 
                'data_cotacao'  => $sDataHoje
            ])
            ->order('data_cotacao', 'DESC')
            ->first();

        $oReal = LgDbUtil::getFirst('Moedas', ['sigla' => 'BRL']);

        $iFobDefault    = $dataPost['moeda_fob_id']       == $oReal->id ? 1 : 0;
        $iFreteDefault  = $dataPost['moeda_frete_id']     == $oReal->id ? 1 : 0;
        $iSeguroDefault = $dataPost['moeda_seguro_id']    == $oReal->id ? 1 : 0;
        $iCifDefault    = $dataPost['moeda_cif_id']       == $oReal->id ? 1 : 0;

        $fCotacaoFob    = $cotacao_fob    ? $cotacao_fob->valor_cotacao    : $iFobDefault;
        $fCotacaoFrete  = $cotacao_frete  ? $cotacao_frete->valor_cotacao  : $iFreteDefault;
        $fCotacaoSeguro = $cotacao_seguro ? $cotacao_seguro->valor_cotacao : $iSeguroDefault;
        $fCotacaoCif    = $cotacao_cif    ? $cotacao_cif->valor_cotacao    : $iCifDefault;

        if($cotacao_cif && empty($dataPost['valor_cif_moeda'])){
            $fValorFob       = $fCotacaoFob * $dataPost['valor_fob_moeda'];
            $fValorFrete     = $fCotacaoFrete * $dataPost['valor_frete_moeda'];
            $fValorSeguro    = $fCotacaoSeguro * $dataPost['valor_seguro_moeda'];

            $fValorCif      = $fValorFob + ($fValorFrete + $fValorSeguro);
            $fValorMoedaCif = $fValorCif / $fCotacaoCif;
            $dataPost['valor_cif_moeda'] = $fValorMoedaCif;
        }
        
        if($cotacao_fob && empty($dataPost['valor_fob_moeda'])){
            $fValorCif       = $fCotacaoCif * $dataPost['valor_cif_moeda'];
            $fValorFrete     = $fCotacaoFrete * $dataPost['valor_frete_moeda'];
            $fValorSeguro    = $fCotacaoSeguro * $dataPost['valor_seguro_moeda'];

            $fValorFob      = $fValorCif - ($fValorFrete + $fValorSeguro);
            $fValorMoedaCif = $fValorFob / $fCotacaoFob;
            $dataPost['valor_fob_moeda'] = $fValorMoedaCif;
        }

        return  $dataPost;
    }

    public function getEstoquesArrays ($that, $aData)
    {
        $empresa_atual = $that->getRequest()->getSession()->read('empresa_atual')?:null;
        
        $where = [
            'data_liberacao IS NULL', 
            'DocumentosMercadorias.empresa_id'=>$empresa_atual, 
        ];

        if($aData['type']=='HAWB'){
            $where[]=['DocumentosMercadorias.numero_documento'=>$aData['search']];
        }else{
            $where[]=['DocumentosTransportes.numero'=>$aData['search']];
        }
        

        $bloqueio = $that->Apreensoes->find()
            ->contain(['DocumentosMercadorias'=>'DocumentosTransportes'])
            ->where($where)->count();

        if($bloqueio > 0){
            return [
                'message' => __('<div>Lote Bloqueado, por favor entrar em contato Gerente Operacional.').'</div>',
                'status'  => 400
            ];
        }
        if (isset($aData) && isset($aData['search']) && isset($aData['type']) && $that->request->isAjax()) {
            
            $aWhere = [];
            if ($aData['type'] == 'TERMO') 
                $aWhere  = [
                    'DocumentosTransportes.numero' => $aData['search']
                ];                
            else if ($aData['type'] == 'HAWB') 
                $aWhere  = [
                    'DocumentosMercadorias.numero_documento' => $aData['search']
                ];  

            $aConhecimentos = LgDbUtil::getFind('DocumentosMercadorias')
                ->leftJoinWith('OrdemServicoItemManyLeft.OrdemServicosLeft')
                ->leftJoinWith('OrdemServicoDocumentoRegimeEspecialItens.LeftOrdemServicos')
                ->innerJoinWith('DocumentosMercadoriasAWB')
                ->innerJoinWith('DocumentosTransportes')
                ->innerJoinWith('Estoques.EtiquetaProdutos')
                ->where([
                    'OR' => [
                        [
                            'LeftOrdemServicos.data_hora_fim IS NOT NULL',
                            'LeftOrdemServicos.cancelada' => 0,
                        ],
                        [
                            'OrdemServicosLeft.data_hora_fim IS NOT NULL',
                            'OrdemServicosLeft.cancelada' => 0,
                        ]
                    ]
                ])
                ->where($aWhere)
                ->select([
                    'transporte_numero'   => 'DocumentosTransportes.numero',
                    'master_numero'       => 'DocumentosMercadoriasAWB.numero_documento',
                    'house_numero'        => 'DocumentosMercadorias.numero_documento',
                    'estoque_lote_codigo' => 'Estoques.lote_codigo',
                    'estoque_lote_item'   => 'Estoques.lote_item',
                    'estoque_id'          => 'Estoques.id',
                    'qtde_saldo'          => 'Estoques.qtde_saldo',
                    'peso_saldo'          => 'Estoques.peso_saldo',
                ])
                ->distinct(['Estoques.id'])
                ->toArray();

            if ($aConhecimentos) {

                foreach ($aConhecimentos as &$oConhecimento) {
                    $oConhecimento->qtde_saldo = DoubleUtil::fromDBUnformat($oConhecimento->qtde_saldo, 2);
                    $oConhecimento->peso_saldo = DoubleUtil::fromDBUnformat($oConhecimento->peso_saldo, 3);
                }

                return [
                    'message' => __('Sucesso!'),
                    'data'    => $aConhecimentos,
                    'status'  => 200
                ];
            }


            return [
                'message' => ''
                .'<div>'
                    .'Nenhum estoque encontrado com esse' 
                    .'<b>'.$aData['type'].'</b>.<br>'
                    .'Por favor, verificar ordem Servico foi finalizada.'
                .'</div>',
                'status'  => 400
            ];
        }

        return [
            'message' => __('Faltam parâmetros na requisição!'),
            'status'  => 406
        ];
    }

    public function formatLD( $aLiberacaoDocumentalIDs )
    {
        return [
            'ids'  => explode(',', $aLiberacaoDocumentalIDs),
            'type' => is_array( explode(',', $aLiberacaoDocumentalIDs) ) ? 'multiple' : 'single'
        ];
    }

    public function getLiberacoesDocumentais( $that, $sLiberacaoDocumentalIDs )
    {
        $ids = $this->formatLD($sLiberacaoDocumentalIDs)['ids'];
        
        $aReturn = $that->LiberacoesDocumentais->find()
            ->where(['id IN' => $ids]);
        
        return $aReturn->toArray();
    }

    public function getLiberacoesDocumentaisArrays( $that, $sLiberacaoDocumentalIDs, $bSomenteContainer = false, $iContainerID = null )
    {
        $ids = $this->formatLD($sLiberacaoDocumentalIDs)['ids'];
        $aLiberacoesItens = array();
        $aExtraWhere = [];

        if ($bSomenteContainer)
            $aExtraWhere['LiberacoesDocumentaisItens.container_id IS NOT'] = null;

        if ($iContainerID)
            $aExtraWhere['LiberacoesDocumentaisItens.container_id IS'] = $iContainerID;
        
        $oLiberacoesDocumentaisItens = $that->LiberacoesDocumentaisItens->find()
            ->contain([
                'Produtos',
                'LiberacoesDocumentais',
                'LiberacoesDocumentais.Empresas',
                'EstoquesLeft' => ['UnidadeMedidas'],
                'EstoquesLeft.EtiquetaProdutos',
                'UnidadeMedidas',
                'Containers'
            ])
            ->where([
                'LiberacoesDocumentaisItens.liberacao_documental_id IN' => $ids,
            ] + $aExtraWhere)
            ->toArray();

        if ($oLiberacoesDocumentaisItens) {
            $isLiberacaoPorProduto = 0;

            foreach ($oLiberacoesDocumentaisItens as $keyLiberacaoItem => $oLiberacaoDocumentalItem) {

                if (!$oLiberacaoDocumentalItem->estoque) {
                    $oLiberacaoDocumentalItem->estoque = new stdClass;
                    $oLiberacaoDocumentalItem->estoque->etiqueta_produtos = [];
                }

                $aLiberacoesItens[ $oLiberacaoDocumentalItem->liberacoes_documental->id ]['itens'][] = $oLiberacaoDocumentalItem;
                $aLiberacoesItens[ $oLiberacaoDocumentalItem->liberacoes_documental->id ]['liberacao_dados'] = $oLiberacaoDocumentalItem->liberacoes_documental;

                if (!isset($aLiberacoesItens[ $oLiberacaoDocumentalItem->liberacoes_documental->id ]['liberacao_dados']->liberacao_por_produto)) {
                    $isLiberacaoPorProduto = $oLiberacaoDocumentalItem->liberacao_por_produto;
                    $aLiberacoesItens[ $oLiberacaoDocumentalItem->liberacoes_documental->id ]['liberacao_dados']->liberacao_por_produto = $isLiberacaoPorProduto;
                }
            }
        }

        foreach ($aLiberacoesItens as $iLiberacaoID => $aLiberacaoDados) {

            foreach ($aLiberacaoDados['itens'] as $iKeyItem => $oItem) {
                $aEstoqueEnderecos = LgDbUtil::getFind('EstoqueEnderecos')
                    ->contain([
                        'Enderecos' => [
                            'Areas' => [
                                'Locais'
                            ]
                        ]
                    ])
                    ->where(ProdutosControlados::getProdutoControlesValuesToQuery($oItem))
                    ->toArray();

                foreach ($aEstoqueEnderecos as $oEstoqueEndereco) {
                    $oEstoqueEndereco->endereco->composicao = Endereco::getEnderecoCompletoByID(false, false, $oEstoqueEndereco->endereco, ['com_local_area' => true]);
                }

                $aLiberacoesItens[$iLiberacaoID]['itens'][$iKeyItem]->estoque_enderecos = $aEstoqueEnderecos;
            }
        }

        return $aLiberacoesItens;
    }

    public function carregaCombosInformaChegada( $that )
    {
        $aCombos = array();

        $aCombos['Transportadoras_options'] = $that->Transportadoras
            ->find('list', ['keyField' => 'id', 'valueField' => 'razao_social'])
            ->select(['id', 'razao_social'])
            ->where(['ativo' => 1])->toArray();

        $aCombos['Pessoas_options'] = $that->Resvs->Pessoas
            ->find('list', ['keyField' => 'id', 'valueField' => 'nome_fantasia'])
            ->select(['id', 'nome_fantasia'])
            ->where(['bloqueado' => 0])->toArray();
        
        $aCombos['Modais_options'] = $that->DocumentosTransportes->Modais
            ->find('list', ['keyField' => 'id', 'valueField' => 'descricao'])
            ->select(['id', 'descricao'])->toArray();

        $aCombos['TipoDocumentos_options'] = $that->DocumentosTransportes->TipoDocumentos
            ->find('list', ['keyField' => 'id', 'valueField' => 'tipo_documento'])
            ->select(['id', 'descricao']);

        $aCombos['Operacoes_options'] = $that->Resvs->Operacoes
            ->find('list', ['keyField' => 'id', 'valueField' => 'descricao'])
            ->select(['id', 'descricao']);

        $aCombos['Veiculos_options'] = $that->Veiculos
            ->find('list', ['keyField' => 'id', 
                            'valueField' => 'veiculo_identificacao'])
            ->select(['id', 'veiculo_identificacao']);

        $aCombos['Portarias_options'] = $that->Resvs->Portarias
            ->find('list', ['keyField' => 'id', 
                            'valueField' => 'descricao'])
            ->select(['id', 'descricao']);
        
        return $aCombos;
    }

    public function getTipoFaturamento( $iLiberacaoDocumentalID )
    {

    }

    public function getLiberacaoDocumentalAWBs( $that, $iLiberacaoDocumentalID )
    {
        $aReturn = array();
        $oAWBs = $that->LiberacoesDocumentais->find()
            ->select(['DocumentosMercadoriasAWB.numero_documento'])
            ->innerJoinWith('LiberacoesDocumentaisItens', function(\Cake\ORM\Query $q) {
                return $q->innerJoinWith('Estoques', function(\Cake\ORM\Query $q) {
                    return $q->innerJoinWith('EtiquetaProdutos', function(\Cake\ORM\Query $q) {         
                        $q->innerJoinWith('DocumentosMercadoriasItens', function(\Cake\ORM\Query $q) { 
                            return $q->innerJoinWith('DocumentosMercadorias', function(\Cake\ORM\Query $q) { 
                                return $q->innerJoinWith('DocumentosMercadoriasAWB', function(\Cake\ORM\Query $q) { 
                                    return $q;
                                });
                            });
                        })
                        ->where([
                            'Estoques.lote_item         = EtiquetaProdutos.lote_item',
                            'Estoques.lote_codigo       = EtiquetaProdutos.lote_codigo',
                            'Estoques.unidade_medida_id = EtiquetaProdutos.unidade_medida_id',
                            'Estoques.empresa_id        = EtiquetaProdutos.empresa_id'
                        ]);        
                        return $q;
                    });        
                });
            })
            ->where([
                'LiberacoesDocumentaisItens.liberacao_documental_id' => $iLiberacaoDocumentalID
            ])
            ->toArray();
        
        foreach ($oAWBs as $key => $oAWB) {
            $numero_doc = $oAWB->_matchingData['DocumentosMercadoriasAWB']->numero_documento;

            if (!in_array($numero_doc, $aReturn))
                $aReturn[] = $numero_doc;
        }

        return implode(',', $aReturn);
    }

    public function getLiberacaoDocumentalHAWBs( $that, $iLiberacaoDocumentalID )
    {
        $aReturn = array();
        $oHAWBs = $that->LiberacoesDocumentais->find()
            ->distinct('DocumentosMercadorias.numero_documento')
            ->select('DocumentosMercadorias.numero_documento')
            ->innerJoinWith('LiberacoesDocumentaisItens', function(\Cake\ORM\Query $q) {
                return $q->innerJoinWith('Estoques', function(\Cake\ORM\Query $q) {
                    return $q->innerJoinWith('EtiquetaProdutos', function(\Cake\ORM\Query $q) {         
                        $q->innerJoinWith('DocumentosMercadoriasItens', function(\Cake\ORM\Query $q) { 
                            return $q->innerJoinWith('DocumentosMercadorias', function(\Cake\ORM\Query $q) { 
                                return $q;
                            });
                        })
                        ->where([
                            'Estoques.lote_item         = EtiquetaProdutos.lote_item',
                            'Estoques.lote_codigo       = EtiquetaProdutos.lote_codigo',
                            'Estoques.unidade_medida_id = EtiquetaProdutos.unidade_medida_id',
                            'Estoques.empresa_id        = EtiquetaProdutos.empresa_id'
                        ]);        
                        return $q;
                    });        
                });
            })
            ->where([
                'LiberacoesDocumentaisItens.liberacao_documental_id' => $iLiberacaoDocumentalID
            ])
            ->toArray();

            foreach ($oHAWBs as $key => $oHAWB) {
            $aReturn[] = $oHAWB->_matchingData['DocumentosMercadorias']->numero_documento;
        }

        return implode(',', $aReturn);
    }

    public function getLiberacaoDocumentalDocumentoTransporte( $that, $iLiberacaoDocumentalID )
    {
        $aReturn = array();
        $oDocTransportes = $that->LiberacoesDocumentais->find()
            ->select('DocumentosTransportes.numero')
            ->innerJoinWith('LiberacoesDocumentaisItens', function(\Cake\ORM\Query $q) {
                return $q->innerJoinWith('Estoques', function(\Cake\ORM\Query $q) {
                    return $q->innerJoinWith('EtiquetaProdutos', function(\Cake\ORM\Query $q) {         
                        $q->innerJoinWith('DocumentosMercadoriasItens', function(\Cake\ORM\Query $q) { 
                            return $q->innerJoinWith('DocumentosMercadorias', function(\Cake\ORM\Query $q) { 
                                return $q->innerJoinWith('DocumentosTransportes', function(\Cake\ORM\Query $q) { 
                                    return $q;
                                });
                            });
                        })
                        ->where([
                            'Estoques.lote_item         = EtiquetaProdutos.lote_item',
                            'Estoques.lote_codigo       = EtiquetaProdutos.lote_codigo',
                            'Estoques.unidade_medida_id = EtiquetaProdutos.unidade_medida_id',
                            'Estoques.empresa_id        = EtiquetaProdutos.empresa_id'
                        ]);        
                        return $q;
                    });        
                });
            })
            ->where([
                'LiberacoesDocumentaisItens.liberacao_documental_id' => $iLiberacaoDocumentalID
            ])
            ->toArray();

        foreach ($oDocTransportes as $key => $oDocTransporte) {
            
            $numero_doc = $oDocTransporte->_matchingData['DocumentosTransportes']->numero;

            if (!in_array($numero_doc, $aReturn))
                $aReturn[] = $numero_doc;
        }

        return implode(',', $aReturn);
    }

    public static function haveFaturamento( $that, $iLiberacaoDocumentalID )
    {
        $oFaturamentos = $that->Faturamentos->find()
            ->contain([
                'TiposFaturamentos',
                'TipoServicoBancarios'
            ])
            ->where([
                'liberacao_documental_id' => $iLiberacaoDocumentalID
            ])
            ->toArray();

        if (!$oFaturamentos)
            return false;

        $oReturn = array();

        foreach ($oFaturamentos as $key => $oFaturamento) {
            $oReturn[] = (object) $oFaturamento->that;
        }
        
        return $oReturn;
    }

    public static function isBloqueado($sLiberacaoDocumentalIDs, $empresa_id)
    {
        $sLiberacaoDocumentalIDs = str_replace(' ', '', $sLiberacaoDocumentalIDs);

        if (!$sLiberacaoDocumentalIDs)
            return false;

        $sSql = 'SELECT DISTINCT
			SUM(((
			Estoques.qtde_saldo - DocumentosMercadoriasItens.quantidade) - 
				LiberacoesDocumentaisItens.quantidade_liberada)) AS saldo
        FROM liberacoes_documentais AS LiberacoesDocumentais 
        INNER JOIN liberacoes_documentais_itens AS LiberacoesDocumentaisItens ON 
            LiberacoesDocumentaisItens.liberacao_documental_id = LiberacoesDocumentais.id
        INNER JOIN estoques AS Estoques ON 
            Estoques.id = LiberacoesDocumentaisItens.estoque_id
        INNER JOIN etiqueta_produtos AS EtiquetaProdutos ON 
            EtiquetaProdutos.lote_codigo = Estoques.lote_codigo AND
            EtiquetaProdutos.lote_item = Estoques.lote_item AND 
            EtiquetaProdutos.unidade_medida_id = Estoques.unidade_medida_id AND
            EtiquetaProdutos.empresa_id = Estoques.empresa_id
        INNER JOIN documentos_mercadorias_itens AS DocumentosMercadoriasItens ON 
            DocumentosMercadoriasItens.id = EtiquetaProdutos.documento_mercadoria_item_id
        INNER JOIN documentos_mercadorias AS DocumentosMercadorias ON 
            DocumentosMercadorias.id = DocumentosMercadoriasItens.documentos_mercadoria_id
        INNER JOIN apreensoes AS Apreensoes ON 
            Apreensoes.documento_mercadoria_id = DocumentosMercadorias.id	
        WHERE 
            LiberacoesDocumentais.id IN ('.$sLiberacaoDocumentalIDs.') AND
            DocumentosMercadorias.empresa_id = '.$empresa_id.' AND
		    Apreensoes.data_liberacao IS NULL';

        $connection = ConnectionManager::get('default');
        $saida = $connection->execute( $sSql )->fetchAll('assoc');
        return ($saida[0]['saldo'] < 0 );
    }

    public function getNavioAviao(){

       if(isset($this->liberacoes_documentais_itens->lote_codigo)){
           
            $oDocumento = LgDbUtil::getFind('DocumentosMercadorias')
                ->contain(['DocumentosTransportes'])
                ->where([
                    'lote_codigo' => $this->liberacoes_documentais_itens->lote_codigo
                ])->first();

           return @$oDocumento->documentos_transporte->navio_aeronave?: '';
       }
    }

    public static function generateLiberacaoByDocEntrada($iDocTranspId, $iContainerID = null, $byEtiqueta = null)
    {
        $oDocTransporte = LgDbUtil::getFind('DocumentosTransportes')
            ->contain(['DocumentosMercadoriasMany' => ['DocumentosMercadoriasItens']])
            ->where(['DocumentosTransportes.id' => $iDocTranspId])
            ->first();

        if (!$oDocTransporte)
            return (new ResponseUtil())
                ->setMessage('Documento de transporte não encontrado.');

        $iHasLibDocumentalWithNumber = LgDbUtil::getFind('LiberacoesDocumentais')
            ->where([
                'numero' => $oDocTransporte->numero,
                'cliente_id' => $oDocTransporte->documentos_mercadorias[1]->cliente_id
            ])
            ->count();

        /*if ($iHasLibDocumentalWithNumber)
            return (new ResponseUtil())
                ->setMessage(__('Já existe liberação documental criada com este número e cliente.'));*/

        $aDataLiberacaoCapa = [
            'numero_documento_liberacao'    => $iContainerID ? $oDocTransporte->numero . $iContainerID : $oDocTransporte->numero,
            'numero'                        => $iContainerID ? $oDocTransporte->numero . $iContainerID : $oDocTransporte->numero,
            'quantidade_adicoes'            => 1,
            'cliente_id'                    => $oDocTransporte->documentos_mercadorias[1]->cliente_id,
            'tipo_documento_id'             => $oDocTransporte->tipo_documento_id,
            'tipo_documento_liberacao_id'   => $oDocTransporte->tipo_documento_id,
            'valor_fob_moeda'               => 0,
            'valor_frete_moeda'             => 0,
            'valor_seguro_moeda'            => 0,
            'valor_cif_moeda'               => 0,
            'empresa_id'                    => $oDocTransporte->empresa_id,
            'moeda_fob_id'                  => 1,
            'moeda_frete_id'                => 1,
            'moeda_seguro_id'               => 1,
            'moeda_cif_id'                  => 1,
            'canal_id'                      => 1,
            'regime_aduaneiro_id'           => 1,
            'data_registro'                 => DateUtil::dateTimeToDB(date("Y-m-d H:i")),
            'data_desembaraco'              => DateUtil::dateTimeToDB(date("Y-m-d H:i")),
            'peso_bruto'                    => 0,
            'peso_liquido'                  => 0,
            'aftn_id'                       => 1,
        ];

        if (!$iHasLibDocumentalWithNumber)
            $oLiberacaoDocumental = LgDbUtil::get('LiberacoesDocumentais')->newEntity($aDataLiberacaoCapa);
        else 
            $oLiberacaoDocumental = LgDbUtil::getLast('LiberacoesDocumentais', [
                'numero' => $oDocTransporte->numero,
                'cliente_id' => $oDocTransporte->documentos_mercadorias[1]->cliente_id
            ]);
        
        $aLoteCodigos = [];

        foreach ($oDocTransporte->documentos_mercadorias as $oDocumentoMercadoria) {
            $aLoteCodigos[] = $oDocumentoMercadoria->lote_codigo;
        }

        $aExtraWhere = [];

        if ($iContainerID)
            $aExtraWhere['container_id'] = $iContainerID;

        $iHasLibItensWithLoteCodigos = LgDbUtil::getFind('LiberacoesDocumentaisItens')
            ->where([
                'lote_codigo IN' => $aLoteCodigos
            ] + $aExtraWhere)
            ->count();

        if ($iHasLibItensWithLoteCodigos) {

            $oLiberacaoDocumentalItem = LgDbUtil::getFind('LiberacoesDocumentaisItens')
                ->where(['lote_codigo IN' => $aLoteCodigos])
                ->first();

            $oLiberacaoDocumental = LgDbUtil::getByID('LiberacoesDocumentais', $oLiberacaoDocumentalItem->liberacao_documental_id);
            $oLiberacaoDocumental = LgDbUtil::get('LiberacoesDocumentais')->patchEntity($oLiberacaoDocumental, $aDataLiberacaoCapa);
            LgDbUtil::save('LiberacoesDocumentais', $oLiberacaoDocumental);

            return (new ResponseUtil())
                ->setMessage(__('Já existe liberação documental criada para estes itens. (Dados da Capa atualizados!)'));
        }
        
        if (!LgDbUtil::get('LiberacoesDocumentais')->save($oLiberacaoDocumental))
            return (new ResponseUtil())
                ->setMessage(__('Houve algum erro ao criar a capa de liberação: ') . EntityUtil::dumpErrors($oLiberacaoDocumental));

        $aEstoqueEnderecos = LgDbUtil::getFind('EstoqueEnderecos')
            ->where([
                'lote_codigo IN' => $aLoteCodigos
            ] + $aExtraWhere)
            ->toArray();

        $aLiberacaoDocumentalItensEntities = [];

        foreach ($aEstoqueEnderecos as $key => $oEstoqueEndereco) {
            $aData = json_decode(json_encode($oEstoqueEndereco), true);
            unset($aData['id']);
            unset($aData['created_at']);
            $aData['adicao_numero'] = $key + 1;
            $aData['quantidade_liberada'] = $aData['qtde_saldo'];
            $aData['liberacao_por_produto'] = @$aData['container_id'] ? 2 : 1;
            $aData['liberacao_por_produto'] = !$byEtiqueta ? $aData['liberacao_por_produto'] : 0; 
            $aData['liberacao_documental_id'] = $oLiberacaoDocumental->id;
            $aData['m2_saldo'] = 0;
            $aLiberacaoDocumentalItensEntities[] = LgDbUtil::get('LiberacoesDocumentaisItens')->newEntity($aData);
        }

        LgDbUtil::get('LiberacoesDocumentaisItens')->saveMany($aLiberacaoDocumentalItensEntities);

        return (new ResponseUtil())
            ->setStatus(200)
            ->setDataExtra(['aLiberacaoDocumentalItensEntities' => $aLiberacaoDocumentalItensEntities])
            ->setMessage('Liberação documental criada com sucesso.');
    }

    public static function consisteTributos($iDocId, $aPostData){
        if(empty($aPostData['tributos'])) return false;
        
        $oTable = LgDbUtil::get('LiberacaoDocumentalTributos');
        $aNewTributos = $aPostData['tributos'];
        $aOldTributos = LgDbUtil::getAll('LiberacaoDocumentalTributos', [
            'liberacao_documental_id' => $iDocId
        ]);
        
        $aTributos = [];
        foreach ($aNewTributos as $value) {
            $aTributos[] = (function($value, $aOldTributos) use($oTable, $iDocId){

                if(empty($aOldTributos)){
                    $oEntity = $oTable->newEntity([
                        'tributo_id' => $value['id'],
                        'liberacao_documental_id' => $iDocId,
                        'suspenso' => DoubleUtil::toDBUnformat($value['suspenso']),
                        'recolhido' => DoubleUtil::toDBUnformat($value['recolhido']),
                    ]);
                    return $oEntity;
                }

                $result = array_search($value['id'], array_column($aOldTributos, 'tributo_id'));

                if(empty($aOldTributos[$result])){

                    $oEntity = $oTable->newEntity([
                        'tributo_id' => $value['id'],
                        'liberacao_documental_id' => $iDocId,
                        'suspenso' => DoubleUtil::toDBUnformat($value['suspenso']),
                        'recolhido' => DoubleUtil::toDBUnformat($value['recolhido']),
                    ]);
                    return $oEntity;
                }

                $oEntity = $aOldTributos[$result];
                $oEntity->suspenso = DoubleUtil::toDBUnformat($value['suspenso']);
                $oEntity->recolhido = DoubleUtil::toDBUnformat($value['recolhido']);
                return $oEntity;
                
            })($value, $aOldTributos);
        }

        return LgDbUtil::get('LiberacaoDocumentalTributos')->saveMany($aTributos);
    }
}
