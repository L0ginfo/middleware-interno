<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PlanoCargaItemDestino Entity
 *
 * @property int $id
 * @property int $plano_carga_id
 * @property int $documento_mercadoria_item_id
 * @property int $destino
 * @property int|null $local_id
 *
 * @property \App\Model\Entity\PlanoCarga $plano_carga
 * @property \App\Model\Entity\DocumentosMercadoriasItem $documentos_mercadorias_item
 * @property \App\Model\Entity\Local $local
 */
class PlanoCargaItemDestino extends Entity
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
        'documento_mercadoria_item_id' => true,
        'destino' => true,
        'local_id' => true,
        'plano_carga' => true,
        'documentos_mercadorias_item' => true,
        'local' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
