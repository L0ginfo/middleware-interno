<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CargaGeral Entity.
 *
 * @property int $id
 * @property string $descricao_mercadoria
 * @property string $ncm
 * @property int $quantidade
 * @property float $peso_bruto
 * @property float $peso_liquido
 * @property int $codigo_onu_id
 * @property \App\Model\Entity\CodigoOnus $codigo_onus
 * @property int $embalagem_id
 * @property \App\Model\Entity\Embalagem $embalagem
 * @property int $entrada_id
 * @property \App\Model\Entity\Entrada $entrada
 */
class CargaGeral extends Entity
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
