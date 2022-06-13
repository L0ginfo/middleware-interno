<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * DocumentoTransporteAnexo Entity
 *
 * @property int $id
 * @property int $anexo_id
 * @property int $documento_transporte_id
 * @property \Cake\I18n\Time $created_at
 * @property \Cake\I18n\Time|null $updated_at
 *
 * @property \App\Model\Entity\Anexo $anexo
 * @property \App\Model\Entity\DocumentosTransporte $documentos_transporte
 */
class DocumentoTransporteAnexo extends Entity
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
    protected $_accessible = [
        'anexo_id' => true,
        'documento_transporte_id' => true,
        'created_at' => true,
        'updated_at' => true,
        'anexo' => true,
        'documentos_transporte' => true,
    ];
}
