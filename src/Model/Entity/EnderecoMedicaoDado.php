<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * EnderecoMedicaoDado Entity
 *
 * @property int $id
 * @property int $endereco_medicao_id
 * @property int $endereco_id
 * @property float $area_m2
 * @property float $volume_m3
 *
 * @property \App\Model\Entity\EnderecoMedicao $endereco_medicao
 * @property \App\Model\Entity\Endereco $endereco
 */
class EnderecoMedicaoDado extends Entity
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
        
        'endereco_medicao_id' => true,
        'endereco_id' => true,
        'area_m2' => true,
        'volume_m3' => true,
        'endereco_medicao' => true,
        'endereco' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
