<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * LingadaAvaria Entity
 *
 * @property int $id
 * @property string $descricao
 * @property int $avaria_id
 * @property int $ordem_servico_item_lingada_id
 * @property \Cake\I18n\Time $created_at
 * @property \Cake\I18n\Time|null $updated_at
 *
 * @property \App\Model\Entity\Avaria $avaria
 * @property \App\Model\Entity\OrdemServicoItemLingada $ordem_servico_item_lingada
 * @property \App\Model\Entity\LingadaAvariaFoto[] $lingada_avaria_fotos
 */
class LingadaAvaria extends Entity
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
        
        'descricao' => true,
        'avaria_id' => true,
        'ordem_servico_item_lingada_id' => true,
        'created_at' => true,
        'updated_at' => true,
        'avaria' => true,
        'ordem_servico_item_lingada' => true,
        'lingada_avaria_fotos' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
