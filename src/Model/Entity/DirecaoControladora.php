<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * DirecaoControladora Entity
 *
 * @property int $id
 * @property string $descricao
 *
 * @property \App\Model\Entity\ControleAcessoControladora[] $controle_acesso_controladoras
 * @property \App\Model\Entity\ControleAcessoLog[] $controle_acesso_logs
 */
class DirecaoControladora extends Entity
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
        'controle_acesso_controladoras' => true,
        'controle_acesso_logs' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
