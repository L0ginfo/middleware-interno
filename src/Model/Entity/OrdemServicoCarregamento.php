<?php
namespace App\Model\Entity;

use App\RegraNegocio\Carregamento\Operacao\CarregamentoPorProdutos;
use App\RegraNegocio\GerenciamentoEstoque\ProdutosControlados;
use Cake\ORM\Entity;
use App\Util\DoubleUtil;
use App\Util\EntityUtil;
use App\Util\LgDbUtil;
use Cake\ORM\TableRegistry;


/**
 * OrdemServicoCarregamento Entity
 *
 * @property int $id
 * @property float $quantidade_carregada
 * @property float $m2_carregada
 * @property float $m3_carregada
 * @property int $empresa_id
 * @property int $estoque_id
 * @property int $ordem_servico_id
 *
 * @property \App\Model\Entity\Empresa $empresa
 * @property \App\Model\Entity\Estoque $estoque
 * @property \App\Model\Entity\OrdemServico $ordem_servico
 */
class OrdemServicoCarregamento extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * 
     *  'quantidade_carregada' => true,
     *  'm2_carregada' => true,
     *  'm3_carregada' => true,
     *  'empresa_id' => true,
     *  'estoque_id' => true,
     *  'ordem_servico_id' => true,
     *  'empresa' => true,
     *  'estoque' => true,
     *  'ordem_servico' => true
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public function saveOSCarregamento( $that, $oEtiquetaProduto, $iOSID )
    {
        $aData = [
            'lote_codigo'          => @$oEtiquetaProduto->lote_codigo,
            'lote_item'            => @$oEtiquetaProduto->lote_item,
            'unidade_medida_id'    => @$oEtiquetaProduto->unidade_medida_id,
            'endereco_id'          => @$oEtiquetaProduto->endereco_id,
            'quantidade_carregada' => DoubleUtil::toDBUnformat($oEtiquetaProduto->qtde),
            'm2_carregada'         => DoubleUtil::toDBUnformat($oEtiquetaProduto->m2),
            'm3_carregada'         => DoubleUtil::toDBUnformat($oEtiquetaProduto->m3),
            'empresa_id'           => $that->getEmpresaAtual(),
            'estoque_id'           => $oEtiquetaProduto->_matchingData['Estoques']->id,
            'ordem_servico_id'     => $iOSID
        ];

        $oOrdemServicoCarregamento = $that->OrdemServicoCarregamentos->newEntity();
        $oOrdemServicoCarregamento = $that->OrdemServicoCarregamentos->patchEntity($oOrdemServicoCarregamento, $aData);

        if (!$oResult = $that->OrdemServicoCarregamentos->save($oOrdemServicoCarregamento)) 
            return [
                'message' => __('Não foi possível gravar a OS de Carregamento de Estoque!') . EntityUtil::dumpErrors($oOrdemServicoCarregamento),
                'status'  => 406
            ];

        return [
            'message' => __('OK'),
            'status'  => 200
        ];
    }

    public function removeOSCarregamento( $that, $iOSCarregamentoID )
    {
        $oOrdemServicoCarregamento = $that->OrdemServicoCarregamentos->get($iOSCarregamentoID);

        if (!$oResult = $that->OrdemServicoCarregamentos->delete($oOrdemServicoCarregamento)) 
            return [
                'message' => __('Não foi possível remover a OS de Carregamento de Estoque!') . EntityUtil::dumpErrors($oOrdemServicoCarregamento),
                'status'  => 406
            ];

        return [
            'message' => __('OK'),
            'status'  => 200
        ];
    }

    public static function getOrdensServicosCarregamentosByOrdensServicos($iOrdemServico){
        
        return TableRegistry::get('OrdemServicoCarregamentos')
        ->find()
        ->where(['ordem_servico_id'=>$iOrdemServico]);
        
    }

    public static function getProdutosCarregados($aLiberacoesDocumentais, $iOSID)
    {
        foreach ($aLiberacoesDocumentais as $iLiberacaoID => $aLiberacaoDados) {
            if (!$aLiberacaoDados['liberacao_dados']->liberacao_por_produto) 
                continue;

            $iLiberacaoID = $aLiberacaoDados['liberacao_dados']->id;

            foreach ($aLiberacaoDados['itens'] as $iKeyItem => $oItem) {
                $aCarregamentos = LgDbUtil::getFind('OrdemServicoCarregamentos')
                    ->contain([
                        'OrdemServicos' => ['Resvs' => [
                            'ResvsLiberacoesDocumentais' => function($q) use($iLiberacaoID) {
                                return $q->where(['ResvsLiberacoesDocumentais.liberacao_documental_id' => $iLiberacaoID]);
                            }
                        ]],
                        'Enderecos' => ['Areas' => ['Locais']]
                    ])
                    ->where([
                        'OrdemServicoCarregamentos.ordem_servico_id = OrdemServicos.id',
                        // 'estoque_id'              => $oItem->estoque_id,
                        'lote_codigo IS'          => $oItem->lote_codigo,
                        'lote_item IS'            => $oItem->lote_item,
                        'produto_id IS'           => $oItem->produto_id,
                        'lote IS'                 => $oItem->lote,
                        'serie IS'                => $oItem->serie,
                        'validade IS'             => $oItem->validade,
                        'unidade_medida_id IS'    => $oItem->unidade_medida_id,
                        'liberacao_documental_id IS' => $oItem->liberacao_documental_id,
                        'OrdemServicoCarregamentos.ordem_servico_id' => $iOSID
                    ])->toArray();

                $dSaldo               = $oItem->quantidade_liberada;
                $dQuantidadeCarregada = 0.0;

                foreach ($aCarregamentos as $oCarregamento) {
                    $dQuantidadeCarregada += $oCarregamento->quantidade_carregada;
                    $oCarregamento->endereco->composicao = Endereco::getEnderecoCompletoByID(null, null, $oCarregamento->endereco, ['com_local_area' => true]);
                }

                $dSaldo -= $dQuantidadeCarregada;

                $aLiberacoesDocumentais[$iLiberacaoID]['item_produto_carregamentos'][$iKeyItem]['entities'] = $aCarregamentos;
                $aLiberacoesDocumentais[$iLiberacaoID]['item_produto_carregamentos'][$iKeyItem]['dados'] = [
                    'total_quantidade_carregada' => $dQuantidadeCarregada,
                    'total_saldo_carregado'      => $dSaldo
                ];

                $aEnderecosParaCarregar = $aEnderecosJaCarregados = [];
                $aEnderecosParaCarregarSum = $aEnderecosJaCarregadosSum = [];

                foreach ($aLiberacoesDocumentais[$iLiberacaoID]['itens'] as $oItem) {
                    foreach ($oItem->estoque_enderecos as $oEstoqueEndereco) {
                        $sAgroup = $oItem->produto_id . '_' . $oItem->lote_codigo . '_' . $oEstoqueEndereco->endereco_id;

                        @$aEnderecosParaCarregarSum[$sAgroup]['qtde'] += $oEstoqueEndereco->qtde_saldo;
                        @$aEnderecosParaCarregarSum[$sAgroup]['composicao'] = $oEstoqueEndereco->endereco->composicao;
                    }
                }

                foreach ($aEnderecosParaCarregarSum as $sKey => $aEnderecoParaCarregarSum) {
                    $aEnderecosParaCarregar[$sKey] = '(Qt. ' . DoubleUtil::fromDBUnformat($aEnderecoParaCarregarSum['qtde'], 3) . ') ' . $aEnderecoParaCarregarSum['composicao'];
                }

                foreach ($aLiberacoesDocumentais[$iLiberacaoID]['item_produto_carregamentos'] as $aItensCarregados) {
                    foreach ($aItensCarregados['entities'] as $oItemCarregado) {
                        $sAgroup = $oItemCarregado->produto_id . '_' . $oItemCarregado->lote_codigo . '_' . $oItemCarregado->endereco_id;
    
                        @$aEnderecosJaCarregadosSum[$sAgroup]['qtde'] += $oItemCarregado->quantidade_carregada;
                        @$aEnderecosJaCarregadosSum[$sAgroup]['composicao'] = $oItemCarregado->endereco->composicao;
                    }
                } 

                foreach ($aEnderecosJaCarregadosSum as $sKey => $aEnderecoJaCarregadosSum) {
                    if (!isset($aEnderecosParaCarregar[$sKey]))
                        $aEnderecosParaCarregar[$sKey] = '(Qt. Carregada ' . DoubleUtil::fromDBUnformat($aEnderecoJaCarregadosSum['qtde'], 3) . ') ' . $aEnderecoJaCarregadosSum['composicao'];
                }

                $aLiberacoesDocumentais[$iLiberacaoID]['relacao_enderecos'] = $aEnderecosParaCarregar + $aEnderecosJaCarregados;
            }
        }

        return $aLiberacoesDocumentais;
    }

    public static function produtoFoiCarregado($oThat)
    {
        // $aData = $oThat->request->getData();
        // $iOSID  = $aData['iOSID'];
        // $oLiberacaoDocumentalItem  = CarregamentoPorProdutos::findByParams($aData);
        // $oOrdemServicoCarregamento = CarregamentoPorProdutos::getCarregamento(0, $oLiberacaoDocumentalItem, $iOSID);

        // if (!$oOrdemServicoCarregamento->isNew())
        //     return true;

        // return false;
    }

    public static function getQtdeCarregadaByLiberacaoItem($oLiberacaoDocumentalItem)
    {
        $dQuantidadeCarregada = 0;
        $aOrdemServicoCarregamentos = LgDbUtil::getFind('OrdemServicoCarregamentos')
            ->where(ProdutosControlados::getProdutoControlesValuesToQuery($oLiberacaoDocumentalItem, false, false, true, 'OrdemServicoCarregamentos') + [
                'liberacao_documental_id IS' => $oLiberacaoDocumentalItem->liberacao_documental_id
            ])
            ->toArray();
        
        
        foreach($aOrdemServicoCarregamentos as $oOrdemServicoCarregamento) {
            $dQuantidadeCarregada += $oOrdemServicoCarregamento->quantidade_carregada;
        }

        return $dQuantidadeCarregada;
    }
}
