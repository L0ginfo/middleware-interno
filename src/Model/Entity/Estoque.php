<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use App\Util\DoubleUtil;
use App\Util\EntityUtil;
use App\Model\Entity\EstoqueEndereco;
use App\RegraNegocio\GerenciamentoEstoque\ProdutosControlados;
use App\Util\LgDbUtil;
use Cake\ORM\TableRegistry;

/**
 * Estoque Entity
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
 * @property int $empresa_id
 *
 * @property \App\Model\Entity\UnidadeMedida $unidade_medida
 * @property \App\Model\Entity\Empresa $empresa
 * @property \App\Model\Entity\EstoqueEndereco[] $estoque_enderecos
 */
class Estoque extends Entity
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
        'produto_id' => true,
        'lote_codigo' => true,
        'lote_item' => true,
        'qtde_saldo' => true,
        'peso_saldo' => true,
        'm2_saldo' => true,
        'm3_saldo' => true,
        'unidade_medida_id' => true,
        'empresa_id' => true,
        'lote' => true,
        'serie' => true,
        'validade' => true,
        'produto' => true,
        'unidade_medida' => true,
        'empresa' => true,
        'estoque_enderecos' => true
    ];

    public function saveEstoque( $that, $aData )
    {
        $bExibeCampoProduto = ($x = ParametroGeral::getParametro($that, 'DESCARGA_EXIBE_CAMPO_PRODUTO')) ? (int) $x->valor : 0;
        $aConditions = [
            'lote_codigo'       => $aData['lote_codigo'],
            'lote_item'         => $aData['lote_item'],
            'unidade_medida_id' => $aData['unidade_medida_id'],
        ];

        if ($bExibeCampoProduto){
            //$bAgrupaComLoteDocumental = ($x = ParametroGeral::getParametro($that, 'OPERACAO_DESCARGA_AGRUPA_SEM_LOTE_DOCUMENTAL')) ? (int) $x->valor : 0;
            $aConditions = ProdutosControlados::getProdutoControlesValuesToQuery($aData, false, false);
        }

        $oEstoque = $that->Estoques->find()
            ->where($aConditions)
            ->first();

        $aData['qtde_saldo']  = DoubleUtil::toDBUnformat($aData['quantidade']);
        $aData['peso_saldo']  = DoubleUtil::toDBUnformat($aData['peso_bruto']);
        $aData['m2_saldo']    = isset($aData['m2']) ? DoubleUtil::toDBUnformat($aData['m2']) : 0;
        $aData['m3_saldo']    = isset($aData['m3']) ? DoubleUtil::toDBUnformat($aData['m3']) : 0;
        $aData['empresa_id']  = $that->getEmpresaAtual();

        if (!$oEstoque) {
            return $this->saveNewEstoque($that, $aData);
        }

        return $this->updateEstoque($that, $aData, $oEstoque);
    }

    /**
     * Atualiza no estoque, Incrementando ou Decrementando o peso_bruto, quantidade
     */
    private function updateEstoque($that, $aData, $oEstoque)
    {

        if ($aData['ordem_servico_item_id_frontend']) {
            $oOrdemServicoItem = $aData['ordem_servico_item_old'];

            //valida se adicionou ou removeu quantidade, se sim, debita ou incrementa
            if ($oOrdemServicoItem->quantidade > $aData['qtde_saldo'])
                $oEstoque->qtde_saldo -= $oOrdemServicoItem->quantidade - $aData['qtde_saldo'];
            elseif ($oOrdemServicoItem->quantidade < $aData['qtde_saldo'])
                $oEstoque->qtde_saldo += $aData['qtde_saldo'] - $oOrdemServicoItem->quantidade;
            elseif (!$oEstoque->qtde_saldo)
                $oEstoque->qtde_saldo = $aData['qtde_saldo'];
                
            //valida se adicionou ou removeu peso_bruto, se sim, debita ou incrementa
            if ($oOrdemServicoItem->peso > $aData['peso_saldo'])
                $oEstoque->peso_saldo -= $oOrdemServicoItem->peso - $aData['peso_saldo'];
            elseif ($oOrdemServicoItem->peso < $aData['peso_saldo'])
                $oEstoque->peso_saldo += $aData['peso_saldo'] - $oOrdemServicoItem->peso;
            elseif (!$oEstoque->peso_saldo)
                $oEstoque->peso_saldo = $aData['peso_saldo'];


        }else {
            $oEstoque->qtde_saldo += $aData['qtde_saldo'];
            $oEstoque->peso_saldo += $aData['peso_saldo'];
        }

        //$oEstoque = $that->Estoques->patchEntity($oEstoque, $aData);

        if ($result = $that->Estoques->save($oEstoque))
            return [
                'message'   => 'OK',
                'status'    => 200,
                'dataExtra' => ['id' => $result->id ]
            ];

        return [
            'message' => 'Houve algum problema ao atualizar o estoque! ' . EntityUtil::dumpErrors($oEstoque),
            'status' => 406
        ];
    }

    private function saveNewEstoque( $that, $aData )
    {
        $oEstoque = $that->Estoques->newEntity();
        $oEstoque = $that->Estoques->patchEntity($oEstoque, $aData);

        if ($result = $that->Estoques->save($oEstoque))
            return [
                'message'   => 'OK',
                'status'    => 200,
                'dataExtra' => ['id' => $result->id]
            ];

        return [
            'message' => 'Houve algum problema ao salvar estoque! ' . EntityUtil::dumpErrors($oEstoque),
            'status' => 406
        ];
    }

    public function manageRetiradaEstoqueByEtiqueta( $that, $oEtiquetaProduto )
    {
        $oEstoqueEnderecos = new EstoqueEndereco;
        $oEstoques         = new Estoque;

        $oReturn = $oEstoqueEnderecos->removeByEtiquetaEstoque( $that, $oEtiquetaProduto );

        if (!$oReturn)
            return [
                'message' => __('Não foi possível remover o Estoque do Endereço, favor contatar o administrador do sistema.'),
                'status'  => 406
            ];

        $oReturn = $oEstoques->decrementByEtiqueta( $that, $oEtiquetaProduto );

        if ($oReturn['status'] != 200)
            return $oReturn;

        return [
            'message' => 'OK',
            'status'  => 200
        ];
    }

    public function decrementByEtiqueta( $that, $oEtiquetaProduto )
    {
        $oEstoque = $that->Estoques->get( $oEtiquetaProduto->_matchingData['Estoques']->id );

        $oEstoque->qtde_saldo -= $oEtiquetaProduto->qtde;
        $oEstoque->peso_saldo -= $oEtiquetaProduto->peso;

        $oResult = $that->Estoques->save($oEstoque);

        if (!$oResult)
            return [
                'message' => __('Não foi possível realizar decremento do Estoque!') . EntityUtil::dumpErrors($oEstoque),
                'status'  => 406
            ];

        return [
            'message' => __('OK'),
            'status'  => 200
        ];
    }

    public function incrementByEtiquetaCodBarras( $that, $sCodigoBarras, $iOSID )
    {
        $oEtiquetaProduto = $that->EtiquetaProdutos->find()
            ->where(['codigo_barras' => $sCodigoBarras])
            ->first();

        $oEtiquetaCarregamento = LgDbUtil::getFind('OrdemServicoEtiquetaCarregamentos')
            ->innerJoinWith('EtiquetaProdutos')
            ->where([
                'OrdemServicoEtiquetaCarregamentos.ordem_servico_id' => $iOSID,
                'EtiquetaProdutos.id' => $oEtiquetaProduto->id,
            ])
            ->first();

        $oCarregamento = LgDbUtil::getFind('OrdemServicoCarregamentos')
            ->innerJoinWith('Estoques.EtiquetaProdutos')
            ->where([
                'OrdemServicoCarregamentos.ordem_servico_id' => $iOSID,
                'Estoques.lote_codigo IS'       => $oEtiquetaProduto->lote_codigo,
                'Estoques.lote_item IS'         => $oEtiquetaProduto->lote_item,
                'Estoques.produto_id IS'        => $oEtiquetaProduto->produto_id,
                'Estoques.unidade_medida_id IS' => $oEtiquetaProduto->unidade_medida_id,
                'Estoques.lote IS'              => $oEtiquetaProduto->lote,
                'Estoques.serie IS'             => $oEtiquetaProduto->serie,
                'Estoques.validade IS'          => $oEtiquetaProduto->validade,
                'EtiquetaProdutos.id'           => $oEtiquetaProduto->id,
            ])->first();

        if (!$oCarregamento ||  !$oEtiquetaCarregamento)
            return [
                'message' => __('Não foi possível realizar incremento do Estoque!'),
                'status'  => 406
            ];
            
        $oEstoque = LgDbUtil::getFirst('Estoques', [
            'Estoques.lote_codigo IS'       => $oCarregamento->lote_codigo,
            'Estoques.lote_item IS'         => $oCarregamento->lote_item,
            'Estoques.produto_id IS'        => $oCarregamento->produto_id,
            'Estoques.unidade_medida_id IS' => $oCarregamento->unidade_medida_id,
            'Estoques.lote IS'              => $oCarregamento->lote,
            'Estoques.serie IS'             => $oCarregamento->serie,
            'Estoques.validade IS'          => $oCarregamento->validade
        ]);

        if (!$oEstoque)
            return [
                'message' => __('Não foi possível realizar incremento do Estoque!'),
                'status'  => 406
            ];
        
        $oEstoque->qtde_saldo += $oEtiquetaProduto->qtde;
        $oEstoque->peso_saldo += $oEtiquetaProduto->peso;
        $oResult = LgDbUtil::get('Estoques')->save($oEstoque);

        if (!$oResult)
            return [
                'message' => __('Não foi possível realizar incremento do Estoque!') . EntityUtil::dumpErrors($oEstoque),
                'status'  => 406
            ];

        return [
            'message' => __('OK'),
            'dataExtra' => [
                'estoque_id'                             => $oResult->id,
                'etiqueta_produto'                       => $oEtiquetaProduto,
                'ordem_servico_carregamento_id'          => $oCarregamento->id,
                'ordem_servico_etiqueta_carregamento_id' => $oEtiquetaCarregamento->id
            ],
            'status'  => 200
        ];
    }

    public static function oGetEstoqueByLote($lote_codigo){
        return TableRegistry::get('Estoque')
        ->find()
        ->where(['lote_codigo' => $lote_codigo]);
    }

    /**
     * Para retornar a validação se um produto tem a quantidade necessária
     * será preciso passar um array nesse formato:
     *
     * $aData = [
     *      'qtde'        => x
     *      'endereco_id' => x
     *      'produto_id'  => x,
     *      'unidade_medida_id' => x,
     *      'controles_produto'   => [ // se ele nao for controlado por algum desses, é só nao enviar
     *          'controle_validade' => 'true',
     *          'controle_lote'     => 'true',
     *          'controle_serie'    => 'true',
     *          'controle_fifo'     => 'true'
     *      ]
     * ]
     */
    public static function verificaProdutoEstoque($aDataSeparacao, $iOSID = null, $aConditions = [], $bConsideraLoteDocumental = true)
    {
        $aEstoqueEndereco = EstoqueEndereco::getLocalizacaoProdutos($aDataSeparacao, false, $aConditions, [
            'qtde_saldo' => 'ASC'
        ], [], $bConsideraLoteDocumental);

        if (!$aEstoqueEndereco)
            return false;
        
        $dQtdeReservado = EstoqueEnderecoReserva::getQtdEstoqueReservado($aEstoqueEndereco, true, [
            'ordem_servico_id IS NOT ' => $iOSID
        ] + $aConditions, [
            'qtde_saldo' => 'ASC'
        ]);

        $dSaldo = 0;

        foreach ($aEstoqueEndereco as $oEstoqueEndereco) {
            $dSaldo += $oEstoqueEndereco->qtde_saldo;
        }

        $dSaldo = $dQtdeReservado - $dSaldo;
        $dSaldo = $dSaldo < 0 ? $dSaldo * -1 : $dSaldo;
        
        if ($dSaldo >= $aDataSeparacao['qtde'])
            return true;

        return false;
    }


}
