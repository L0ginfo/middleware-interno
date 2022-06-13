<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * TabelasPrecosEquipesTrabalho Entity
 *
 * @property int $id
 * @property int $tabelas_preco_id
 * @property int $equipes_trabalho_id
 *
 * @property \App\Model\Entity\TabelasPreco $tabelas_preco
 * @property \App\Model\Entity\EquipesTrabalho $equipes_trabalho
 */
class TabelasPrecosEquipesTrabalho extends Entity
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
        'tabelas_preco_id' => true,
        'equipes_trabalho_id' => true,
        'tabelas_preco' => true,
        'equipes_trabalho' => true
    ];
}
