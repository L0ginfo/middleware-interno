<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Documento Entity
 *
 * @property int $id
 * @property string $descricao
 * @property int $anexo_id
 *
 * @property \App\Model\Entity\Entrada[] $entradas
 */
class Documento extends Entity
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
        'anexo_id' => true,
        'entradas' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
