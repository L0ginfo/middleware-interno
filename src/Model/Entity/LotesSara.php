<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * LotesSara Entity.
 *
 * @property int $id
 * @property string $cd_instituicao
 * @property string $nome
 * @property string $cnpj
 * @property string $ativo
 * @property int $usuario_id
 * @property \App\Model\Entity\Usuario $usuario
 * @property \Cake\I18n\Time $data_desativacao
 * @property string $motivo_desativacao
 */
class LotesSara extends Entity
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
        'cod_cliente' => false,
    ];
}
