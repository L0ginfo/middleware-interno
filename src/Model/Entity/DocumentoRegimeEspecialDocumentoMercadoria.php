<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * DocumentoRegimeEspecialDocumentoMercadoria Entity
 *
 * @property int $id
 * @property int|null $documento_mercadoria_id
 * @property int|null $documento_regime_especial_id
 *
 * @property \App\Model\Entity\DocumentosMercadoria $documentos_mercadoria
 * @property \App\Model\Entity\DocumentoRegimeEspecial $documento_regime_especial
 */
class DocumentoRegimeEspecialDocumentoMercadoria extends Entity
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
        
        'documento_mercadoria_id' => true,
        'documento_regime_especial_id' => true,
        'documentos_mercadoria' => true,
        'documento_regime_especial' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
