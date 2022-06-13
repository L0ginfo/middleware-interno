<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Balanca Entity
 *
 * @property int $id
 * @property string $descricao
 * @property string $codigo
 * @property int $tipo_balanca_id
 * @property int $portaria_id
 *
 * @property \App\Model\Entity\TipoBalanca $tipo_balanca
 * @property \App\Model\Entity\Portaria $portaria
 * @property \App\Model\Entity\Cancela[] $cancelas
 * @property \App\Model\Entity\EntradaSaidaFluxo[] $entrada_saida_fluxos
 * @property \App\Model\Entity\PesagemVeiculoRegistro[] $pesagem_veiculo_registros
 */
class Balanca extends Entity
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
        'tipo_balanca_id' => true,
        'portaria_id' => true,
        'tipo_balanca' => true,
        'portaria' => true,
        'cancelas' => true,
        'entrada_saida_fluxos' => true,
        'pesagem_veiculo_registros' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
