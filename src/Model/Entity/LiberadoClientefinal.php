<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * LiberadoClientefinal Entity.
 *
 * @property int $id
 * @property string $doc_saida
 * @property string $doc_id
 * @property string $lote
 * @property string $cod_cliente
 * @property string $conhecimento
 * @property string $num
 * @property string $cnpj_final
 * @property float $quantidade
 */
class LiberadoClientefinal extends Entity
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
        '*' => true,
        'id' => false,
    ];
}
