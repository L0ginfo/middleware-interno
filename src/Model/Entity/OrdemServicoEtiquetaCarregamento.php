<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use App\Util\DoubleUtil;
use App\Util\EntityUtil;

/**
 * OrdemServicoEtiquetaCarregamento Entity
 *
 * @property int $id
 * @property float $quantidade_carregada
 * @property float $peso_carregada
 * @property float $m2_carregada
 * @property float $m3_carregada
 * @property int $empresa_id
 * @property int $etiqueta_produto_id
 * @property int $ordem_servico_id
 *
 * @property \App\Model\Entity\Empresa $empresa
 * @property \App\Model\Entity\EtiquetaProduto $etiqueta_produto
 * @property \App\Model\Entity\OrdemServico $ordem_servico
 */
class OrdemServicoEtiquetaCarregamento extends Entity
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
        'quantidade_carregada' => true,
        'peso_carregada' => true,
        'm2_carregada' => true,
        'm3_carregada' => true,
        'empresa_id' => true,
        'etiqueta_produto_id' => true,
        'ordem_servico_id' => true,
        'empresa' => true,
        'etiqueta_produto' => true,
        'ordem_servico' => true
    ];

    public function saveOSEtiquetaCarregamento( $that, $oEtiquetaProduto, $iOSID ) 
    {
        $aData = [
            'quantidade_carregada' =>  DoubleUtil::toDBUnformat($oEtiquetaProduto->qtde),
            'peso_carregada'       =>  DoubleUtil::toDBUnformat($oEtiquetaProduto->peso),
            'm2_carregada'         =>  DoubleUtil::toDBUnformat($oEtiquetaProduto->m2),
            'm3_carregada'         =>  DoubleUtil::toDBUnformat($oEtiquetaProduto->m3),
            'empresa_id'           =>  $that->getEmpresaAtual(),
            'etiqueta_produto_id'  =>  $oEtiquetaProduto->id,
            'ordem_servico_id'     =>  $iOSID
        ];

        $oOrdemServicoEtiquetaCarregamento = $that->OrdemServicoEtiquetaCarregamentos->newEntity();
        $oOrdemServicoEtiquetaCarregamento = $that->OrdemServicoEtiquetaCarregamentos->patchEntity($oOrdemServicoEtiquetaCarregamento, $aData);

        if (!$oResult = $that->OrdemServicoEtiquetaCarregamentos->save($oOrdemServicoEtiquetaCarregamento)) 
            return [
                'message' => __('Não foi possível gravar a OS de Carregamento de Etiqueta de Estoque!') . EntityUtil::dumpErrors($oOrdemServicoEtiquetaCarregamento),
                'status'  => 406
            ];

        return [
            'message' => __('OK'),
            'status'  => 200
        ];
    }

    public function getEtiquetasCarregadas( $that, $iOSID )
    {
        $aEtiquetas = array();
        $aCodigoBarras = array();
        $that->loadModel('Estoques');

        $oEtiquetasCarregadas = $that->OrdemServicoEtiquetaCarregamentos->find()
            ->contain([
                'EtiquetaProdutos' => [
                    'Estoques'
                ]
            ])
            ->where([
                'OrdemServicoEtiquetaCarregamentos.ordem_servico_id' => $iOSID
            ])
            ->toArray();

        foreach ($oEtiquetasCarregadas as $keyEtiquetaCarregada => $oEtiquetasCarregadas) {

            $key = $oEtiquetasCarregadas->etiqueta_produto->estoques[0]->id . '_' . $oEtiquetasCarregadas->etiqueta_produto->unidade_medida_id;

            if (array_key_exists($key, $aEtiquetas))
                $aEtiquetas[ $key ]['quantidade_carregada'] += ($oEtiquetasCarregadas->quantidade_carregada);
            else
                $aEtiquetas[ $key ]['quantidade_carregada'] = ($oEtiquetasCarregadas->quantidade_carregada);

            $aEtiquetas[ $key ]['etiqueta_id'] = $oEtiquetasCarregadas->etiqueta_produto->unidade_medida_id;
            
            $aCodigoBarras[] = $oEtiquetasCarregadas->etiqueta_produto->codigo_barras;
        }
        
        return [
            'etiquetas'     => $aEtiquetas,
            'codigo_barras' => $aCodigoBarras
        ];
    }

    public function removeOSEtiquetaCarregamento ( $that, $iOSEtiquetaCarregamentoID )
    {
        $oOrdemServicoEtiquetaCarregamentos = $that->OrdemServicoEtiquetaCarregamentos->get($iOSEtiquetaCarregamentoID);

        if (!$oResult = $that->OrdemServicoEtiquetaCarregamentos->delete($oOrdemServicoEtiquetaCarregamentos)) 
            return [
                'message' => __('Não foi possível remover a OS de Etiqueta Carregamento de Estoque!') . EntityUtil::dumpErrors($oOrdemServicoEtiquetaCarregamentos),
                'status'  => 406
            ];

        return [
            'message' => __('OK'),
            'status'  => 200
        ];
    }
}
