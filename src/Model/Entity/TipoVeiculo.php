<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * TipoVeiculo Entity
 *
 * @property int $id
 * @property string|null $codigo
 * @property string|null $descricao
 * @property int|null $modal_id
 *
 * @property \App\Model\Entity\Modal $modal
 * @property \App\Model\Entity\Veiculo[] $veiculos
 */
class TipoVeiculo extends Entity
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
        
        'codigo' => true,
        'descricao' => true,
        'modal_id' => true,
        'modal' => true,
        'veiculos' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
