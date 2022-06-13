<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Porao Entity
 *
 * @property int $id
 * @property string|null $descricao
 *
 * @property \App\Model\Entity\PlanoCargaPorao[] $plano_carga_poroes
 */
class Porao extends Entity
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
        'plano_carga_poroes' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];


    public function getCondicaoPlanoCargaPoroes(){
        return !empty($this->plano_carga_porao_condicoes) ? $this->plano_carga_porao_condicoes[0]: null;
    } 
}
