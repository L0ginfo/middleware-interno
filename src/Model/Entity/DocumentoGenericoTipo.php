<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * DocumentoGenericoTipo Entity
 *
 * @property int $id
 * @property string $descricao
 * @property int $documento_generico_id
 *
 * @property \App\Model\Entity\DocumentoGenerico $documento_generico
 */
class DocumentoGenericoTipo extends Entity
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
        'documento_generico_id' => true,
        'documento_generico' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
