<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PlanoCargaDocumento Entity
 *
 * @property int $id
 * @property int|null $plano_carga_id
 * @property int|null $documento_mercadoria_id
 *
 * @property \App\Model\Entity\PlanoCarga $plano_carga
 * @property \App\Model\Entity\DocumentosMercadoria $documentos_mercadoria
 */
class PlanoCargaDocumento extends Entity
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
        
        'plano_carga_id' => true,
        'documento_mercadoria_id' => true,
        'plano_carga' => true,
        'documentos_mercadoria' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
