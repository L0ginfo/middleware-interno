<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * IntegracaoTraducao Entity
 *
 * @property int $id
 * @property int $integracao_id
 * @property array $nested_json_translate
 * @property string $observacao
 *
 * @property \App\Model\Entity\Integracao $integracao
 * @property \App\Model\Entity\IntegracaoLog[] $integracao_logs
 */
class IntegracaoTraducao extends Entity
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
     /* Default fields

        'integracao_id' => true,
        'nested_json_translate' => true,
        'observacao' => true,
        'integracao' => true,
        'integracao_logs' => true,

     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
