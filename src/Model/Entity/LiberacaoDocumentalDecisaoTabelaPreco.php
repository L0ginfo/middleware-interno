<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * LiberacaoDocumentalDecisaoTabelaPreco Entity
 *
 * @property int $id
 * @property int $liberacao_documental_id
 * @property int $tabela_preco_id
 * @property string $tipo_vinculo
 *
 * @property \App\Model\Entity\LiberacaoDocumental $liberacao_documental
 * @property \App\Model\Entity\TabelaPreco $tabela_preco
 */
class LiberacaoDocumentalDecisaoTabelaPreco extends Entity
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
        
        'liberacao_documental_id' => true,
        'tabela_preco_id' => true,
        'tipo_vinculo' => true,
        'liberacao_documental' => true,
        'tabela_preco' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
