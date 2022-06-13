<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * TipoServicoBancario Entity
 *
 * @property int $id
 * @property string $codigo
 * @property string $descricao
 *
 * @property \App\Model\Entity\Empresa[] $empresas
 */
class TipoServicoBancario extends Entity
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
        'codigo' => true,
        'descricao' => true,
        'empresas' => true
    ];
}
