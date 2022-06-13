<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * EntradaSaidaFluxo Entity
 *
 * @property int $id
 * @property int|null $passagem_id
 * @property int $cancela_entrada_id
 * @property int $cancela_saida_id
 * @property \Cake\I18n\Time|null $data_hora_entrada
 * @property \Cake\I18n\Time|null $data_hora_saida
 * @property int|null $updated_by
 * @property int|null $programacao_id
 * @property int|null $balanca_entrada_id
 * @property int|null $balanca_saida_id
 * @property string|null $tipo_fluxo_entrada
 * @property string|null $tipo_fluxo_saida
 * @property string|null $tipo_entrada
 * @property string|null $tipo_saida
 *
 * @property \App\Model\Entity\Passagem $passagem
 * @property \App\Model\Entity\Cancela $cancela_entrada
 * @property \App\Model\Entity\Cancela $cancela_saida
 * @property \App\Model\Entity\Programacao $programacao
 * @property \App\Model\Entity\Balanca $balanca
 * @property \App\Model\Entity\EntradaSaidaFluxoFoto[] $entrada_saida_fluxo_fotos
 */
class EntradaSaidaFluxo extends Entity
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
        
        'passagem_id' => true,
        'cancela_entrada_id' => true,
        'cancela_saida_id' => true,
        'data_hora_entrada' => true,
        'data_hora_saida' => true,
        'updated_by' => true,
        'programacao_id' => true,
        'balanca_entrada_id' => true,
        'balanca_saida_id' => true,
        'tipo_fluxo_entrada' => true,
        'tipo_fluxo_saida' => true,
        'tipo_entrada' => true,
        'tipo_saida' => true,
        'passagem' => true,
        'cancela_entrada' => true,
        'cancela_saida' => true,
        'programacao' => true,
        'balanca' => true,
        'entrada_saida_fluxo_fotos' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
