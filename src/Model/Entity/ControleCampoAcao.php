<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ControleCampoAcao Entity
 *
 * @property int $id
 * @property int|null $controle_campo_id
 * @property string|null $action
 * @property int $ativo
 *
 * @property \App\Model\Entity\ControleCampo $controle_campo
 * @property \App\Model\Entity\Perfil[] $perfis
 */
class ControleCampoAcao extends Entity
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
        
        'controle_campo_id' => true,
        'action' => true,
        'ativo' => true,
        'controle_campo' => true,
        'perfis' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
