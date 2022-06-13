<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * DetalhamentoCarga Entity
 *
 * @property int $id
 * @property string $descricao
 * @property string|null $codigo
 *
 * @property \App\Model\Entity\TabelaPrecoDetalhamentoCarga[] $tabela_preco_detalhamento_cargas
 */
class DetalhamentoCarga extends Entity
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
        'codigo' => true,
        'tabela_preco_detalhamento_cargas' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
