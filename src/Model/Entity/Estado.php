<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Estado Entity
 *
 * @property int $id
 * @property int|null $codigo_uf
 * @property string $nome
 * @property string $uf
 * @property int $regiao_id
 * @property int|null $pais_id
 *
 * @property \App\Model\Entity\Regiao $regiao
 * @property \App\Model\Entity\Pais $pais
 * @property \App\Model\Entity\Cidade[] $cidades
 */
class Estado extends Entity
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
        'codigo_uf' => true,
        'nome' => true,
        'uf' => true,
        'regiao_id' => true,
        'pais_id' => true,
        'regiao' => true,
        'pais' => true,
        'cidades' => true
    ];
}
