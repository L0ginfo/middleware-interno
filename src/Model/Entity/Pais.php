<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Pais Entity
 *
 * @property int $id
 * @property string $descricao
 * @property int $continente_id
 *
 * @property \App\Model\Entity\Continente $continente
 * @property \App\Model\Entity\Empresa[] $empresas
 * @property \App\Model\Entity\Estado[] $estados
 */
class Pais extends Entity
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
        'id' => false,
        '*' => true
    ];
}
