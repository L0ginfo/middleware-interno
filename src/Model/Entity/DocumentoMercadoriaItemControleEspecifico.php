<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * DocumentoMercadoriaItemControleEspecifico Entity
 *
 * @property int $id
 * @property int $controle_especifico_id
 * @property int $documento_mercadoria_item_id
 *
 * @property \App\Model\Entity\ControleEspecifico $controle_especifico
 * @property \App\Model\Entity\DocumentosMercadoriasItem $documentos_mercadorias_item
 */
class DocumentoMercadoriaItemControleEspecifico extends Entity
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
        
        'controle_especifico_id' => true,
        'documento_mercadoria_item_id' => true,
        'controle_especifico' => true,
        'documentos_mercadorias_item' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
