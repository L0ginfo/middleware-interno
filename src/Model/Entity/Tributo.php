<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Tributo Entity
 *
 * @property int $id
 * @property string $descricao
 * @property string|null $codigo
 * @property string|null $codigo_externo
 * @property \Cake\I18n\Time $created_at
 * @property \Cake\I18n\Time|null $updated_at
 *
 * @property \App\Model\Entity\DocumentoRegimeEspecialTributo[] $documento_regime_especial_tributos
 */
class Tributo extends Entity
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
        'codigo' => true,
        'codigo_externo' => true,
        'created_at' => true,
        'updated_at' => true,
        'documento_regime_especial_tributos' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
