<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Servico Entity
 *
 * @property int $id
 * @property string $descricao
 *
 * @property \App\Model\Entity\TabelasPrecosPeriodosArm[] $tabelas_precos_periodos_arms
 * @property \App\Model\Entity\TabelasPreco[] $tabelas_precos
 */
class Servico extends Entity
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
        'codigo' => true,
        'codigo_2' => true,
        'tabelas_precos_periodos_arms' => true,
        'tabelas_precos' => true
    ];
}
