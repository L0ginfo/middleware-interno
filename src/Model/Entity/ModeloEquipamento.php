<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ModeloEquipamento Entity
 *
 * @property int $id
 * @property string $descricao
 * @property string|null $versao
 * @property string|null $serie
 * @property string|null $codigo
 *
 * @property \App\Model\Entity\ControleAcessoControladora[] $controle_acesso_controladoras
 * @property \App\Model\Entity\ControleAcessoEquipamento[] $controle_acesso_equipamentos
 */
class ModeloEquipamento extends Entity
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
        'versao' => true,
        'serie' => true,
        'codigo' => true,
        'controle_acesso_controladoras' => true,
        'controle_acesso_equipamentos' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
