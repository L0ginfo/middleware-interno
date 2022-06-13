<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * OrdemServicoDocumentoRegimeEspecialItem Entity
 *
 * @property int $id
 * @property string|null $lote_codigo
 * @property string|null $lote_item
 * @property int $sequencia_item
 * @property float $quantidade
 * @property float $peso
 * @property float $temperatura
 * @property float $m2
 * @property float $m3
 * @property int $ordem_servico_id
 * @property int|null $documento_regime_especial_adicao_item_id
 * @property int $unidade_medida_id
 * @property int|null $embalagem_id
 * @property int|null $produto_id
 * @property string|null $lote
 * @property string|null $serie
 * @property \Cake\I18n\Time|null $validade
 * @property int|null $endereco_id
 * @property int|null $status_estoque_id
 * @property int|null $container_id
 * @property int|null $entrada_saida_container_id
 * @property int|null $controle_especifico_id
 *
 * @property \App\Model\Entity\OrdemServico $ordem_servico
 * @property \App\Model\Entity\DocumentoRegimeEspecialAdicaoItem $documento_regime_especial_adicao_item
 * @property \App\Model\Entity\UnidadeMedida $unidade_medida
 * @property \App\Model\Entity\Embalagem $embalagem
 * @property \App\Model\Entity\Produto $produto
 * @property \App\Model\Entity\Endereco $endereco
 * @property \App\Model\Entity\StatusEstoque $status_estoque
 * @property \App\Model\Entity\Container $container
 * @property \App\Model\Entity\EntradaSaidaContainer $entrada_saida_container
 * @property \App\Model\Entity\ControleEspecifico $controle_especifico
 */
class OrdemServicoDocumentoRegimeEspecialItem extends Entity
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
        
        'lote_codigo' => true,
        'lote_item' => true,
        'sequencia_item' => true,
        'quantidade' => true,
        'peso' => true,
        'temperatura' => true,
        'm2' => true,
        'm3' => true,
        'ordem_servico_id' => true,
        'documento_regime_especial_adicao_item_id' => true,
        'unidade_medida_id' => true,
        'embalagem_id' => true,
        'produto_id' => true,
        'lote' => true,
        'serie' => true,
        'validade' => true,
        'endereco_id' => true,
        'status_estoque_id' => true,
        'container_id' => true,
        'entrada_saida_container_id' => true,
        'controle_especifico_id' => true,
        'ordem_servico' => true,
        'documento_regime_especial_adicao_item' => true,
        'unidade_medida' => true,
        'embalagem' => true,
        'produto' => true,
        'endereco' => true,
        'status_estoque' => true,
        'container' => true,
        'entrada_saida_container' => true,
        'controle_especifico' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
