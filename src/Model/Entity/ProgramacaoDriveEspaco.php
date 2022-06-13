<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ProgramacaoDriveEspaco Entity
 *
 * @property int $id
 * @property int $drive_espaco_id
 * @property int $programacao_id
 *
 * @property \App\Model\Entity\DriveEspaco $drive_espaco
 * @property \App\Model\Entity\Programacao $programacao
 */
class ProgramacaoDriveEspaco extends Entity
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
        
        'drive_espaco_id' => true,
        'programacao_id' => true,
        'drive_espaco' => true,
        'programacao' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
