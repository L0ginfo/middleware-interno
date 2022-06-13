<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * LingadaCaracteristica Entity
 *
 * @property int $id
 * @property int|null $plano_carga_caracteristica_id
 * @property int|null $ordem_servico_item_lingada_id
 * @property int|null $caracteristica_id
 * @property int|null $plano_carga_caracteristica_porao_id
 *
 * @property \App\Model\Entity\PlanoCargaCaracteristica $plano_carga_caracteristica
 * @property \App\Model\Entity\OrdemServicoItemLingada $ordem_servico_item_lingada
 * @property \App\Model\Entity\Caracteristica $caracteristica
 * @property \App\Model\Entity\PlanoCargaPoraoCaracteristica $plano_carga_porao_caracteristica
 */
class LingadaCaracteristica extends Entity
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
        
        'plano_carga_caracteristica_id' => true,
        'ordem_servico_item_lingada_id' => true,
        'caracteristica_id' => true,
        'plano_carga_caracteristica_porao_id' => true,
        'plano_carga_caracteristica' => true,
        'ordem_servico_item_lingada' => true,
        'caracteristica' => true,
        'plano_carga_porao_caracteristica' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
