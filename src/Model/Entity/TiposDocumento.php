<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * TiposDocumento Entity
 *
 * @property int $id
 * @property string|null $descricao
 * @property string $tipo_documento
 *
 * @property \App\Model\Entity\DocumentosMercadoria[] $documentos_mercadorias
 * @property \App\Model\Entity\DocumentosTransporte[] $documentos_transportes
 */
class TiposDocumento extends Entity
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
        'descricao' => true,
        'tipo_documento' => true,
        'documentos_mercadorias' => true,
        'documentos_transportes' => true
    ];
}
