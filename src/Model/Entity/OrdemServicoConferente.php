<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * OrdemServicoConferente Entity
 *
 * @property int $id
 * @property int|null $ordem_servico_id
 * @property int|null $conferente_id
 * @property int $create_by
 *
 * @property \App\Model\Entity\OrdemServico $ordem_servico
 * @property \App\Model\Entity\Usuario $usuario
 */
class OrdemServicoConferente extends Entity
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
        
        'ordem_servico_id' => true,
        'conferente_id' => true,
        'create_by' => true,
        'ordem_servico' => true,
        'usuario' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
