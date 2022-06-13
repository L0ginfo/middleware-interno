<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AcessosPessoa Entity
 *
 * @property int $id
 * @property int $pessoa_id
 * @property int $empresa_id
 * @property int $resv_id
 * @property \Cake\I18n\Time $data_hora_entrada
 * @property \Cake\I18n\Time|null $data_hora_saida
 *
 * @property \App\Model\Entity\Pessoa $pessoa
 * @property \App\Model\Entity\Empresa $empresa
 * @property \App\Model\Entity\Resv $resv
 */
class AcessosPessoa extends Entity
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
        'pessoa_id' => true,
        'empresa_id' => true,
        'resv_id' => true,
        'data_hora_entrada' => true,
        'data_hora_saida' => true,
        'pessoa' => true,
        'empresa' => true,
        'resv' => true
    ];
}
