<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * FormacaoLoteItem Entity
 *
 * @property int $id
 * @property int $formacao_lote_id
 * @property string|null $lote_codigo
 * @property string|null $lote_item
 * @property int|null $sequencia_item
 * @property float|null $quantidade
 * @property float|null $peso
 * @property float|null $temperatura
 * @property float|null $m2
 * @property float|null $m3
 * @property int|null $ordem_servico_id
 * @property int|null $unidade_medida_id
 * @property int|null $documento_mercadoria_item_id
 * @property int|null $embalagem_id
 * @property int|null $produto_id
 * @property string|null $lote
 * @property string|null $serie
 * @property \Cake\I18n\Time|null $validade
 * @property int|null $endereco_id
 * @property int|null $status_estoque_id
 *
 * @property \App\Model\Entity\FormacaoLote $formacao_lote
 * @property \App\Model\Entity\OrdemServico $ordem_servico
 * @property \App\Model\Entity\UnidadeMedida $unidade_medida
 * @property \App\Model\Entity\DocumentosMercadoriasItem $documentos_mercadorias_item
 * @property \App\Model\Entity\Embalagem $embalagem
 * @property \App\Model\Entity\Produto $produto
 * @property \App\Model\Entity\Endereco $endereco
 * @property \App\Model\Entity\StatusEstoque $status_estoque
 */
class FormacaoLoteItem extends Entity
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
        
        'formacao_lote_id' => true,
        'lote_codigo' => true,
        'lote_item' => true,
        'sequencia_item' => true,
        'quantidade' => true,
        'peso' => true,
        'temperatura' => true,
        'm2' => true,
        'm3' => true,
        'ordem_servico_id' => true,
        'unidade_medida_id' => true,
        'documento_mercadoria_item_id' => true,
        'embalagem_id' => true,
        'produto_id' => true,
        'lote' => true,
        'serie' => true,
        'validade' => true,
        'endereco_id' => true,
        'status_estoque_id' => true,
        'formacao_lote' => true,
        'ordem_servico' => true,
        'unidade_medida' => true,
        'documentos_mercadorias_item' => true,
        'embalagem' => true,
        'produto' => true,
        'endereco' => true,
        'status_estoque' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
