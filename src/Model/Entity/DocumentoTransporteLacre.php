<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * DocumentoTransporteLacre Entity
 *
 * @property int $id
 * @property int $documento_transporte_id
 * @property string $descricao
 * @property int $lacre_tipo_id
 *
 * @property \App\Model\Entity\DocumentosTransporte $documentos_transporte
 * @property \App\Model\Entity\LacreTipo $lacre_tipo
 */
class DocumentoTransporteLacre extends Entity
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
        
        'documento_transporte_id' => true,
        'descricao' => true,
        'lacre_tipo_id' => true,
        'documentos_transporte' => true,
        'lacre_tipo' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
