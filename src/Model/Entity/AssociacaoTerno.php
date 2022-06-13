<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AssociacaoTerno Entity
 *
 * @property int $id
 * @property int $ordem_servico_id
 * @property int $porao_id
 * @property int $terno_id
 * @property int $sentido_id
 * @property \Cake\I18n\Time $created_at
 * @property \Cake\I18n\Time|null $updated_at
 * @property int|null $plano_carga_id
 *
 * @property \App\Model\Entity\OrdemServico $ordem_servico
 * @property \App\Model\Entity\Porao $porao
 * @property \App\Model\Entity\Terno $terno
 * @property \App\Model\Entity\Sentido $sentido
 * @property \App\Model\Entity\PlanoCarga $plano_carga
 */
class AssociacaoTerno extends Entity
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
        
        'ordem_servico_id' => true,
        'porao_id' => true,
        'terno_id' => true,
        'sentido_id' => true,
        'created_at' => true,
        'updated_at' => true,
        'plano_carga_id' => true,
        'ordem_servico' => true,
        'porao' => true,
        'terno' => true,
        'sentido' => true,
        'plano_carga' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
