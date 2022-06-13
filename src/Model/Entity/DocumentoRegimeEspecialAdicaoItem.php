<?php
namespace App\Model\Entity;

use App\Util\DoubleUtil;
use Cake\ORM\Entity;

/**
 * DocumentoRegimeEspecialAdicaoItem Entity
 *
 * @property int $id
 * @property int|null $unidade_medida_id
 * @property int|null $documento_regime_especial_id
 * @property int|null $documento_regime_especial_adicao_id
 * @property int $empresa_id
 * @property int $moeda_id
 * @property float $quantidade
 * @property float $vuvc
 * @property string $descricao_completa
 * @property \Cake\I18n\Time $created_at
 * @property \Cake\I18n\Time|null $updated_at
 *
 * @property \App\Model\Entity\UnidadeMedida $unidade_medida
 * @property \App\Model\Entity\Produto $produto
 * @property \App\Model\Entity\Container $container
 * @property \App\Model\Entity\DocumentoRegimeEspecial $documento_regime_especial
 * @property \App\Model\Entity\DocumentoRegimeEspecialAdicao $documento_regime_especial_adicao
 * @property \App\Model\Entity\Empresa $empresa
 * @property \App\Model\Entity\Moeda $moeda
 */
class DocumentoRegimeEspecialAdicaoItem extends Entity
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
        
        'unidade_medida_id' => true,
        'documento_regime_especial_id' => true,
        'documento_regime_especial_adicao_id' => true,
        'empresa_id' => true,
        'moeda_id' => true,
        'quantidade' => true,
        'vuvc' => true,
        'descricao_completa' => true,
        'created_at' => true,
        'updated_at' => true,
        'unidade_medida' => true,
        'produto' => true,
        'container' => true,
        'documento_regime_especial' => true,
        'documento_regime_especial_adicao' => true,
        'empresa' => true,
        'moeda' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function doData($aDataPost){
        $aDataPost['sequencia'] = empty($aDataPost['sequencia']) ? 1 : (int) $aDataPost['sequencia'];
        $aDataPost['empresa_id'] = Empresa::getEmpresaPadrao();
        $aDataPost['quantidade'] = DoubleUtil::toDBUnformat(@$aDataPost['quantidade']);
        $aDataPost['vucv'] = DoubleUtil::toDBUnformat(@$aDataPost['vucv']);
        return $aDataPost; 
    }
}
