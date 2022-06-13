<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * DocumentoRegimeEspecialTributo Entity
 *
 * @property int $id
 * @property int|null $documento_regime_especial_id
 * @property int|null $tributo_id
 * @property float $suspenso
 * @property float $recolhido
 * @property \Cake\I18n\Time $created_at
 * @property \Cake\I18n\Time|null $updated_at
 *
 * @property \App\Model\Entity\Tributo $tributo
 */
class DocumentoRegimeEspecialTributo extends Entity
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
        'tributo_id' => true,
        'suspenso' => true,
        'recolhido' => true,
        'created_at' => true,
        'updated_at' => true,
        'tributo' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
