<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ImportacaoEstoque Entity
 *
 * @property int $id
 * @property string|null $endereco_id
 * @property string|null $conhecimento
 * @property string|null $navio_viagem
 * @property int|null $produto_id
 * @property string|null $produto_descricao
 * @property string|null $produto_codigo
 * @property int|null $empresa_id
 * @property string|null $empresa_descricao
 * @property string|null $empresa_codigo
 * @property string|null $empresa_cnpj
 * @property string|null $data_entrada
 * @property float|null $qtde_saldo
 * @property float|null $saldo_coberto
 *
 * @property \App\Model\Entity\Endereco $endereco
 * @property \App\Model\Entity\Produto $produto
 * @property \App\Model\Entity\Empresa $empresa
 */
class ImportacaoEstoque extends Entity
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
        
        'endereco_id' => true,
        'conhecimento' => true,
        'navio_viagem' => true,
        'produto_id' => true,
        'produto_descricao' => true,
        'produto_codigo' => true,
        'empresa_id' => true,
        'empresa_descricao' => true,
        'empresa_codigo' => true,
        'empresa_cnpj' => true,
        'data_entrada' => true,
        'qtde_saldo' => true,
        'saldo_coberto' => true,
        'endereco' => true,
        'produto' => true,
        'empresa' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
