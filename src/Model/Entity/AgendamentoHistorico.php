<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AgendamentoHistorico Entity.
 *
 * @property int $id
 * @property int $agendamento_id
 * @property \App\Model\Entity\Agendamento $agendamento
 * @property int $usuario_id
 * @property \App\Model\Entity\Usuario $usuario
 * @property \Cake\I18n\Time $data
 * @property string $descricao
 * @property int $situacao_alterada
 */
class AgendamentoHistorico extends Entity
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
