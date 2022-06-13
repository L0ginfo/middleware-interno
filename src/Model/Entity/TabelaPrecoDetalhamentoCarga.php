<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * TabelaPrecoDetalhamentoCarga Entity
 *
 * @property int $id
 * @property int|null $tabela_preco_id
 * @property int|null $detalhamento_carga_id
 *
 * @property \App\Model\Entity\TabelasPreco $tabelas_preco
 * @property \App\Model\Entity\DetalhamentoCarga $detalhamento_carga
 */
class TabelaPrecoDetalhamentoCarga extends Entity
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
        
        'tabela_preco_id' => true,
        'detalhamento_carga_id' => true,
        'tabelas_preco' => true,
        'detalhamento_carga' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
