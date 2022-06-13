<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * TabPrecosValidaPerArm Entity
 *
 * @property int $id
 * @property int $tab_preco_per_arm_id
 * @property int $campo_sistema_id
 * @property int $operador_id
 * @property string $valor_inicio
 * @property string $valor_final
 *
 * @property \App\Model\Entity\TabelasPrecosPeriodosArm $tabelas_precos_periodos_arm
 * @property \App\Model\Entity\SistemaCampo $sistema_campo
 * @property \App\Model\Entity\Operadore $operadore
 */
class TabPrecosValidaPerArm extends Entity
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
        'tab_preco_per_arm_id' => true,
        'campo_sistema_id' => true,
        'operador_id' => true,
        'valor_inicio' => true,
        'valor_final' => true,
        'tabelas_precos_periodos_arm' => true,
        'sistema_campo' => true,
        'operadore' => true
    ];
}
