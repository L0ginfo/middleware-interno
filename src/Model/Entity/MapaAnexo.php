<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * MapaAnexo Entity
 *
 * @property int $id
 * @property int $anexo_id
 * @property int $mapa_id
 *
 * @property \App\Model\Entity\Anexo $anexo
 * @property \App\Model\Entity\Mapa $mapa
 */
class MapaAnexo extends Entity
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
        
        'anexo_id' => true,
        'mapa_id' => true,
        'anexo' => true,
        'mapa' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
