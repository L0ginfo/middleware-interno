<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * HistoricoSeparacaoCarga Entity
 *
 * @property int $id
 * @property string|null $codigo_pedido
 * @property string|null $numero_pedido
 * @property int $separacao_carga_id
 * @property int $cliente_id
 * @property \Cake\I18n\Time|null $data_recepcao
 * @property string $separacao_situacao
 * @property \Cake\I18n\Time|null $created_at_original
 * @property \Cake\I18n\Time|null $updated_at_original
 * @property \Cake\I18n\Date|null $date_created
 * @property \Cake\I18n\Time $created_at
 * @property \Cake\I18n\Time|null $updated_at
 *
 * @property \App\Model\Entity\SeparacaoCarga $separacao_carga
 * @property \App\Model\Entity\Empresa $empresa
 */
class HistoricoSeparacaoCarga extends Entity
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
        
        'codigo_pedido' => true,
        'numero_pedido' => true,
        'separacao_carga_id' => true,
        'cliente_id' => true,
        'data_recepcao' => true,
        'separacao_situacao' => true,
        'created_at_original' => true,
        'updated_at_original' => true,
        'date_created' => true,
        'created_at' => true,
        'updated_at' => true,
        'separacao_carga' => true,
        'empresa' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
