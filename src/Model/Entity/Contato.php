<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Contato Entity
 *
 * @property int $id
 * @property string $descricao
 * @property \Cake\I18n\Date|null $data_nascimento
 * @property string|null $telefone
 * @property string|null $celular
 * @property string|null $email
 * @property int|null $cargo_id
 *
 * @property \App\Model\Entity\Cargo $cargo
 * @property \App\Model\Entity\EmpresaContato[] $empresa_contatos
 */
class Contato extends Entity
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
        'data_nascimento' => true,
        'telefone' => true,
        'celular' => true,
        'email' => true,
        'cargo_id' => true,
        'cargo' => true,
        'empresa_contatos' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
