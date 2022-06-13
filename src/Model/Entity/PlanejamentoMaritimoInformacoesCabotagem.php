<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PlanejamentoMaritimoInformacoesCabotagem Entity
 *
 * @property int $id
 * @property int $planejamento_maritimos_id
 * @property int|null $ce_mercante
 * @property string|null $ncm
 * @property float|null $peso
 * @property float|null $quantidade
 *
 * @property \App\Model\Entity\PlanejamentoMaritimo $planejamento_maritimo
 */
class PlanejamentoMaritimoInformacoesCabotagem extends Entity
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
        
        'planejamento_maritimos_id' => true,
        'ce_mercante' => true,
        'ncm' => true,
        'peso' => true,
        'quantidade' => true,
        'planejamento_maritimo' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
