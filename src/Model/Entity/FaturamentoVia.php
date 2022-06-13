<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * FaturamentoVia Entity
 *
 * @property int $id
 * @property int|null $faturamento_id
 * @property int|null $numero_via
 * @property \Cake\I18n\Time|null $data_hora_emissao
 * @property \Cake\I18n\Time|null $created_at
 * @property \Cake\I18n\Time|null $modified_at
 *
 * @property \App\Model\Entity\Faturamento $faturamento
 */
class FaturamentoVia extends Entity
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
        
        'faturamento_id' => true,
        'numero_via' => true,
        'data_hora_emissao' => true,
        'created_at' => true,
        'modified_at' => true,
        'faturamento' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
