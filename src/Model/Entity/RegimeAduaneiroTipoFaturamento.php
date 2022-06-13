<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * RegimeAduaneiroTipoFaturamento Entity
 *
 * @property int $id
 * @property string $descricao
 * @property int $regime_aduaneiro_id
 * @property int $tipo_faturamento_id
 *
 * @property \App\Model\Entity\RegimesAduaneiro $regimes_aduaneiro
 * @property \App\Model\Entity\TiposFaturamento $tipos_faturamento
 */
class RegimeAduaneiroTipoFaturamento extends Entity
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
        'descricao' => true,
        'regime_aduaneiro_id' => true,
        'tipo_faturamento_id' => true,
        'regimes_aduaneiro' => true,
        'tipos_faturamento' => true
    ];
}
