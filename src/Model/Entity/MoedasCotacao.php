<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use App\Util\DoubleUtil;
use App\Util\LgDbUtil;

/**
 * MoedasCotacao Entity
 *
 * @property int $id
 * @property string|null $tipo_cotacao
 * @property \Cake\I18n\Date|null $data_cotacao
 * @property float|null $valor_cotacao
 * @property int $moeda_id
 *
 * @property \App\Model\Entity\Moeda $moeda
 */
class MoedasCotacao extends Entity
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
        'tipo_cotacao' => true,
        'data_cotacao' => true,
        'valor_cotacao' => true,
        'moeda_id' => true,
        'moeda' => true
    ];

    public static function setValoresMoedasLiberacao( $that, $oLiberacaoDocumental )
    {
        $sDataHoje = $oLiberacaoDocumental->data_registro;

        $cotacao_fob = LgDbUtil::getFind('MoedasCotacoes')
            ->where([
                'moeda_id' => $oLiberacaoDocumental->moeda_fob_id, 
                'data_cotacao' => $sDataHoje
            ])
            ->order('data_cotacao', 'DESC')
            ->first();
        $cotacao_frete = LgDbUtil::getFind('MoedasCotacoes')
            ->where([
                'moeda_id' => $oLiberacaoDocumental->moeda_frete_id, 
                'data_cotacao' => $sDataHoje
            ])
            ->order('data_cotacao', 'DESC')
            ->first();
        $cotacao_seguro = LgDbUtil::getFind('MoedasCotacoes')
            ->where([
                'moeda_id' => $oLiberacaoDocumental->moeda_seguro_id, 
                'data_cotacao' => $sDataHoje
            ])
            ->order('data_cotacao', 'DESC')
            ->first();
        $cotacao_cif = LgDbUtil::getFind('MoedasCotacoes')
            ->where([
                'moeda_id' => $oLiberacaoDocumental->moeda_cif_id, 
                'data_cotacao' => $sDataHoje
            ])
            ->order('data_cotacao', 'DESC')
            ->first();

        $cotacao_cif    = $cotacao_cif    ? $cotacao_cif->valor_cotacao    : 1;
        $cotacao_fob    = $cotacao_fob    ? $cotacao_fob->valor_cotacao    : 1;
        $cotacao_frete  = $cotacao_frete  ? $cotacao_frete->valor_cotacao  : 1;
        $cotacao_seguro = $cotacao_seguro ? $cotacao_seguro->valor_cotacao : 1;
        
        if ($oLiberacaoDocumental->moeda_cif_id == 2)
            $result_cif = $oLiberacaoDocumental->valor_cif_moeda;
        else 
            $result_cif = $cotacao_cif * $oLiberacaoDocumental->valor_cif_moeda;

        if ($oLiberacaoDocumental->moeda_fob_id == 2)
            $result_fob = $oLiberacaoDocumental->valor_fob_moeda;
        else 
            $result_fob = $cotacao_fob * $oLiberacaoDocumental->valor_fob_moeda;
            
        if ($oLiberacaoDocumental->moeda_frete_id == 2)
            $result_frete = $oLiberacaoDocumental->valor_frete_moeda;
        else 
            $result_frete = $cotacao_frete * $oLiberacaoDocumental->valor_frete_moeda;
            
        if ($oLiberacaoDocumental->moeda_seguro_id == 2)
            $result_seguro = $oLiberacaoDocumental->valor_seguro_moeda;
        else 
            $result_seguro = $cotacao_seguro * $oLiberacaoDocumental->valor_seguro_moeda;

        $oLiberacaoDocumental->resultado_moeda_fob    = round($result_fob   ,2);
        $oLiberacaoDocumental->resultado_moeda_cif    = round($result_cif   ,2);
        $oLiberacaoDocumental->resultado_moeda_frete  = round($result_frete ,2);
        $oLiberacaoDocumental->resultado_moeda_seguro = round($result_seguro,2);

        $oLiberacaoDocumental->cotacao_moeda_fob    = $cotacao_fob;
        $oLiberacaoDocumental->cotacao_moeda_cif    = $cotacao_cif;
        $oLiberacaoDocumental->cotacao_moeda_frete  = $cotacao_frete;
        $oLiberacaoDocumental->cotacao_moeda_seguro = $cotacao_seguro;

        $oLiberacaoDocumental->cif_por_peso_liquido = $oLiberacaoDocumental->resultado_moeda_cif 
            ? @($oLiberacaoDocumental->resultado_moeda_cif / $oLiberacaoDocumental->peso_liquido) 
            : 0;
        
        return $oLiberacaoDocumental;
    }
}
