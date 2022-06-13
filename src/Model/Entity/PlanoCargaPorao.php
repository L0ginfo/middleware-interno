<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PlanoCargaPorao Entity
 *
 * @property int $id
 * @property int|null $plano_carga_id
 * @property int|null $porao_id
 * @property int|null $documento_mercadoria_item_id
 * @property string|null $qtde_prevista
 *
 * @property \App\Model\Entity\PlanoCarga $plano_carga
 * @property \App\Model\Entity\Porao $porao
 * @property \App\Model\Entity\DocumentosMercadoriasItem $documentos_mercadorias_item
 */
class PlanoCargaPorao extends Entity
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
        'porao_id' => true,
        'documento_mercadoria_item_id' => true,
        'qtde_prevista' => true,
        'plano_carga' => true,
        'porao' => true,
        'documentos_mercadorias_item' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
