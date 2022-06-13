<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use App\Util\DoubleUtil;
use App\Util\EntityUtil;
use Cake\I18n\Number;
use App\Model\Entity\MovimentacoesEstoque;
use App\RegraNegocio\GerenciamentoEstoque\ProdutosControlados;
use App\RegraNegocio\OperacaoSeparacao\SearchBestEnderecoPicking;
use App\Util\ObjectUtil;
use Cake\ORM\TableRegistry;

/**
 * EstoqueEndereco Entity
 *
 * @property int $id
 * @property string|null $produto_codigo
 * @property string|null $lote_codigo
 * @property int|null $lote_item
 * @property float $qtde_saldo
 * @property float $peso_saldo
 * @property float $m2_saldo
 * @property float $m3_saldo
 * @property int $unidade_medida_id
 * @property int $endereco_id
 * @property int $estoque_id
 * @property int $empresa_id
 *
 * @property \App\Model\Entity\UnidadeMedida $unidade_medida
 * @property \App\Model\Entity\Endereco $endereco
 * @property \App\Model\Entity\Estoque $estoque
 * @property \App\Model\Entity\Empresa $empresa
 */
class EstoqueEndereco extends Entity
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
     * Default fields:
     *  
     * 'produto_id' => true,
     *  'lote_codigo' => true,
     *  'lote_item' => true,
     *  'qtde_saldo' => true,
     *  'peso_saldo' => true,
     *  'm2_saldo' => true,
     *  'm3_saldo' => true,
     *  'unidade_medida_id' => true,
     *  'estoque_id' => true,
     *  'empresa_id' => true,
     *  'lote' => true,
     *  'serie' => true,
     *  'validade' => true,
     *  'unidade_medida' => true,
     *  'produto' => true,
     *  'endereco_id' => true,
     *  'endereco' => true,
     *  'estoque' => true,
     *  'empresa' => true
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public function saveEstoqueEndereco( $that, $aData, $iEstoqueID ) 
    {           
        $bExibeCampoProduto = ($x = ParametroGeral::getParametro($that, 'DESCARGA_EXIBE_CAMPO_PRODUTO')) ? (int) $x->valor : 0;
        $bIncrementaDocMercItem = ($x = ParametroGeral::getParametro($that, 'DESCARGA_INCREMENTA_DOC_MERC_ITEM')) ? (int) $x->valor : 0;
             
        $aData['estoque_id'] = $iEstoqueID;
        $aData['qtde_saldo'] = DoubleUtil::toDBUnformat($aData['quantidade']);
        $aData['peso_saldo'] = DoubleUtil::toDBUnformat($aData['peso_bruto']);
        $aData['m2_saldo']   = isset($aData['m2']) ? DoubleUtil::toDBUnformat($aData['m2']) : 0;
        $aData['m3_saldo']   = isset($aData['m3']) ? DoubleUtil::toDBUnformat($aData['m3']) : 0;
        $aData['empresa_id'] = $that->getEmpresaAtual();

        $aConditions = [
            'estoque_id'        => $iEstoqueID,
            'lote_codigo'       => $aData['lote_codigo'],
            'lote_item'         => $aData['lote_item'],
            'unidade_medida_id' => $aData['unidade_medida_id'],
            'endereco_id'       => $aData['endereco_id']
        ];

        if ($bExibeCampoProduto){
            //$bAgrupaComLoteDocumental = ($x = ParametroGeral::getParametro($that, 'OPERACAO_DESCARGA_AGRUPA_SEM_LOTE_DOCUMENTAL')) ? (int) $x->valor : 0;
            $aConditions = ProdutosControlados::getProdutoControlesValuesToQuery($aData, false, false) + [
                'estoque_id'  => $iEstoqueID,
                'endereco_id' => $aData['endereco_id']
            ];
        }

        $oEstoqueEndereco = $that->EstoqueEnderecos->find()
            ->where($aConditions)
            ->first();

        if (!$oEstoqueEndereco || (isset($aData['_id_entrada_not_incremented_']) && !$oEstoqueEndereco && $bIncrementaDocMercItem) ) {
            return $this->saveNewEstoqueEndereco($that, $aData);
        }
        
        return $this->updateEstoqueEndereco($that, $aData, $oEstoqueEndereco);
    }

    public function updateEstoqueEndereco( $that, $aData, $oEstoqueEndereco )
    {
        $bIncrementaDocMercItem = ($x = ParametroGeral::getParametro($that, 'DESCARGA_INCREMENTA_DOC_MERC_ITEM')) ? (int) $x->valor : 0;
        $oEstoqueEnderecoOld = ObjectUtil::getAsObject($oEstoqueEndereco);

        if ($bIncrementaDocMercItem || @$aData['ordem_servico_item_old']->id) {
            $oEstoqueEndereco = $that->EstoqueEnderecos->patchEntity($oEstoqueEndereco, $aData);
        }else {
            $oEstoqueEndereco->qtde_saldo += $aData['qtde_saldo'];
            $oEstoqueEndereco->peso_saldo += $aData['peso_saldo'];
            $oEstoqueEndereco->m2_saldo   += $aData['m2_saldo'];
            $oEstoqueEndereco->m3_saldo   += $aData['m3_saldo'];
        }

        MovimentacoesEstoque::saveMovimentacao($that, [
            'quantidade_movimentada' => $oEstoqueEndereco->qtde_saldo,
            'estoque_id'             => $oEstoqueEndereco->estoque_id,
            'endereco_origem_id'     => $oEstoqueEnderecoOld->endereco_id,
            'endereco_destino_id'    => $oEstoqueEndereco->endereco_id,
            'status_estoque_id'      => $oEstoqueEndereco->status_estoque_id,
            'tipo_movimentacao_id'   => 2
        ]);

        if ($result = $that->EstoqueEnderecos->save($oEstoqueEndereco))
            return [
                'message'   => 'OK',
                'status'    => 200,
                'dataExtra' => ['id' => $result->id]
            ];

        return [
            'message' => 'Houve algum problema ao atualizar o estoque! ' . EntityUtil::dumpErrors($oEstoqueEndereco),
            'status' => 406
        ];
    }

    public function saveNewEstoqueEndereco( $that, $aData )
    {        
        $oEstoqueEndereco = $that->EstoqueEnderecos->newEntity();
        $oEstoqueEndereco = $that->EstoqueEnderecos->patchEntity( $oEstoqueEndereco, $aData);
        
        MovimentacoesEstoque::saveMovimentacao($that, [
            'quantidade_movimentada' => $oEstoqueEndereco->qtde_saldo,
            'estoque_id'             => $oEstoqueEndereco->estoque_id,
            'endereco_destino_id'    => $oEstoqueEndereco->endereco_id,
            'status_estoque_id'      => $oEstoqueEndereco->status_estoque_id,
            'tipo_movimentacao_id'   => 2
        ]);

        if ($result = $that->EstoqueEnderecos->save($oEstoqueEndereco))
            return [
                'message'   => 'OK',
                'status'    => 200,
                'dataExtra' => [ 'id' => $result->id ]
            ];
            
        return [
            'message' => 'Houve algum problema ao salvar estoque! ' . EntityUtil::dumpErrors($oEstoqueEndereco),
            'status' => 406
        ];
    }

    public function removeByEtiquetaEstoque( $that, $oEtiquetaProduto )
    {
        $oEstoqueEndereco = $that->EstoqueEnderecos->find()
            ->where(
                [
                    'EstoqueEnderecos.lote_codigo'       => $oEtiquetaProduto->lote_codigo,
                    'EstoqueEnderecos.lote_item'         => $oEtiquetaProduto->lote_item,
                    'EstoqueEnderecos.qtde_saldo >='     => $oEtiquetaProduto->qtde,
                    'EstoqueEnderecos.unidade_medida_id' => $oEtiquetaProduto->unidade_medida_id,
                    'EstoqueEnderecos.endereco_id'       => $oEtiquetaProduto->endereco_id,
                    'EstoqueEnderecos.empresa_id'        => $oEtiquetaProduto->empresa_id
                ]
            )
            ->order(['EstoqueEnderecos.qtde_saldo'])
            ->first();

        if($oEstoqueEndereco){

            $fTotalQtde = $oEstoqueEndereco->qtde_saldo - $oEtiquetaProduto->qtde;
            $fTotalPeso = $oEstoqueEndereco->peso_saldo - $oEtiquetaProduto->peso;

            if($fTotalQtde <= 0 ) {
                $that->EstoqueEnderecos->delete($oEstoqueEndereco);
            }else{
                $oEstoqueEndereco->qtde_saldo = $fTotalQtde;
                $oEstoqueEndereco->peso_saldo = $fTotalPeso;
                $that->EstoqueEnderecos->save($oEstoqueEndereco);
            }

            MovimentacoesEstoque::saveMovimentacao($that, [
                'quantidade_movimentada' => $fTotalQtde,
                'estoque_id'             => $oEstoqueEndereco->estoque_id,
                'endereco_origem_id'     => $oEstoqueEndereco->endereco_id,
                'tipo_movimentacao_id'   => 1
            ]);
        }

        return true;
    }

    public function insertByEtiquetaEstoque( $that, $oEtiquetaProduto, $iEstoqueID )
    {
        $aData = [
            'produto_id'        => $oEtiquetaProduto->produto_id,
            'lote_codigo'       => $oEtiquetaProduto->lote_codigo,
            'lote_item'         => $oEtiquetaProduto->lote_item,
            'qtde_saldo'        => $oEtiquetaProduto->qtde,
            'peso_saldo'        => $oEtiquetaProduto->peso,
            'm2_saldo'          => $oEtiquetaProduto->m2,
            'm3_saldo'          => $oEtiquetaProduto->m3,
            'unidade_medida_id' => $oEtiquetaProduto->unidade_medida_id,
            'estoque_id'        => $iEstoqueID,
            'endereco_id'       => $oEtiquetaProduto->endereco_id,
            'empresa_id'        => $oEtiquetaProduto->empresa_id
        ];

        $oEstoqueEndereco = $that->EstoqueEnderecos->newEntity();
        $oEstoqueEndereco = $that->EstoqueEnderecos->patchEntity($oEstoqueEndereco, $aData);

        MovimentacoesEstoque::saveMovimentacao($that, [
            'quantidade_movimentada' => $oEstoqueEndereco->qtde_saldo,
            'estoque_id'             => $oEstoqueEndereco->estoque_id,
            'endereco_destino_id'    => $oEstoqueEndereco->endereco_id,
            'tipo_movimentacao_id'   => 9
        ]);

        if (!$result = $that->EstoqueEnderecos->save($oEstoqueEndereco)) 
            return [
                'message' => __('Não foi possível criar o vínculo de Estoque/Endereço dessa Etiqueta!') . EntityUtil::dumpErrors($oEstoqueEndereco),
                'status'  => 406
            ];

        return [
            'message' => __('OK'),
            'status'  => 200
        ];
    }

    public static function getBestEnderecos($aSeparacaoCargas, $iOSID = null)
    {
        $aDadosOperacao = SearchBestEnderecoPicking::search($aSeparacaoCargas, $iOSID);

        return $aDadosOperacao;
    }

    /**
     * Buscará e retornará uma ou mais ($bFirst = true trará somente o primeiro lugar que ele encontrar) 
     * localizacoes de um produto conforme seus controles.
     */
    public static function getLocalizacaoProdutos($aDataUniqueProduct, $bFirst = true, $aConditions = [], $aOrders = [], $aContains = [], $bConsideraLoteDocumental = true)
    {
        if ($aDataUniqueProduct){
            $aNotEmpty = Produto::getControlesNotEmpty($aDataUniqueProduct['controles_produto']);
            $aControleConditions = ProdutosControlados::getProdutoControlesValuesToQuery(@$aDataUniqueProduct['localizacao'], false, false, true);

            $sLoteCodigo = @$aDataUniqueProduct['localizacao']['lote_codigo'];
            $sLoteCodigo = $sLoteCodigo ? $sLoteCodigo : null;
            $sLoteItem   = @$aDataUniqueProduct['localizacao']['lote_item'];
            $sLoteItem   = $sLoteItem ? $sLoteItem : null;
            
            $aConditions += [
                'produto_id'        => $aDataUniqueProduct['produto_id'],
                'endereco_id'       => $aDataUniqueProduct['endereco_id'],
                'unidade_medida_id' => $aDataUniqueProduct['unidade_medida_id'],
                'lote_codigo IS'    => $sLoteCodigo,
                'lote_item IS'      => $sLoteItem,
                'qtde_saldo >= ' . $aDataUniqueProduct['qtde'],
            ] + $aNotEmpty + $aControleConditions;
        }

        if (!$bConsideraLoteDocumental) {
            unset($aConditions['lote_codigo IS']);
            unset($aConditions['lote_item IS']);
        }

        $oEstoqueEndereco = TableRegistry::getTableLocator()->get('EstoqueEnderecos')->find()
            ->contain($aContains)
            ->where($aConditions)
            ->order($aOrders);
            
        // dd('SQL: ', $oEstoqueEndereco->sql(), $aConditions, $oEstoqueEndereco->first());

        if ($bFirst)
            return $oEstoqueEndereco->first();

        return $oEstoqueEndereco->toArray();
    }



    /**
     * Get o estoque sem reserva
    */

    public function fGetEstoqueSemReserva(){
        
        if(empty($this->estoque_endereco_reservas)){
            return $this->qtde_saldo;
        }

        $reserva = array_reduce($this->estoque_endereco_reservas, function(){
            return @$this->estoque_endereco_reservas->qtde_saldo;
        }, 0);
        
        $fQuantidade = $this->qtde_saldo - $reserva;

        if($fQuantidade < 0){
            return 0;
        }

        return $fQuantidade;
    }
    
}