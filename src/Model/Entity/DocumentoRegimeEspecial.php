<?php
namespace App\Model\Entity;

use App\RegraNegocio\GerenciamentoEstoque\DecrementoEstoqueProdutos;
use App\RegraNegocio\GerenciamentoEstoque\IncrementoEstoqueProdutos;
use App\Util\DateUtil;
use App\Util\DoubleUtil;
use App\Util\EntityUtil;
use App\Util\LgDbUtil;
use App\Util\ResponseUtil;
use Cake\ORM\Entity;

/**
 * DocumentoRegimeEspecial Entity
 *
 * @property int $id
 * @property string|null $numero_documento_especial
 * @property string $numero
 * @property \Cake\I18n\Time $data_registro
 * @property \Cake\I18n\Time|null $data_desembaraco
 * @property int|null $quantidade_adicoes
 * @property float $valor_fob_moeda
 * @property float $valor_frete_moeda
 * @property float $valor_seguro_moeda
 * @property float $valor_cif_moeda
 * @property float|null $quantidade_total
 * @property float|null $peso_bruto
 * @property float|null $peso_liquido
 * @property string|null $observacao
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
 * @property int|null $tipo_documento_especial_id
 * @property int|null $pessoa_id
 * @property \Cake\I18n\Time $created_at
 * @property \Cake\I18n\Time|null $updated_at
 * @property int $libera_por_transportadora
 *
 * @property \App\Model\Entity\Empresa $empresa
 * @property \App\Model\Entity\TipoDocumento $tipo_documento
 * @property \App\Model\Entity\Moeda $moeda
 * @property \App\Model\Entity\Canal $canal
 * @property \App\Model\Entity\RegimesAduaneiro $regimes_aduaneiro
 * @property \App\Model\Entity\Aftm $aftm
 * @property \App\Model\Entity\Pessoa $pessoa
 */
class DocumentoRegimeEspecial extends Entity
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
        
        'numero_documento_especial' => true,
        'numero' => true,
        'data_registro' => true,
        'data_desembaraco' => true,
        'quantidade_adicoes' => true,
        'valor_fob_moeda' => true,
        'valor_frete_moeda' => true,
        'valor_seguro_moeda' => true,
        'valor_cif_moeda' => true,
        'quantidade_total' => true,
        'peso_bruto' => true,
        'peso_liquido' => true,
        'observacao' => true,
        'empresa_id' => true,
        'cliente_id' => true,
        'tipo_documento_id' => true,
        'moeda_fob_id' => true,
        'moeda_frete_id' => true,
        'moeda_seguro_id' => true,
        'moeda_cif_id' => true,
        'canal_id' => true,
        'regime_aduaneiro_id' => true,
        'aftn_id' => true,
        'tipo_documento_especial_id' => true,
        'pessoa_id' => true,
        'created_at' => true,
        'updated_at' => true,
        'libera_por_transportadora' => true,
        'empresa' => true,
        'tipo_documento' => true,
        'moeda' => true,
        'canal' => true,
        'regimes_aduaneiro' => true,
        'aftm' => true,
        'pessoa' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];


    public static function doData($dataPost){
        $dataPost['empresa_id']         = Empresa::getEmpresaPadrao();
        $dataPost['data_registro']      = @DateUtil::dateTimeToDB(@$dataPost['data_registro']);
        $dataPost['data_desembaraco']   = @DateUtil::dateTimeToDB(@$dataPost['data_desembaraco']);
        $dataPost['valor_fob_moeda']    = @DoubleUtil::toDBUnformat(@$dataPost['valor_fob_moeda']);
        $dataPost['valor_frete_moeda']  = @DoubleUtil::toDBUnformat(@$dataPost['valor_frete_moeda']);
        $dataPost['valor_seguro_moeda'] = @DoubleUtil::toDBUnformat(@$dataPost['valor_seguro_moeda']);
        $dataPost['valor_cif_moeda']    = @DoubleUtil::toDBUnformat(@$dataPost['valor_cif_moeda']);
        $dataPost['quantidade_total']   = isset($dataPost['quantidade_total']) ? 
            DoubleUtil::toDBUnformat($dataPost['quantidade_total']) : null;
        $dataPost['peso_bruto']         = @DoubleUtil::toDBUnformat(@$dataPost['peso_bruto']);
        $dataPost['peso_liquido']       = @DoubleUtil::toDBUnformat(@$dataPost['peso_liquido']);
        return $dataPost;
    }

    public static function setData($oDocumento){

        $sDataHoje = $oDocumento->data_registro;

        $cotacao_fob = LgDbUtil::get('MoedasCotacoes')
            ->find()
            ->where([
                'moeda_id' => $oDocumento->moeda_fob_id, 
                'data_cotacao' => $sDataHoje
            ])
            ->order('data_cotacao', 'DESC')
            ->first();

        $cotacao_frete = LgDbUtil::get('MoedasCotacoes')
            ->find()
            ->where([
                'moeda_id' => $oDocumento->moeda_frete_id, 
                'data_cotacao' => $sDataHoje
            ])
            ->order('data_cotacao', 'DESC')
            ->first();

        $cotacao_seguro = LgDbUtil::get('MoedasCotacoes')
            ->find()
            ->where([
                'moeda_id' => $oDocumento->moeda_seguro_id, 
                'data_cotacao' => $sDataHoje
            ])
            ->order('data_cotacao', 'DESC')
            ->first();

        $cotacao_cif = LgDbUtil::get('MoedasCotacoes')
            ->find()
            ->where([
                'moeda_id' => $oDocumento->moeda_cif_id, 
                'data_cotacao' => $sDataHoje
            ])
            ->order('data_cotacao', 'DESC')
            ->first();

        $cotacao_fob    = $cotacao_fob    ? $cotacao_fob->valor_cotacao    : 0;
        $cotacao_frete  = $cotacao_frete  ? $cotacao_frete->valor_cotacao  : 0;
        $cotacao_seguro = $cotacao_seguro ? $cotacao_seguro->valor_cotacao : 0;
        $cotacao_cif    = $cotacao_cif    ? $cotacao_cif->valor_cotacao    : 0;

        $oDocumento->resultado_moeda_fob    = DoubleUtil::fromDBUnformat(
            $cotacao_fob * $oDocumento->valor_fob_moeda
        );
        $oDocumento->resultado_moeda_frete  = DoubleUtil::fromDBUnformat(
            $cotacao_frete * $oDocumento->valor_frete_moeda
        );
        $oDocumento->resultado_moeda_seguro = DoubleUtil::fromDBUnformat(
            $cotacao_seguro * $oDocumento->valor_seguro_moeda
        );
        $oDocumento->resultado_moeda_cif    = DoubleUtil::fromDBUnformat(
            $cotacao_cif * $oDocumento->valor_cif_moeda
        );
        
        $oDocumento->cotacao_moeda_fob    = DoubleUtil::fromDBUnformat($cotacao_fob);
        $oDocumento->cotacao_moeda_frete  = DoubleUtil::fromDBUnformat($cotacao_frete);
        $oDocumento->cotacao_moeda_seguro = DoubleUtil::fromDBUnformat($cotacao_seguro);
        $oDocumento->cotacao_moeda_cif    = DoubleUtil::fromDBUnformat($cotacao_cif);
    }

    public static function consisteTributos($iDocId, $aPostData){
        $oTable = LgDbUtil::get('DocumentoRegimeEspecialTributos');
        $aNewTributos = $aPostData['tributos'];
        $aOldTributos = LgDbUtil::getAll('DocumentoRegimeEspecialTributos', [
            'documento_regime_especial_id' => $iDocId
        ]);
        
        $aTributos = [];
        foreach ($aNewTributos as $value) {
            $aTributos[] = (function($value, $aOldTributos) use($oTable, $iDocId){

                if(empty($aOldTributos)){
                    $oEntity = $oTable->newEntity([
                        'tributo_id' => $value['id'],
                        'documento_regime_especial_id' => $iDocId,
                        'suspenso' => DoubleUtil::toDBUnformat($value['suspenso']),
                        'recolhido' => DoubleUtil::toDBUnformat($value['recolhido']),
                    ]);
                    return $oEntity;
                }

                $result = array_search($value['id'], array_column($aOldTributos, 'tributo_id'));

                if(empty($aOldTributos[$result])){

                    $oEntity = $oTable->newEntity([
                        'tributo_id' => $value['id'],
                        'documento_regime_especial_id' => $iDocId,
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

        LgDbUtil::get('DocumentoRegimeEspecialTributos')->saveMany($aTributos);
    }

    public static function consisteEntreposto($iDocRegimeEspecial)
    {
        $oDocRegimeEspecial = LgDbUtil::getFind('DocumentoRegimeEspeciais')
            ->contain(['DocumentoRegimeEspecialAdicoes' => 'DocumentoRegimeEspecialAdicaoItens'])
            ->where(['DocumentoRegimeEspeciais.id' => $iDocRegimeEspecial])
            ->first();

        if (!$oDocRegimeEspecial)
            return (new ResponseUtil())
                ->setMessage('Não foi encontrado documentação.');

        $empresa_id = Empresa::getEmpresaPadrao();

        foreach ($oDocRegimeEspecial->documento_regime_especial_adicoes as $oDocumentoRegimeEspecialAdicao) {

            $oEstoqueEndereco = LgDbUtil::getFind('EstoqueEnderecos')
                ->where([
                    'lote_codigo' => $oDocumentoRegimeEspecialAdicao->lote_codigo,
                    'lote_item' => $oDocumentoRegimeEspecialAdicao->lote_item,
                    'produto_id IS' => $oDocumentoRegimeEspecialAdicao->produto_id,
                    'unidade_medida_id' => $oDocumentoRegimeEspecialAdicao->unidade_medida_id
                ])
                ->first();

            $aEstoqueEnderecos = LgDbUtil::getFind('EstoqueEnderecos')
                ->where([
                    'lote_codigo' => $oDocumentoRegimeEspecialAdicao->lote_codigo,
                    'produto_id IS' => $oDocumentoRegimeEspecialAdicao->produto_id,
                    'lote IS'       => $oDocumentoRegimeEspecialAdicao->lote,
                    'serie IS'      => $oDocumentoRegimeEspecialAdicao->serie,
                    'validade IS'   => $oDocumentoRegimeEspecialAdicao->validade,
                    'unidade_medida_id' => $oDocumentoRegimeEspecialAdicao->unidade_medida_id,
                    'container_id IS' => $oDocumentoRegimeEspecialAdicao->container_id
                ])->toArray();

            foreach ($aEstoqueEnderecos as $oEstoqueEndereco) {
                $ProdutoDecremento = [
                    'conditions' => [
                        'lote_codigo' => $oEstoqueEndereco->lote_codigo,
                        'lote_item' => $oEstoqueEndereco->lote_item,
                        'produto_id' => $oEstoqueEndereco->produto_id,
                        'lote IS'       => $oEstoqueEndereco->lote,
                        'serie IS'      => $oEstoqueEndereco->serie,
                        'validade IS'   => $oEstoqueEndereco->validade,
                        'unidade_medida_id' => $oEstoqueEndereco->unidade_medida_id,
                        'endereco_id'       => $oEstoqueEndereco->endereco_id,
                        'container_id IS' => $oEstoqueEndereco->container_id
                    ],
                    'order' => [ 'qtde' => 'ASC'],
                    'dataExtra' => [
                        'qtde' => $oEstoqueEndereco->qtde_saldo,
                        'peso' => $oEstoqueEndereco->peso_saldo,
                        'lote_codigo' => $oEstoqueEndereco->lote_codigo,
                        'lote_item' => $oEstoqueEndereco->lote_item,
                    ],
                ];

                $id = EntityUtil::getIdByParams(
                    'TipoMovimentacoes', 'descricao', 'DECREMENTO MANUAL');
        
                $oResponseDecremento = DecrementoEstoqueProdutos::manageRetiradaEstoque(
                    [$ProdutoDecremento],
                    false,
                    [
                        'movimentacao_tipo_id' => $id,
                        'ignora_lote_documental' => false
                    ]
                );
    
                if ($oResponseDecremento->getStatus() != 200)
                    return $oResponseDecremento;
            }

            foreach ($oDocumentoRegimeEspecialAdicao->documento_regime_especial_adicao_itens as $oDocumentoRegimeEspecialAdicaoItem) {
                $aIncrementoEstoque = [
                    'conditions' => [
                        'produto_id' => $oDocumentoRegimeEspecialAdicaoItem->produto_id,
                        'lote'       => @$oDocumentoRegimeEspecialAdicaoItem->lote,
                        'serie'      => @$oDocumentoRegimeEspecialAdicaoItem->serie,
                        'validade'   => @$oDocumentoRegimeEspecialAdicaoItem->validade ? DateUtil::dateTimeToDB($oDocumentoRegimeEspecialAdicaoItem->validade) : null,
                        'unidade_medida_id' => $oDocumentoRegimeEspecialAdicaoItem->unidade_medida_id,
                        'empresa_id'  => $empresa_id,
                        'endereco_id' => $oDocRegimeEspecial->endereco_id
                    ],
                    'order' => [
                        'qtde' => 'ASC'
                    ],
                    'dataExtra' => [
                        'status_estoque_id' => @$oEstoqueEndereco->status_estoque_id ?: null,
                        'qtde' => $oDocumentoRegimeEspecialAdicaoItem->qtde_saldo,
                        'peso' => $oDocumentoRegimeEspecialAdicaoItem->peso_saldo,
                        'm2' => 0,
                        'm3' => 0,
                        'lote_codigo' => $oDocumentoRegimeEspecialAdicaoItem->lote_codigo,
                        'lote_item'   => $oDocumentoRegimeEspecialAdicaoItem->lote_item
                    ]
                ];
    
                $id = EntityUtil::getIdByParams(
                    'TipoMovimentacoes', 'descricao', 'INCREMENTO MANUAL');
                
                $oResponse = IncrementoEstoqueProdutos::manageIncrementoEstoque(
                    [$aIncrementoEstoque], 
                    false, 
                    [
                        'movimentacao_tipo_id'  => $id,
                        'ignora_lote_documental' => false
                    ]
                );

                if ($oResponse->getStatus() != 200)
                    return $oResponse;
            }
        }

        return (new ResponseUtil())
            ->setStatus(200)
            ->setMessage('Liberação de entreposto realizada com sucesso.');
    }
}
