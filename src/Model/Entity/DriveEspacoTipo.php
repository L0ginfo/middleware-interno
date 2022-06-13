<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * DriveEspacoTipo Entity
 *
 * @property int $id
 * @property string $descricao
 *
 * @property \App\Model\Entity\DriveEspaco[] $drive_espacos
 */
class DriveEspacoTipo extends Entity
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
        'drive_espacos' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
