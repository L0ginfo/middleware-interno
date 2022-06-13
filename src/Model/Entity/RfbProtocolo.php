<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * RfbProtocolo Entity
 *
 * @property int $id
 * @property string|null $endpoint_rfb
 * @property string|null $trigger
 * @property string|null $id_coluna
 * @property string|null $protocolo_gerado
 * @property \Cake\I18n\Time|null $created_at
 * @property \Cake\I18n\Time|null $modified_at
 */
class RfbProtocolo extends Entity
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
        
        'endpoint_rfb' => true,
        'trigger' => true,
        'id_coluna' => true,
        'protocolo_gerado' => true,
        'created_at' => true,
        'modified_at' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
