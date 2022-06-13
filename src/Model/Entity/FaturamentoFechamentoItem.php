<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * FaturamentoFechamentoItem Entity
 *
 * @property int $id
 * @property int $faturamento_fechamento_id
 * @property int $faturamento_id
 * @property int $created_by
 * @property \Cake\I18n\Time $created
 * @property int|null $updated_by
 * @property \Cake\I18n\Time|null $updated
 *
 * @property \App\Model\Entity\FaturamentoFechamento $faturamento_fechamento
 * @property \App\Model\Entity\Faturamento $faturamento
 */
class FaturamentoFechamentoItem extends Entity
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
        'faturamento_fechamento_id' => true,
        'faturamento_id' => true,
        'created_by' => true,
        'created' => true,
        'updated_by' => true,
        'updated' => true,
        'faturamento_fechamento' => true,
        'faturamento' => true,
    ];
}
