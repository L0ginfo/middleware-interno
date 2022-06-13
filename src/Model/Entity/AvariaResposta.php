<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AvariaResposta Entity
 *
 * @property int $id
 * @property string|null $descricao
 * @property int|null $avaria_id
 *
 * @property \App\Model\Entity\Avaria $avaria
 * @property \App\Model\Entity\VistoriaAvariaResposta[] $vistoria_avaria_respostas
 */
class AvariaResposta extends Entity
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
        'avaria_id' => true,
        'avaria' => true,
        'vistoria_avaria_respostas' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
