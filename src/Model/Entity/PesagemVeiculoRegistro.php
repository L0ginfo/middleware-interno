<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PesagemVeiculoRegistro Entity
 *
 * @property int $id
 * @property float|null $peso
 * @property int|null $manual
 * @property string|null $balanca_codigo
 * @property string|null $balanca_id
 * @property int $pesagem_veiculo_id
 * @property int $pesagem_tipo_id
 * @property int $pesagem_id
 * @property \Cake\I18n\Time $created_at
 * @property \Cake\I18n\Time|null $updated_at
 *
 * @property \App\Model\Entity\Balanca $balanca
 * @property \App\Model\Entity\PesagemVeiculo $pesagem_veiculo
 * @property \App\Model\Entity\PesagemTipo $pesagem_tipo
 * @property \App\Model\Entity\Pesagem $pesagem
 */
class PesagemVeiculoRegistro extends Entity
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
        
        'peso' => true,
        'manual' => true,
        'balanca_codigo' => true,
        'balanca_id' => true,
        'pesagem_veiculo_id' => true,
        'pesagem_tipo_id' => true,
        'pesagem_id' => true,
        'created_at' => true,
        'updated_at' => true,
        'balanca' => true,
        'pesagem_veiculo' => true,
        'pesagem_tipo' => true,
        'pesagem' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
