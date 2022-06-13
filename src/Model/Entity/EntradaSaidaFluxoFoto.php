<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * EntradaSaidaFluxoFoto Entity
 *
 * @property int $id
 * @property int $entrada_saida_fluxo_id
 * @property string|null $tipo
 * @property string|null $placa
 * @property string $foto
 * @property \Cake\I18n\Time|null $data_registro
 *
 * @property \App\Model\Entity\EntradaSaidaFluxo $entrada_saida_fluxo
 */
class EntradaSaidaFluxoFoto extends Entity
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
        
        'entrada_saida_fluxo_id' => true,
        'tipo' => true,
        'placa' => true,
        'foto' => true,
        'data_registro' => true,
        'entrada_saida_fluxo' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
