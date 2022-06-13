<?php
namespace App\Model\Entity;

use App\RegraNegocio\GerenciamentoEstoque\ProdutosControlados;
use App\Util\EntityUtil;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * OrdemServicoInternaEtiqueta Entity
 *
 * @property int $id
 * @property int $ordem_servico_id
 * @property int $qtde_leituras
 * @property string $codigo_barras_etiqueta
 * @property string|null $lote_codigo
 * @property string|null $lote_item
 * @property float $qtde
 * @property float $peso
 * @property float $m2
 * @property float $m3
 * @property string|null $lote
 * @property string|null $serie
 * @property \Cake\I18n\Time|null $validade
 * @property int $unidade_medida_id
 * @property int $endereco_id
 * @property int $empresa_id
 * @property int|null $produto_id
 * @property \Cake\I18n\Time $created_at
 * @property \Cake\I18n\Time|null $updated_at
 *
 * @property \App\Model\Entity\OrdemServico $ordem_servico
 * @property \App\Model\Entity\UnidadeMedida $unidade_medida
 * @property \App\Model\Entity\Endereco $endereco
 * @property \App\Model\Entity\Estoque $estoque
 * @property \App\Model\Entity\Empresa $empresa
 * @property \App\Model\Entity\Produto $produto
 */
class OrdemServicoInternaEtiqueta extends Entity
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
        'qtde_leituras' => true,
        'codigo_barras_etiqueta' => true,
        'lote_codigo' => true,
        'lote_item' => true,
        'qtde' => true,
        'peso' => true,
        'm2' => true,
        'm3' => true,
        'lote' => true,
        'serie' => true,
        'validade' => true,
        'unidade_medida_id' => true,
        'endereco_id' => true,
        'empresa_id' => true,
        'produto_id' => true,
        'created_at' => true,
        'updated_at' => true,
        'ordem_servico' => true,
        'unidade_medida' => true,
        'endereco' => true,
        'estoque' => true,
        'empresa' => true,
        'produto' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function desbloqueiaEstoquesByEtiqueta($oOSEtiqueta, $bConsideraLoteDocumental)
    {
        $aConditions = ProdutosControlados::getProdutoControlesValuesToQuery($oOSEtiqueta, false, false, $bConsideraLoteDocumental);

        $oEstoqueEndereco = TableRegistry::get('EstoqueEnderecos')->find()
            ->where($aConditions + [
                'status_estoque_id' => EntityUtil::getIdByParams('StatusEstoques', 'descricao', 'BLOQUEADO'),
                'endereco_id' => $oOSEtiqueta->endereco_id,
                'qtde_saldo >= ' . $oOSEtiqueta->qtde
            ])
            ->order('qtde_saldo ASC')
            ->first();

        if ($oEstoqueEndereco) {
            $oEstoqueEndereco->status_estoque_id = EntityUtil::getIdByParams('StatusEstoques', 'descricao', 'OK');
            TableRegistry::get('EstoqueEnderecos')->save($oEstoqueEndereco);
        }
        
    }
}
