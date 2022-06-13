<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CodigoBarra Entity
 *
 * @property int $id
 * @property string $descricao
 * @property string|null $valor_codigo_barras
 * @property string|null $header
 * @property string|null $footer
 * @property int $codigo_barra_tipo_id
 *
 * @property \App\Model\Entity\CodigoBarraTipo $codigo_barra_tipo
 */
class CodigoBarra extends Entity
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
        'valor_codigo_barras' => true,
        'header' => true,
        'footer' => true,
        'codigo_barra_tipo_id' => true,
        'codigo_barra_tipo' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
