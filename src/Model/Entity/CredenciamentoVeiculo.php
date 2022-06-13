<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CredenciamentoVeiculo Entity
 *
 * @property int $id
 * @property \Cake\I18n\Time|null $data_inicio_acesso
 * @property \Cake\I18n\Time|null $data_fim_acesso
 * @property int $ativo
 * @property int|null $empresa_id
 * @property int|null $veiculo_id
 *
 * @property \App\Model\Entity\Empresa $empresa
 * @property \App\Model\Entity\Veiculo $veiculo
 * @property \App\Model\Entity\PessoaVeiculo[] $pessoa_veiculos
 */
class CredenciamentoVeiculo extends Entity
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
        
        'data_inicio_acesso' => true,
        'data_fim_acesso' => true,
        'ativo' => true,
        'empresa_id' => true,
        'veiculo_id' => true,
        'empresa' => true,
        'veiculo' => true,
        'pessoa_veiculos' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
