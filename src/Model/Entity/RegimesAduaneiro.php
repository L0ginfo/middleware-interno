<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * RegimesAduaneiro Entity
 *
 * @property int $id
 * @property string $descricao
 * @property int|null $dias_vencimento
 *
 * @property \App\Model\Entity\DocumentosMercadoria[] $documentos_mercadorias
 */
class RegimesAduaneiro extends Entity
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
        'dias_vencimento' => true,
        'documentos_mercadorias' => true,
        'desconto' => true,
    ];
}
