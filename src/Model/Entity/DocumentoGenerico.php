<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * DocumentoGenerico Entity
 *
 * @property int $id
 * @property string $numero
 * @property string|null $descricao
 *
 * @property \App\Model\Entity\DocumentoGenericoTipo[] $documento_generico_tipos
 * @property \App\Model\Entity\Resv[] $resvs
 */
class DocumentoGenerico extends Entity
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
        
        'numero' => true,
        'descricao' => true,
        'documento_generico_tipos' => true,
        'resvs' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
