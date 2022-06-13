<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * EstoqueEnderecoApontamento Entity
 *
 * @property int $id
 * @property int $ordem_servico_id
 * @property int $produto_id
 * @property int $produto_final_id
 * @property int $unidade_medida_id
 * @property int $unidade_medida_final_id
 * @property int $endereco_id
 * @property string|null $lote_codigo
 * @property string|null $lote_item
 * @property float $qtde_saldo
 * @property float $peso_saldo
 * @property float $m2_saldo
 * @property float $m3_saldo
 * @property string|null $lote
 * @property string|null $serie
 * @property \Cake\I18n\Time|null $validade
 * @property \Cake\I18n\Time $created_at
 * @property \Cake\I18n\Time|null $updated_at
 *
 * @property \App\Model\Entity\OrdemServico $ordem_servico
 * @property \App\Model\Entity\Produto $produto
 * @property \App\Model\Entity\UnidadeMedida $unidade_medida
 * @property \App\Model\Entity\Endereco $endereco
 */
class EstoqueEnderecoApontamento extends Entity
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
        
        'ordem_servico_id' => true,
        'produto_id' => true,
        'produto_final_id' => true,
        'unidade_medida_id' => true,
        'unidade_medida_final_id' => true,
        'endereco_id' => true,
        'lote_codigo' => true,
        'lote_item' => true,
        'qtde_saldo' => true,
        'peso_saldo' => true,
        'm2_saldo' => true,
        'm3_saldo' => true,
        'lote' => true,
        'serie' => true,
        'validade' => true,
        'created_at' => true,
        'updated_at' => true,
        'ordem_servico' => true,
        'produto' => true,
        'unidade_medida' => true,
        'endereco' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
