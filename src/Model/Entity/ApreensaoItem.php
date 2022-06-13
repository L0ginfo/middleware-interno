<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ApreensaoItem Entity
 *
 * @property int $id
 * @property string $descricao
 * @property int $sequencia
 * @property int|null $apreensao_id
 * @property int|null $ncm_id
 * @property int|null $unidade_medida_id
 * @property float $quantidade
 * @property float $valor_unitario_moeda
 * @property float $valor_total
 *
 * @property \App\Model\Entity\Ncm $ncm
 * @property \App\Model\Entity\UnidadeMedida $unidade_medida
 */
class ApreensaoItem extends Entity
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
        'sequencia' => true,
        'apreensao_id' => true,
        'ncm_id' => true,
        'unidade_medida_id' => true,
        'quantidade' => true,
        'valor_unitario_moeda' => true,
        'valor_total' => true,
        'ncm' => true,
        'unidade_medida' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
