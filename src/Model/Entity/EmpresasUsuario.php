<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * EmpresasUsuario Entity.
 *
 * @property int $id
 * @property int $empresa_id
 * @property \App\Model\Entity\Empresa $empresa
 * @property int $usuario_id
 * @property \App\Model\Entity\Usuario $usuario
 * @property int $perfil_id
 * @property \App\Model\Entity\Perfil $perfil
 * @property \Cake\I18n\Time $validade
 */
class EmpresasUsuario extends Entity
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
        //'empresa_id' => false,
        //'usuario_id' => false,
        //'perfil_id' => false,
    ];
}
