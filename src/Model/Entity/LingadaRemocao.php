<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * LingadaRemocao Entity
 *
 * @property int $id
 * @property int $remocao_id
 * @property int $ordem_servico_item_lingada_id
 * @property \Cake\I18n\Time $created_at
 * @property \Cake\I18n\Time|null $updated_at
 *
 * @property \App\Model\Entity\Remocao $remocao
 * @property \App\Model\Entity\OrdemServicoItemLingada $ordem_servico_item_lingada
 */
class LingadaRemocao extends Entity
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
        
        'remocao_id' => true,
        'ordem_servico_item_lingada_id' => true,
        'created_at' => true,
        'updated_at' => true,
        'remocao' => true,
        'ordem_servico_item_lingada' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
