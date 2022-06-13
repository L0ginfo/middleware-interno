<?php
namespace App\Model\Entity;

use App\Util\ObjectUtil;
use App\Model\Entity\ProdutoClassificacaoVinculo;
use App\Util\SessionUtil;
use App\Util\LgDbUtil;
use Cake\Http\Client;
use Cake\Http\Session;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;

/**
 * Produto Entity
 *
 * @property int $id
 * @property string $descricao
 * @property string $codigo
 * @property int|null $ncm_id
 * @property int $empresa_id
 * @property int $unidade_medida_id
 * @property int|null $is_controlado_validade
 * @property int|null $is_usado_fifo
 * @property int $controla_serie
 * @property int|null $depositante_id
 * @property string|null $sku
 * @property int|null $produto_classificacao_id
 * @property int $controla_lote
 * @property string $codigo_barras
 *
 * @property \App\Model\Entity\Ncm $ncm
 * @property \App\Model\Entity\Empresa $empresa
 * @property \App\Model\Entity\UnidadeMedida $unidade_medida
 * @property \App\Model\Entity\Empresa $depositante
 * @property \App\Model\Entity\DocumentosMercadoriasItem[] $documentos_mercadorias_itens
 */
class Produto extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     *
     * default fields
     *
     *  'descricao' => true,
     *  'codigo' => true,
     *  'ncm_id' => true,
     *  'empresa_id' => true,
     *  'unidade_medida_id' => true,
     *  'is_controlado_validade' => true,
     *  'is_usado_fifo' => true,
     *  'controla_serie' => true,
     *  'depositante_id' => true,
     *  'sku' => true,
     *  'produto_classificacao_id' => true,
     *  'controla_lote' => true,
     *  'codigo_barras' => true,
     *  'ncm' => true,
     *  'empresa' => true,
     *  'unidade_medida' => true,
     *  'depositante' => true,
     *  'documentos_mercadorias_itens' => true,
     */

    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    private static $aControlesTranslate = [
        'controle_validade' => 'validade',
        'controle_lote' => 'lote',
        'controle_serie' => 'serie',
        'controle_fifo' => 'created_at',
    ];

    public static function getControlesNotEmpty($aControles)
    {
        $aNotEmpty = [];

        foreach ($aControles as $sControle => $value) {
            $aNotEmpty[] = self::$aControlesTranslate[$sControle] . ' IS NOT NULL';
        }

        return $aNotEmpty;
    }

    public static function getTiposControlePicking()
    {
        return [
            'controle_validade' => true,
            'controle_lote'     => true,
            'controle_serie'    => true,
            'controle_fifo'     => true,
        ];
    }

    public static function getByCodigo($sCodigo, $oProduto) {
        $oProdutoEstoque = TableRegistry::get('Produtos')->find()
            ->where([
                'codigo' => $sCodigo
            ]);
        $oParamProdutoDepositante = ParametroGeral::getParametroWithValue('PARAM_PRODUTO_DEPOSITANTE');
        if (@$oParamProdutoDepositante == 1) {
            $oProdutoEstoque = $oProdutoEstoque->andWhere(['depositante_id' => @$oProduto['depositante_id']]);
        }

        $oProdutoEstoque = $oProdutoEstoque->first();

        if ($oProdutoEstoque)
            return $oProdutoEstoque;

        $oProduto = TableRegistry::get('Produtos')->newEntity([
            'descricao'         => $oProduto['descricao'],
            'codigo'            => $oProduto['codigo'],
            'ncm_id'            => @$oProduto['ncm_id'],
            'empresa_id'        => @Empresa::getEmpresaPadrao(),
            'unidade_medida_id' => @UnidadeMedida::getByDescricao($oProduto['unidade_medida']),
            'controla_serie'    => 0,
            'depositante_id'    => @$oProduto['depositante_id'],
            'codigo_barras'     => 0
        ]);

        return TableRegistry::get('Produtos')->save($oProduto);
    }

    public static function getProdutoByCodigo($aProdutoNf, $aDepositante)
    {
        $sCodigo = self::getCodigoFormatado($aProdutoNf['cProd']);

        $oProduto = TableRegistry::get('Produtos')->find()
            ->where([
                'codigo' => $sCodigo
            ]);
        $oParamProdutoDepositante = ParametroGeral::getParametroWithValue('PARAM_PRODUTO_DEPOSITANTE');
        if (@$oParamProdutoDepositante == 1) {
            $oProduto = $oProduto->andWhere(['depositante_id' => @Empresa::getEmpresaByCnpj($aDepositante)]);
        }

        $oProduto = $oProduto->first();

        if ($oProduto)
            return $oProduto;

        $oProduto = TableRegistry::get('Produtos')->newEntity([
            'descricao'         => $aProdutoNf['xProd'],
            'codigo'            => $sCodigo,
            'bloqueia_estoque_entrante' => 1,
            'ncm_id'            => @Ncm::getNcmByCodigo($aProdutoNf['NCM']),
            'empresa_id'        => @Session::create()->read('empresa_atual')?: Empresa::getEmpresaPadrao(),
            'unidade_medida_id' => @UnidadeMedida::getUnidadeMedidaByCodigo($aProdutoNf['uCom']),
            'controla_serie'    => 0,
            'depositante_id'    => @Empresa::getEmpresaByCnpj($aDepositante) ?: Empresa::getEmpresaPadrao(),
            'codigo_barras'     => self::getCodebarByIntegracao($aProdutoNf),
            'produto_classificacao_id' => ProdutoClassificacaoVinculo::getProdutoClassificacaoByDescricao($aProdutoNf['xProd'])
        ]);

        return TableRegistry::get('Produtos')->save($oProduto);
    }

    private static function getCodigoFormatado($sCodigo)
    {
        $sCodigoFormatado = (int) str_replace('-', '', $sCodigo);

        return $sCodigoFormatado ?: $sCodigo;
    }

    private static function getCodebarByIntegracao($aProdutoNf)
    {
        $sCodigo = self::getCodigoFormatado($aProdutoNf['cProd']);
        $sDefault = '0';

        if (@$aProdutoNf['cEAN'])
            return $aProdutoNf['cEAN'];

        if (!@$sCodigo)
            return $sDefault;

        //Tenta buscar da integração de estoques
        $sUrlIntegracao = Router::url([
            'controller' => 'Integracoes',
            'action' => 'integrar',
            'produtos-estoques',
            '?' => [
                'only_return' => 'true'
            ]
        ], true);

        $aBody = [
            'produtos' => [$sCodigo]
        ];

        $oHttp = new Client(['headers' => [
            'private-key' => '4c607e8ac6d04fa58378d4c5ce1df2befd32e60b'
        ]]);

        $oResponse = $oHttp->post($sUrlIntegracao, json_encode($aBody), [ 'type' => 'json' ]);
        $oResponseBody = ObjectUtil::getAsArray(json_decode($oResponse->body));
        $oResponseBody = @$oResponseBody->dataExtra->aRequest;

        if (!$oResponseBody)
            return $sDefault;

        return $sDefault;
    }

    public static function getProdutosControles($aProdutosIDs)
    {
        if (!$aProdutosIDs)
            return [];

        $aProdutosControles = [];

        $aProdutos = TableRegistry::get('Produtos')->find()
            ->where(['id IN' => $aProdutosIDs])
            ->toArray();

        foreach ($aProdutos as $oProduto)
            $aProdutosControles[$oProduto->id] = [
                'lote'              => $oProduto->controla_lote,
                'serie'             => $oProduto->controla_serie,
                'validade'          => $oProduto->is_controlado_validade,
                'unidade_medida_id' => $oProduto->unidade_medida_id,
                'codigo_barras'     => $oProduto->codigo_barras,
                'produto_id'        => $oProduto->id,
                'codigo'            => $oProduto->codigo,
            ];

        return $aProdutosControles;
    }

    public static function getFilters()
    {
        return [
            [
                'name' => 'codigo',
                'divClass' => 'col-lg-2',
                'label' => 'Código',
                'table' => [
                    'className' => 'Produtos',
                    'field'     => 'codigo',
                    'operacao'  => 'contem'
                ]
            ],
            [
                'name' => 'descricao',
                'divClass' => 'col-lg-4',
                'label' => 'Descrição',
                'table' => [
                    'className' => 'Produtos',
                    'field'     => 'descricao',
                    'operacao'  => 'contem'
                ]
            ],
            [
                'name' => 'codigo_barras',
                'divClass' => 'col-lg-3',
                'label' => 'Código Barras',
                'table' => [
                    'className' => 'Produtos',
                    'field'     => 'codigo_barras',
                    'operacao'  => 'contem'
                ]
            ],
        ];
    }

    public static function getParam($sParam, $iProdutoID)
    {
        if (!$iProdutoID || !$sParam)
            return null;

        $aParams['gera_etiqueta'] = function() use($iProdutoID) {
            return SessionUtil::cacheData('gera_etiqueta', function() use($iProdutoID) {
                return TableRegistry::getTableLocator()->get('Produtos')->find()
                    ->select('Produtos.gera_etiqueta')
                    ->where([
                        'Produtos.id' => $iProdutoID
                    ])
                    ->extract('gera_etiqueta')
                    ->first();
            }, 2);
        };

        if (array_key_exists($sParam, $aParams))
            return $aParams[$sParam]();

        return null;
    }

    public static function getProdutoDepositante($ilimit, $aExtraSearch, $aData)
    {
        if (isset($aData['type']) && @$aData['type'] == 'somente_em_estoque') {
            $query = LgDbUtil::get('Produtos')
                ->find('list', ['keyField' => 'id', 'valueField' => 'codigo_descricao'])
                ->innerJoinWith('Estoques')
                ->contain(['Depositantes'])
                ->select([
                    'id',
                    'codigo_descricao' => "CONCAT(
                        Depositantes.descricao, ' | ', Produtos.codigo, ' - ', Produtos.descricao
                    )"
                ])
                ->limit($ilimit)
                ->where($aExtraSearch)
                ->group('Produtos.id')
                ->toArray();

            return $query;
        }

        $query = LgDbUtil::get('Produtos')
            ->find('list', ['keyField' => 'id', 'valueField' => 'codigo_descricao'])
            ->contain(['Depositantes'])
            ->select([
                'id',
                'codigo_descricao' => "CONCAT(
                    Depositantes.descricao, ' | ', Produtos.codigo, ' - ', Produtos.descricao
                )",
            ])
            ->limit($ilimit)
            ->where($aExtraSearch)
            ->toArray();

        return $query;
    }

    public static function getProdutoSemDepositante($ilimit, $aExtraSearch, $aData)
    {
        if (isset($aData['type']) && @$aData['type'] == 'somente_em_estoque') {
            $query = LgDbUtil::get('Produtos')
                ->find('list', ['keyField' => 'id', 'valueField' => 'codigo_descricao'])
                ->innerJoinWith('Estoques')
                ->select([
                    'id',
                    'codigo_descricao' => "CONCAT(Produtos.codigo, ' - ', Produtos.descricao)"
                ])
                ->limit($ilimit)
                ->where($aExtraSearch)
                ->group('Produtos.id')
                ->toArray();

                return $query;
        }

        $query = LgDbUtil::get('Produtos')
            ->find('list', ['keyField' => 'id', 'valueField' => 'codigo_descricao'])
            ->select([
                'id',
                'codigo_descricao' => "CONCAT(Produtos.codigo, ' - ', Produtos.descricao)",
            ])
            ->limit($ilimit)
            ->where($aExtraSearch)
            ->toArray();

        return $query;
    }
}
