<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * SeparacaoCargaItem Entity
 *
 * @property int $id
 * @property float $qtde
 * @property int $produto_id
 * @property int $separacao_carga_id
 * @property \Cake\I18n\Time $created_at
 * @property \Cake\I18n\Time|null $updated_at
 *
 * @property \App\Model\Entity\Produto $produto
 * @property \App\Model\Entity\SeparacaoCarga $separacao_carga
 */
class SeparacaoCargaItem extends Entity
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
        
        'qtde' => true,
        'produto_id' => true,
        'separacao_carga_id' => true,
        'created_at' => true,
        'updated_at' => true,
        'produto' => true,
        'separacao_carga' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function getFilters()
    {
        return [
            [
                'name'  => 'produto_codigo',
                'divClass' => 'col-lg-2',
                'label' => 'Produto Código',
                'table' => [
                    'className' => 'Produtos',
                    'field'     => 'codigo',
                    'operacao'  => 'contem'
                ]
            ],
            [
                'name'  => 'produto_descricao',
                'divClass' => 'col-lg-2',
                'label' => 'Produto Descrição',
                'table' => [
                    'className' => 'Produtos',
                    'field'     => 'descricao',
                    'operacao'  => 'contem'
                ]
            ], [
                'name'  => 'numero_pedido',
                'divClass' => 'col-lg-2',
                'label' => 'Número Pedido',
                'table' => [
                    'className' => 'SeparacaoCargas',
                    'field'     => 'numero_pedido',
                    'operacao'  => 'contem'
                ]
            ]
        ];
    }
}
