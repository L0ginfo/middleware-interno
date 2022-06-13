<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use App\Util\UniversalCodigoUtil;
use App\Util\EntityUtil;
use App\Util\DoubleUtil;
use Cake\I18n\Number;
use App\Model\Entity\OrdemServicoItem;
use App\Model\Entity\LiberacoesDocumental;
use App\Model\Entity\EstoqueEndereco;
use App\Model\Entity\OrdemServicoCarregamento;
use App\Model\Entity\OrdemServicoEtiquetaCarregamento;
use App\Model\Entity\Estoque;
use App\Util\DateUtil;
use App\Util\LgDbUtil;
use App\Util\ResponseUtil;
use Cake\ORM\TableRegistry;

/**
 * EtiquetaProduto Entity
 *
 * @property int $id
 * @property string|null $produto_codigo
 * @property string|null $lote_codigo
 * @property int|null $lote_item
 * @property int $sequencia
 * @property string $codigo_barras
 * @property float $qtde
 * @property float $peso
 * @property float $m2
 * @property float $m3
 * @property int $endereco_id
 * @property int $unidade_medida_id
 * @property int $empresa_id
 *
 * @property \App\Model\Entity\Endereco $endereco
 * @property \App\Model\Entity\UnidadeMedida $unidade_medida
 * @property \App\Model\Entity\Empresa $empresa
 */
class EtiquetaProduto extends Entity
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
     * Default fields: 
     * 'produto_id' => true,
     * 'lote_codigo' => true,
     * 'lote_item' => true,
     * 'sequencia' => true,
     * 'codigo_barras' => true,
     * 'qtde' => true,
     * 'peso' => true,
     * 'm2' => true,
     * 'm3' => true,
     * 'endereco_id' => true,
     * 'unidade_medida_id' => true,
     * 'documento_mercadoria_item_id' => true,
     * 'house_desconsolidacao' => true,
     * 'lote' => true,
     * 'serie' => true,
     * 'validade' => true,
     * 'empresa_id' => true,
     * 'produto' => true,
     * 'endereco' => true,
     * 'unidade_medida' => true,
     * 'empresa' => true
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];


    public function saveEtiquetaProduto( $that, $aData, $iMercadoriaItemID, $iMercadoriaID )
    {
        $oEtiquetaProdutoOld = null;
        $bGeraEtiqueta = !$aData['produto_id'] ? true : Produto::getParam('gera_etiqueta', $aData['produto_id']);
        $bIncrementaDocMercItem = ($x = ParametroGeral::getParametro($that, 'DESCARGA_INCREMENTA_DOC_MERC_ITEM')) ? (int) $x->valor : 0;

        if (isset($aData['etiqueta_produto_id']) && $aData['etiqueta_produto_id'] >= 0 && $aData['etiqueta_produto_id'] != '') {
            $aData['id'] = $aData['etiqueta_produto_id'];
            $oEtiquetaProdutoOld = $that->EtiquetaProdutos->get($aData['etiqueta_produto_id']);
        }else {
            $aData['id'] = null;
        } 

        $aData['qtde']          = DoubleUtil::toDBUnformat($aData['quantidade']);
        $aData['peso']          = DoubleUtil::toDBUnformat($aData['peso_bruto']);
        $aData['sequencia']     = $aData['sequencia_item'];
        $aData['m2']            = isset($aData['m2']) ? DoubleUtil::toDBUnformat($aData['m2']) : 0;
        $aData['m3']            = isset($aData['m3']) ? DoubleUtil::toDBUnformat($aData['m3']) : 0;
        $aData['codigo_barras'] = 0;
        $aData['empresa_id']    = $that->getEmpresaAtual();
        $aData['house_desconsolidacao'] = $aData['house_desconsolidacao'];

        if (!isset($aData['etiqueta_produto_id']) || !@$aData['etiqueta_produto_id'])  {
            $aData['lote_codigo'] = $that->DocumentosMercadorias->get($iMercadoriaID)->lote_codigo;

            if ($bIncrementaDocMercItem) {
                $aData['lote_item'] = UniversalCodigoUtil::codigoLoteItemEtiquetaProduto( $that, $aData['lote_codigo'] );
            }else {
                $iSeq = LgDbUtil::getFind('DocumentosMercadoriasItens')->where(['id' => $iMercadoriaItemID])->first()->sequencia_item;
                $aData['lote_item'] = UniversalCodigoUtil::codigoLoteItemEtiquetaProduto( $that, $aData['lote_codigo'], 15, $iSeq);
            }
        }
        
        if (!$bGeraEtiqueta) {
            return [
                'message'   => 'OK',
                'status'    => 200,
                'dataExtra' => [
                    'lote_item'            => $aData['lote_item'],
                    'lote_codigo'          => $aData['lote_codigo'],
                    'etiqueta_produto_id'  => null,
                    'etiqueta_produto_old' => null,
                    'unidade_medida_id'    => $aData['unidade_medida_id']
                ]
            ];
        }

        $aData['documento_mercadoria_item_id'] = $iMercadoriaItemID;
        
        $oEtiquetaProduto = $that->setEntity('EtiquetaProdutos', $aData);
        $oEtiquetaProduto = $that->EtiquetaProdutos->patchEntity($oEtiquetaProduto, $aData);
        
        $oEtiquetaProdutoOld = !$oEtiquetaProdutoOld ? $oEtiquetaProduto : $oEtiquetaProdutoOld;
        
        if ( $result = $that->EtiquetaProdutos->save($oEtiquetaProduto) ){
            $oEtiquetaProduto->codigo_barras = UniversalCodigoUtil::codigoEtiqueta( $result->id );

            if ( $that->EtiquetaProdutos->save($oEtiquetaProduto) ){
                return [
                    'message'   => 'OK',
                    'status'    => 200,
                    'dataExtra' => [
                        'lote_item'            => $oEtiquetaProduto->lote_item,
                        'lote_codigo'          => $oEtiquetaProduto->lote_codigo,
                        'etiqueta_produto_id'  => $oEtiquetaProduto->id,
                        'etiqueta_produto_old' => $oEtiquetaProdutoOld,
                        'unidade_medida_id'    => $oEtiquetaProduto->unidade_medida_id
                    ]
                ];
            }
        }
        
        return [
            'message' => __('Erro ao salvar etiqueta de produto! ' . EntityUtil::dumpErrors($oEtiquetaProduto) ),
            'status'  => 401
        ];
    }

    public function findEstoqueByEtiqueta ($that, $sCodigoBarras, $aEstoquesIDs)
    {
        return $that->EtiquetaProdutos->find('all')
            ->select([
                'Estoques.id',
                'Estoques.lote_codigo',
                'Estoques.lote_item',
                'Estoques.qtde_saldo',
                'Estoques.peso_saldo',
                'Estoques.unidade_medida_id',
                'Estoques.empresa_id',
            ])
            ->select($that->EtiquetaProdutos)
            ->innerJoinWith('Estoques', function(\Cake\ORM\Query $q) {
                return $q->where([
                    'Estoques.lote_item         = EtiquetaProdutos.lote_item',
                    'Estoques.lote_codigo       = EtiquetaProdutos.lote_codigo',
                    'Estoques.unidade_medida_id = EtiquetaProdutos.unidade_medida_id',
                    'Estoques.empresa_id        = EtiquetaProdutos.empresa_id'
                ]);
            })
            ->where([
                'codigo_barras' => $sCodigoBarras,
                'Estoques.id IN' => $aEstoquesIDs
            ])
            ->first();
    }

    public function checkTemEstoqueSuficiente( $oEtiquetaProduto )
    {
        $oEstoque = $oEtiquetaProduto->_matchingData['Estoques'];
        
        if ($oEstoque->qtde_saldo < $oEtiquetaProduto->qtde) 
            return false;
        
        return true;

    }

    public function foiCarregado( $that )
    {
        $aData = $that->request->getData();
        $sCodigoBarras = $aData['sCodebar'];
        $iOSID         = $aData['iOSID'];
        
        $oOrdemServicoEtiquetaCarregamentos = new OrdemServicoEtiquetaCarregamento;
        $aEtiquetaProdutosCarregadas = $oOrdemServicoEtiquetaCarregamentos->getEtiquetasCarregadas( $that, $iOSID );

        return in_array($sCodigoBarras, $aEtiquetaProdutosCarregadas['codigo_barras']);
    }
    
    public function estornaSaidaFisica( $that )
    {
        $oResponse     = new ResponseUtil();
        $aData         = $that->request->getData();
        $sCodigoBarras = $aData['sCodebar'];
        $aEstoquesIDs  = $aData['aEstoquesIDs'];
        $iOSID         = $aData['iOSID'];

        $oEtiquetaProdutos                  = new EtiquetaProduto;
        $oEstoqueEndereco                   = new EstoqueEndereco;
        $oEstoques                          = new Estoque;
        $oOrdemServicoCarregamentos         = new OrdemServicoCarregamento;
        $oOrdemServicoEtiquetaCarregamentos = new OrdemServicoEtiquetaCarregamento;

        $aReturn = $oEstoques->incrementByEtiquetaCodBarras( $that, $sCodigoBarras, $iOSID );

        if ($aReturn['status'] != 200) 
            return $that->response->withType("application/json")->withStringBody(json_encode($aReturn));

        $oEtiquetaProduto          = $aReturn['dataExtra']['etiqueta_produto'];
        $iEstoqueID                = $aReturn['dataExtra']['estoque_id'];
        $iOSCarregamentoID         = $aReturn['dataExtra']['ordem_servico_carregamento_id'];
        $iOSEtiquetaCarregamentoID = $aReturn['dataExtra']['ordem_servico_etiqueta_carregamento_id'];

        //Adiciona o estoque_endereco para fazer o manejo de estorno do carregamento
        $aReturn = $oEstoqueEndereco->insertByEtiquetaEstoque( $that, $oEtiquetaProduto, $iEstoqueID );

        if ($aReturn['status'] != 200)
            return $oResponse->setMessage($aReturn['message']);

        $aReturn = $oOrdemServicoCarregamentos->removeOSCarregamento( $that, $iOSCarregamentoID );

        if ($aReturn['status'] != 200)
            return $oResponse->setMessage($aReturn['message']);

        $aReturn = $oOrdemServicoEtiquetaCarregamentos->removeOSEtiquetaCarregamento( $that, $iOSEtiquetaCarregamentoID );

        if ($aReturn['status'] != 200)
            return $oResponse->setMessage($aReturn['message']);

        return $oResponse
            ->setStatus(200)
            ->setTitle('Produto Estornado com sucesso!')
            ->setMessage(' ')
            ->setDataExtra([
                'object'            => $oEtiquetaProduto,
                'unidade_medida_id' => $oEtiquetaProduto->unidade_medida_id,
                'codigo_barras'     => $oEtiquetaProduto->codigo_barras,
                'qtde'              => $oEtiquetaProduto->qtde,
                'estorno'           => true,
                'iEstoqueID'        => $iEstoqueID
            ]);
    }

    public function carregaSaidaFisica( $that )
    {
        $oResponse     = new ResponseUtil();
        $aData         = $that->request->getData();
        $sCodigoBarras = $aData['sCodebar'];
        $aEstoquesIDs  = $aData['aEstoquesIDs'];
        $iOSID         = $aData['iOSID'];

        $oEtiquetaProdutos                  = new EtiquetaProduto;
        $oEstoques                          = new Estoque;
        $oOrdemServicoCarregamentos         = new OrdemServicoCarregamento;
        $oOrdemServicoEtiquetaCarregamentos = new OrdemServicoEtiquetaCarregamento;

        $oEtiquetaProduto = $oEtiquetaProdutos->findEstoqueByEtiqueta($that, $sCodigoBarras, $aEstoquesIDs);

        if (!$oEtiquetaProduto) 
            return $oResponse
                ->setTitle('Não foi possível encontrar o item no Estoque!')
                ->setMessage('Caso o erro persista, favor contatar os Administradores do sistema.');
        
        $bTemEstoqueSuficiente = $oEtiquetaProdutos->checkTemEstoqueSuficiente($oEtiquetaProduto);
        $oEstoque = $oEtiquetaProduto->_matchingData['Estoques'];

        if (!$bTemEstoqueSuficiente) 
            return $oResponse
                ->setTitle('O Estoque não possui a Quantidade desse item!')
                ->setMessage('O Estoque possui a quantidade de "'.$oEstoque->qtde_saldo.
                '", e a Etiqueta indica a quantidade de: "'.$oEtiquetaProduto->qtde.
                '" <br><br> Caso o problema de Estoque persista, favor contatar os Administradores do sistema.');
        
        //Remove do estoque e estoque_endereco para fazer o manejo de estoque para o carregamento
        $aReturn = $oEstoques->manageRetiradaEstoqueByEtiqueta( $that, $oEtiquetaProduto );
        
        if ($aReturn['status'] != 200)
            return $oResponse->setMessage($aReturn['message']);

        $aReturn = $oOrdemServicoCarregamentos->saveOSCarregamento( $that, $oEtiquetaProduto, $iOSID );

        if ($aReturn['status'] != 200)
            return $oResponse->setMessage($aReturn['message']);

        $aReturn = $oOrdemServicoEtiquetaCarregamentos->saveOSEtiquetaCarregamento( $that, $oEtiquetaProduto, $iOSID );

        if ($aReturn['status'] != 200)
            return $oResponse->setMessage($aReturn['message']);
        
        return $oResponse
            ->setStatus(200)
            ->setTitle('Produto carregado com sucesso!')
            ->setMessage(' ')
            ->setDataExtra([
                'object' => $oEtiquetaProduto
            ]);
    }
  
    public static function sGetListaEtiquetaProdutos($data, $iEmpresa){
        $sWhere = ['EtiquetaProdutos.empresa_id'=> $iEmpresa];
        $QWhere = [];
        $DWhere = ['DocumentosMercadorias'];

        if(isset($data['lote']) && $data['lote']){
            $sWhere += [ "EtiquetaProdutos.lote_codigo" => $data['lote']];
        }

        if(isset($data['tipo_documento']) && $data['tipo_documento']){
            $QWhere += [ "tipo_documento_id" => $data['tipo_documento'] ];
        }

        if(isset($data['documento']) && $data['documento']){
            $QWhere += [ "numero_documento" => $data['documento'] ];
        }

        if(!empty($QWhere)){
             $DWhere += ['DocumentosMercadorias' => function(\Cake\ORM\Query $q) use($QWhere) {
                 return $q->where($QWhere);}];
        }

        return LgDbUtil::get('EtiquetaProdutos')->find()
            ->contain([
                'EstoquesMercadorias',
                'Produtos', 
                'Enderecos'=>['AreasLeft' => 'LocaisLeft'], 
                'DocumentosMercadoriasItens'=> $DWhere
            ])
            ->where($sWhere)
            ->where(['EstoquesMercadorias.qtde_saldo >' => 0])
            ->order('EtiquetaProdutos.id DESC');
    }

    public static function oGetEtiquetaProdutos($id){
       return TableRegistry::get('EtiquetaProdutos')->get($id, ['Enderecos', 'DocumentosMercadoriasItens'=>['DocumentosMercadorias']]); 
    }


    public static function getByCodigoBarras($sCodigo, $iEmpresa){
        return TableRegistry::get('EtiquetaProdutos')
            ->find()
            ->where([
                'codigo_barras' =>$sCodigo,
                'empresa_id'=>$iEmpresa
            ]);
    }

    public static function getFilters()
    {
        return [
            [
                'name'  => 'codigo',
                'divClass' => 'col-lg-3',
                'label' => 'Produto Código',
                'table' => [
                    'className' => 'Produtos',
                    'field'     => 'codigo',
                    'operacao'  => 'contem'
                ]
            ],
            [
                'name'  => 'produto',
                'divClass' => 'col-lg-3',
                'label' => 'Produto Descrição',
                'table' => [
                    'className' => 'Produtos',
                    'field'     => 'descricao',
                    'operacao'  => 'contem'
                ]
            ],
            [
                'name'  => 'und',
                'divClass' => 'col-lg-3',
                'label' => 'Unidade Medida',
                'table' => [
                    'className' => 'UnidadeMedidas',
                    'field'     => 'descricao',
                    'operacao'  => 'contem'
                ]
            ],
            [
                'name'  => 'endereco_id',
                'divClass' => 'col-lg-2',
                'label' => 'Endereco ID',
                'table' => [
                    'className' => 'EtiquetaProdutos',
                    'field'     => 'endereco_id',
                    'operacao'  => 'igual'
                ]
            ],
            [
                'name'  => 'master_id',
                'divClass' => 'col-lg-2',
                'label' => 'Master',
                'table' => [
                    'className' => 'EtiquetaProdutos.DocumentosMercadoriasLote.DocumentosMercadoriasMasterFilter',
                    'field'     => 'numero_documento',
                    'operacao'  => 'igual'
                ]
            ],
            [
                'name'  => 'house_id',
                'divClass' => 'col-lg-2',
                'label' => 'House',
                'table' => [
                    'className' => 'EtiquetaProdutos.DocumentosMercadoriasLote',
                    'field'     => 'numero_documento',
                    'operacao'  => 'igual'
                ]
            ]
        ];
    }
}