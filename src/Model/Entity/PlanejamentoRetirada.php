<?php
namespace App\Model\Entity;

use App\RegraNegocio\GerenciamentoEstoque\ProdutosControlados;
use App\Util\LgDbUtil;
use App\Util\ObjectUtil;
use App\Util\ResponseUtil;
use Cake\ORM\Entity;

/**
 * PlanejamentoRetirada Entity
 *
 * @property int $id
 * @property string|null $lote_codigo
 * @property string|null $lote_item
 * @property float $qtde_saldo
 * @property float $peso_saldo
 * @property float $m2_saldo
 * @property float $m3_saldo
 * @property string|null $lote
 * @property string|null $serie
 * @property \Cake\I18n\Time|null $validade
 * @property int $unidade_medida_id
 * @property int $endereco_id
 * @property int|null $produto_id
 * @property int|null $usuario_created_id
 * @property \Cake\I18n\Time $created_at
 * @property \Cake\I18n\Time|null $updated_at
 * @property int $status_estoque_id
 *
 * @property \App\Model\Entity\UnidadeMedida $unidade_medida
 * @property \App\Model\Entity\Endereco $endereco
 * @property \App\Model\Entity\Produto $produto
 * @property \App\Model\Entity\Usuario $usuario
 * @property \App\Model\Entity\StatusEstoque $status_estoque
 */
class PlanejamentoRetirada extends Entity
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
        'qtde_saldo' => true,
        'peso_saldo' => true,
        'm2_saldo' => true,
        'm3_saldo' => true,
        'lote' => true,
        'serie' => true,
        'validade' => true,
        'unidade_medida_id' => true,
        'endereco_id' => true,
        'produto_id' => true,
        'usuario_created_id' => true,
        'created_at' => true,
        'updated_at' => true,
        'status_estoque_id' => true,
        'unidade_medida' => true,
        'endereco' => true,
        'produto' => true,
        'usuario' => true,
        'status_estoque' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function save($oThat)
    {
        $oResponse = new ResponseUtil;
        $aData = $oThat->request->getData();

        if (!$aData)
            return $oResponse;

        $aData = array_pop($aData['estoque_endereco']);
        
        $oEstoqueEndereco = LgDbUtil::getFirst('EstoqueEnderecos', [
            'EstoqueEnderecos.id' => $aData['estoque_endereco_id']
        ]);

        $oPlanejamentoRetirada = LgDbUtil::getFirst('PlanejamentoRetiradas', 
            ProdutosControlados::getProdutoControlesValuesToQuery($oEstoqueEndereco)
        );

        if ($oPlanejamentoRetirada) {
            $oPlanejamentoRetirada->prioridade = $aData['prioridade'];
            $oPlanejamentoRetirada = LgDbUtil::save('PlanejamentoRetiradas', $oPlanejamentoRetirada, true);
        }else {
            $aDataSave = ObjectUtil::getAsObject($oEstoqueEndereco, true);
            unset($aDataSave['created_at']);
            $aDataSave['prioridade'] = $aData['prioridade'];
            $aDataSave['usuario_created_id'] = @$_SESSION['Auth']['User']['id'];
            $oPlanejamentoRetirada = LgDbUtil::saveNew('PlanejamentoRetiradas', $aDataSave, true);
        }

        return $oResponse->setStatus(200)->setMessage('Sucesso!');
    }

    public static function getFilters()
    {
        return [
            [
                'name'  => 'arm',
                'divClass' => 'col-lg-1',
                'label' => 'Armazém',
                'table' => [
                    'className' => 'Enderecos',
                    'field'     => 'cod_composicao1',
                    'operacao'  => 'igual'
                ],
            ],
            [
                'name'  => 'box',
                'divClass' => 'col-lg-1',
                'label' => 'Box',
                'table' => [
                    'className' => 'Enderecos',
                    'field'     => 'cod_composicao2',
                    'operacao'  => 'igual'
                ],
            ],
            [
                'name'  => 'prod',
                'divClass' => 'col-lg-2',
                'label' => 'Produto Desc.',
                'table' => [
                    'className' => 'Produtos',
                    'field'     => 'descricao',
                    'operacao'  => 'contem'
                ],
            ],
            [
                'name'  => 'navio',
                'divClass' => 'col-lg-2',
                'label' => 'Navio',
                'table' => [
                    'className' => 'EstoqueEnderecos.DocumentosMercadoriasLote.DocumentosTransportes',
                    'field'     => 'navio_aeronave',
                    'operacao'  => 'contem'
                ]
            ],
            [
                'name'  => 'cliente',
                'divClass' => 'col-lg-2',
                'label' => 'Cliente',
                'table' => [
                    'className' => 'EstoqueEnderecos.DocumentosMercadoriasLote.Clientes',
                    'field'     => 'descricao',
                    'operacao'  => 'contem'
                ]
            ],
            [
                'name'  => 'prio',
                'divClass' => 'col-lg-2',
                'label' => 'Prioridade',
                'table' => [
                    'className' => 'PlanejamentoRetiradas',
                    'field'     => 'prioridade',
                    'operacao'  => 'entre'
                ]
            ]
        ];
    }
}
