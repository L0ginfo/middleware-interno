<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ObjetivoImportacao Entity
 *
 * @property int $id
 * @property string $descricao
 * @property string|null $codigo
 *
 * @property \App\Model\Entity\TabelaPrecoObjetivoImportacao[] $tabela_preco_objetivo_importacoes
 */
class ObjetivoImportacao extends Entity
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
        'tabela_preco_objetivo_importacoes' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
