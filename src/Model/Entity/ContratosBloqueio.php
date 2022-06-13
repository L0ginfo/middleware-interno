<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ContratosBloqueio Entity.
 *
 * @property int $id
 * @property int $instituicoes_financeira_id
 * @property string $nr_contrato
 * @property \Cake\I18n\Time $dt_contrato
 * @property string $cliente_id
 * @property \App\Model\Entity\Cliente $cliente
 * @property string $email_aviso
 * @property string $ativo
 * @property int $usuario_desativacao_id
 * @property \App\Model\Entity\UsuarioDesativacao $usuario_desativacao
 * @property \Cake\I18n\Time $dt_desativacao
 * @property string $motivo_desativacao
 * @property \App\Model\Entity\InstituicaoFinanceira $instituicao_financeira
 */
class ContratosBloqueio extends Entity
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
