<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ParalisacaoMotivo Entity
 *
 * @property int $id
 * @property string|null $descricao
 * @property string|null $descricao_ingles
 * @property \Cake\I18n\Time $created_at
 * @property \Cake\I18n\Time|null $updated_at
 * @property string|null $codigo
 *
 * @property \App\Model\Entity\Paralisacao[] $paralisacoes
 */
class ParalisacaoMotivo extends Entity
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
        'descricao_ingles' => true,
        'created_at' => true,
        'updated_at' => true,
        'codigo' => true,
        'paralisacoes' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
