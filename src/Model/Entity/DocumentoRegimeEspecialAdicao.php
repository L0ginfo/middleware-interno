<?php
namespace App\Model\Entity;

use App\Util\DoubleUtil;
use Cake\ORM\Entity;

/**
 * DocumentoRegimeEspecialAdicao Entity
 *
 * @property int $id
 * @property int|null $documento_regime_especial_id
 * @property int $empresa_id
 * @property int|null $exportador_id
 * @property int|null $incoterm_id
 * @property int|null $ncm_id
 * @property int|null $nbm_id
 * @property int|null $moeda_id
 * @property int|null $importacao_regime_tributacao_id
 * @property int|null $produto_regime_tributacao_id
 * @property int|null $pis_cofins_regime_tributacao_id
 * @property float $peso_liquido
 * @property float $vcmv
 * @property float $importacao_aliquota
 * @property float $importacao_recolher
 * @property float $produto_aliquota
 * @property float $produto_recolher
 * @property float $pis_cofins_percentual
 * @property float $base_calculo
 * @property float $pis_pasep_aloquita
 * @property float $pis_pasep_devido
 * @property float $pis_pasep_recolher
 * @property float $cofins_aloquita
 * @property float $cofins_devido
 * @property float $cofins_recolher
 * @property \Cake\I18n\Time $created_at
 * @property \Cake\I18n\Time|null $updated_at
 *
 * @property \App\Model\Entity\UnidadeMedida $unidade_medida
 * @property \App\Model\Entity\Produto $produto
 * @property \App\Model\Entity\Container $container
 * @property \App\Model\Entity\DocumentoRegimeEspecial $documento_regime_especial
 * @property \App\Model\Entity\Empresa $empresa
 * @property \App\Model\Entity\DocumentoRegimeEspecialAdicaoItem[] $documento_regime_especial_adicao_itens
 */
class DocumentoRegimeEspecialAdicao extends Entity
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
        
        'documento_regime_especial_id' => true,
        'empresa_id' => true,
        'exportador_id' => true,
        'incoterm_id' => true,
        'ncm_id' => true,
        'nbm_id' => true,
        'moeda_id' => true,
        'importacao_regime_tributacao_id' => true,
        'produto_regime_tributacao_id' => true,
        'pis_cofins_regime_tributacao_id' => true,
        'peso_liquido' => true,
        'vcmv' => true,
        'importacao_aliquota' => true,
        'importacao_recolher' => true,
        'produto_aliquota' => true,
        'produto_recolher' => true,
        'pis_cofins_percentual' => true,
        'base_calculo' => true,
        'pis_pasep_aloquita' => true,
        'pis_pasep_devido' => true,
        'pis_pasep_recolher' => true,
        'cofins_aloquita' => true,
        'cofins_devido' => true,
        'cofins_recolher' => true,
        'created_at' => true,
        'updated_at' => true,
        'unidade_medida' => true,
        'produto' => true,
        'container' => true,
        'documento_regime_especial' => true,
        'empresa' => true,
        'documento_regime_especial_adicao_itens' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function doData($aDataPost){
        $aDataPost['empresa_id']            = Empresa::getEmpresaPadrao();
        $aDataPost['peso_liquido']          = DoubleUtil::toDBUnformat(@$aDataPost['peso_liquido']);
        $aDataPost['vcmv']                  = DoubleUtil::toDBUnformat(@$aDataPost['vcmv']);
        $aDataPost['importacao_aliquota']   = DoubleUtil::toDBUnformat(@$aDataPost['importacao_aliquota']);
        $aDataPost['importacao_recolher']   = DoubleUtil::toDBUnformat(@$aDataPost['importacao_recolher']);
        $aDataPost['produto_aliquota']      = DoubleUtil::toDBUnformat(@$aDataPost['produto_aliquota']);
        $aDataPost['produto_recolher']      = DoubleUtil::toDBUnformat(@$aDataPost['produto_recolher']);
        $aDataPost['pis_cofins_percentual'] = DoubleUtil::toDBUnformat(@$aDataPost['pis_cofins_percentual']);
        $aDataPost['base_calculo']          = DoubleUtil::toDBUnformat(@$aDataPost['base_calculo']);
        $aDataPost['pis_pasep_aloquita']    = DoubleUtil::toDBUnformat(@$aDataPost['pis_pasep_aloquita']);
        $aDataPost['pis_pasep_devido']      = DoubleUtil::toDBUnformat(@$aDataPost['pis_pasep_devido']);
        $aDataPost['pis_pasep_recolher']    = DoubleUtil::toDBUnformat(@$aDataPost['pis_pasep_recolher']);
        $aDataPost['cofins_aloquita']       = DoubleUtil::toDBUnformat(@$aDataPost['cofins_aloquita']);
        $aDataPost['cofins_devido']         = DoubleUtil::toDBUnformat(@$aDataPost['cofins_devido']);
        $aDataPost['cofins_recolher']       = DoubleUtil::toDBUnformat(@$aDataPost['cofins_recolher']);
        return $aDataPost; 
    }
}
