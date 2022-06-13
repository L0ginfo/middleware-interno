<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * TabelaPrecoObjetivoImportacao Entity
 *
 * @property int $id
 * @property int|null $tabela_preco_id
 * @property int|null $objetivo_importacao_id
 *
 * @property \App\Model\Entity\TabelasPreco $tabelas_preco
 * @property \App\Model\Entity\ObjetivoImportacao $objetivo_importacao
 */
class TabelaPrecoObjetivoImportacao extends Entity
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
        'objetivo_importacao_id' => true,
        'tabelas_preco' => true,
        'objetivo_importacao' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
