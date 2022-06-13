<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ProdutoEstrutura Entity
 *
 * @property int $id
 * @property int $produto_id
 * @property int $unidade_medida_id
 * @property int $produto_componente_id
 * @property int $unidade_medida_comp_id
 * @property float $quantidade
 *
 * @property \App\Model\Entity\Produto $produto
 * @property \App\Model\Entity\UnidadeMedida $unidade_medida
 */
class ProdutoEstrutura extends Entity
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
        'id' => false
    ];
}
