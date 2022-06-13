<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * EquipesTrabalhosUsuario Entity
 *
 * @property int $id
 * @property int $equipes_trabalho_id
 * @property int $usuario_id
 * @property string $recurso
 *
 * @property \App\Model\Entity\EquipesTrabalho $equipes_trabalho
 * @property \App\Model\Entity\Usuario $usuario
 */
class EquipesTrabalhosUsuario extends Entity
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
        'equipes_trabalho_id' => true,
        'usuario_id' => true,
        'recurso' => true,
        'equipes_trabalho' => true,
        'usuario' => true
    ];
}
