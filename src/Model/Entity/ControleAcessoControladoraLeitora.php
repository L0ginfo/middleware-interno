<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ControleAcessoControladoraLeitora Entity
 *
 * @property int $id
 * @property int $controle_acesso_controladora_id
 * @property int $controle_acesso_equipamento_id
 *
 * @property \App\Model\Entity\ControleAcessoControladora $controle_acesso_controladora
 * @property \App\Model\Entity\ControleAcessoEquipamento $controle_acesso_equipamento
 */
class ControleAcessoControladoraLeitora extends Entity
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
        
        'controle_acesso_controladora_id' => true,
        'controle_acesso_equipamento_id' => true,
        'controle_acesso_controladora' => true,
        'controle_acesso_equipamento' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
