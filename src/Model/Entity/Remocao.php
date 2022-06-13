<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Remocao Entity
 *
 * @property int $id
 * @property \Cake\I18n\Time $created_at
 * @property \Cake\I18n\Time|null $updated_at
 * @property string $descricao
 *
 * @property \App\Model\Entity\LingadaRemocao[] $lingada_remocoes
 */
class Remocao extends Entity
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
        
        'created_at' => true,
        'updated_at' => true,
        'descricao' => true,
        'lingada_remocoes' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
