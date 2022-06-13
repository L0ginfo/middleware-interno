<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PlanoCargaPoraoCaracteristica Entity
 *
 * @property int $id
 * @property int|null $plano_carga_id
 * @property int|null $plano_carga_porao_id
 * @property int|null $tipo_caracteristica_id
 * @property int|null $plano_carga_caracteristica_id
 *
 * @property \App\Model\Entity\PlanoCarga $plano_carga
 * @property \App\Model\Entity\PlanoCargaPorao $plano_carga_porao
 * @property \App\Model\Entity\TipoCaracteristica $tipo_caracteristica
 * @property \App\Model\Entity\PlanoCargaCaracteristica $plano_carga_caracteristica
 */
class PlanoCargaPoraoCaracteristica extends Entity
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
        
        'plano_carga_id' => true,
        'plano_carga_porao_id' => true,
        'tipo_caracteristica_id' => true,
        'plano_carga_caracteristica_id' => true,
        'plano_carga' => true,
        'plano_carga_porao' => true,
        'tipo_caracteristica' => true,
        'plano_carga_caracteristica' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
