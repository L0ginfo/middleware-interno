<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CodigoBarraTipo Entity
 *
 * @property int $id
 * @property string $descricao
 * @property int $dimensao_tipo
 * @property string $tipo_codigo
 *
 * @property \App\Model\Entity\CodigoBarra[] $codigo_barras
 */
class CodigoBarraTipo extends Entity
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
        
        'descricao' => true,
        'dimensao_tipo' => true,
        'tipo_codigo' => true,
        'codigo_barras' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
