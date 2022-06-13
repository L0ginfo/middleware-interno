<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * EquipesTrabalho Entity
 *
 * @property int $id
 * @property string $descricao
 * @property int $recebimento
 * @property int $expedicao
 * @property int $separacao
 *
 * @property \App\Model\Entity\Usuario[] $usuarios
 * @property \App\Model\Entity\TabelasPreco[] $tabelas_precos
 */
class EquipesTrabalho extends Entity
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
        'recebimento' => true,
        'expedicao' => true,
        'separacao' => true,
        'usuarios' => true,
        'tabelas_precos' => true
    ];
}
