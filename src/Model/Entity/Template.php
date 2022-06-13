<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Template Entity
 *
 * @property int $id
 * @property string $template
 * @property string $descricao
 * @property string|null $codigo
 */
class Template extends Entity
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
        
        'template' => true,
        'descricao' => true,
        'codigo' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
