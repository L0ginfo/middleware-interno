<?php
namespace App\Model\Entity;

use App\RegraNegocio\GerenciamentoEstoque\ProdutosControlados;
use App\TraitClass\ClosureAsMethodClass;
use App\Util\ArrayUtil;
use App\Util\DateUtil;
use App\Util\EntityUtil;
use App\Util\ObjectUtil;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;
use App\Util\SaveBackUtil;
use App\Model\Entity\Empresa;
use App\RegraNegocio\Integracoes\HandlerIntegracao;
use App\RegraNegocio\Rfb\RfbManager;

/**
 * MovimentacoesEstoque Entity
 *
 * @property int $id
 * @property int $estoque_id
 * @property int $endereco_origem_id
 * @property int $endereco_destino_id
 * @property int $tipo_movimentacao_id
 * @property \Cake\I18n\Time $data_hora
 * @property float $quantidade_movimentada
 * @property float $m2_movimentada
 * @property float $m3_movimentada
 *
 * @property \App\Model\Entity\Estoque $estoque
 * @property \App\Model\Entity\Endereco $endereco
 * @property \App\Model\Entity\TipoMovimentacao $tipo_movimentacao
 */
class MovimentacoesEstoque extends Entity
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
     * 
     * 'estoque_id' => true,
     * 'endereco_origem_id' => true,
     * 'endereco_destino_id' => true,
     * 'tipo_movimentacao_id' => true,
     * 'data_hora' => true,
     * 'quantidade_movimentada' => true,
     * 'm2_movimentada' => true,
     * 'm3_movimentada' => true,
     * 'estoque' => true,
     * 'endereco' => true,
     * 'tipo_movimentacao' => true
     */

    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function loadModels()
    {
        $oThat = new ClosureAsMethodClass;

        $aModels = [
            'MovimentacoesEstoques'
        ];

        $aMethods = [
            'getEmpresaAtual' => function() {
                return Empresa::getEmpresaPadrao();
            }
        ];
        
        foreach ($aModels as $sModel) {
            $oThat->{$sModel} = TableRegistry::get($sModel);
        }
        
        foreach ($aMethods as $sMethod => $fMethod) {
            $oThat->{$sMethod} = $fMethod;
        }
        
        return $oThat;
    }

    public static function saveMovimentacao( $oThat = null, $aData )
    {
        $aDataEstoque = [];

        if (!$oThat)
            $oThat = self::loadModels();
        else 
            $oThat->loadModel('MovimentacoesEstoques');

        if (ArrayUtil::get($aData, 'estoque_id')) {
            $oEstoque = TableRegistry::get('Estoques')->find()
                ->where([
                    'id' => $aData['estoque_id']
                ])->first();

            $aDataEstoque = ObjectUtil::getAsArray($oEstoque, true);
        }
        
        
        $aData = array_merge($aData, [
            'data_hora'                  => @$aData['data_hora'] ?: DateUtil::dateTimeToDB(DateUtil::getNowTime()->format('Y-m-d H:i:s')),
            'quantidade_movimentada'     => @$aData['quantidade_movimentada'] ?: 0,
            'm2_movimentada'             => @$aData['m2_movimentada'] ?: 0,
            'm3_movimentada'             => @$aData['m3_movimentada'] ?: 0,
            'estoque_id'                 => null, //@$aData['estoque_id'] ?: null,
            'endereco_origem_id'         => @$aData['endereco_origem_id'] ?: $aData['endereco_destino_id'],
            'endereco_destino_id'        => @$aData['endereco_destino_id'] ?: $aData['endereco_origem_id'],
            'tipo_movimentacao_id'       => @$aData['tipo_movimentacao_id'] ?: 2,
            'usuario_conectado_id'       => @$_SESSION['Auth']['User']['id'] ?: null,
            'produto_id'                 => @$aData['produto_id']                  ?: ArrayUtil::get($aDataEstoque, 'produto_id', null),
            'status_estoque_id'          => @$aData['status_estoque_id']           ?: ArrayUtil::get($aDataEstoque, 'status_estoque_id', null),
            'status_estoque_anterior_id' => @$aData['status_estoque_anterior_id']  ?: ArrayUtil::get($aDataEstoque, 'status_estoque_id', null),
            'observacao'                 => @$aData['observacao']                  ?: null,
            'lote_codigo'                => @$aData['lote_codigo']                 ?: ArrayUtil::get($aDataEstoque, 'lote_codigo', null),
            'lote_item'                  => @$aData['lote_item']                   ?: ArrayUtil::get($aDataEstoque, 'lote_item', null),
            'lote'                       => @$aData['lote']                        ?: (($x = ArrayUtil::get($aDataEstoque, 'lote')) != '' ? $x : null),
            'serie'                      => @$aData['serie']                       ?: (($x = ArrayUtil::get($aDataEstoque, 'serie')) != '' ? $x : null),
            'validade'                   => @$aData['validade']                    ?: (($x = ArrayUtil::get($aDataEstoque, 'validade')) != '' ? $x : null),
            'created_at_estoque'         => @$aData['created_at']                  ?: ArrayUtil::get($aDataEstoque, 'created_at', null),
            'unidade_medida_anterior_id' => @$aData['unidade_medida_anterior_id']  ?: ArrayUtil::get($aDataEstoque, 'unidade_medida_id', null),
            'unidade_medida_nova_id'     => @$aData['unidade_medida_nova_id']      ?: null,
            'container_id'               => @$aDataEstoque['container_id']         ?: null,
        ]);

        $oMovimentacao = TableRegistry::get('MovimentacoesEstoques')->newEntity();
        $oMovimentacao = TableRegistry::get('MovimentacoesEstoques')->patchEntity($oMovimentacao, $aData);
        
        $result = TableRegistry::get('MovimentacoesEstoques')->save($oMovimentacao);
        
        if (!$result) 
            return [
                'message' => __('Não foi possível cadastrar a Movimatação de Estoque!'),
                'dump'    => EntityUtil::dumpErrors($oMovimentacao),
                'status'  => 400
            ];

        $oParamIntegracaoMovInterna = ParametroGeral::getParameterByUniqueName('PARAM_INTEGRACAO_ENVIA_MOV_INTERNA');
        if ($oParamIntegracaoMovInterna) {
            $oResponse = HandlerIntegracao::do(@$oParamIntegracaoMovInterna->id, [
                'aData' => $aData
            ]);
    
            if ($oResponse->getStatus() != 200) {
                return [
                    'message' => __('Movimatação de Estoque foi cadastrada, porém ocorreu algum erro na integração!'),
                    'status'  => 400
                ];
            }
        }

        RfbManager::doAction('rfb', 'armazenamento-lote', 'init', $result, ['nome_model' => 'Integracoes']);

        return [
            'message' => 'OK',
            'status'  => 200,
            'object' => $oMovimentacao 
        ];
    }


    public static function oGetMovimentacao($iEstoque, $iTipo_movimentacao)
    {
        return TableRegistry::get('MovimentacoesEstoques')
            ->find()
            ->where([
                'estoque_id' =>$iEstoque, 
                'tipo_movimentacao' => $iTipo_movimentacao]);
    }

    public static function salvar($that){
        $empresa_atual = $that->getRequest()->getSession()->read('empresa_atual');
        $iItem = $that->request->getQuery('item_id');
        $ILoteCodigo = $that->request->getQuery('lote_codigo');
        $iLoteItem = $that->request->getQuery('lote_item');
        $iUnidadeMedida = $that->request->getQuery('unidade_medida');

        if ($that->request->is(['patch', 'post', 'put']) && $that->request->getData('endereco')) {

            $oItem = $that->EtiquetaProdutos->get($iItem);

            $oTipoMovimentacao = $that->TipoMovimentacoes->find()
                ->where([
                    'descricao' => 'MOV'
                ])
                ->first();
            
            $oEstoqueEndereco = $that->EstoqueEnderecos->find()
                ->where([
                    'peso_saldo' => $oItem->peso,
                    'qtde_saldo' => $oItem->qtde,
                    'endereco_id' =>$oItem->endereco_id, 
                    'lote_codigo' =>$ILoteCodigo, 
                    'lote_item' => $iLoteItem, 
                    'unidade_medida_id'=>$iUnidadeMedida,
                    'empresa_id' => $empresa_atual
                ] + ProdutosControlados::getProdutoControlesValuesToQuery($oItem))
            ->first();
            
            $oNovoEndereco = $that->Enderecos
                ->find()
                ->where(['id'=> $that->request->getData('endereco')])
                ->first();

            if($oEstoqueEndereco && $oNovoEndereco){

                MovimentacoesEstoque::saveMovimentacao($that, [
                    'quantidade_movimentada' => $oEstoqueEndereco->qtde_saldo,
                    'estoque_id'             => $oEstoqueEndereco->estoque_id,
                    'endereco_origem_id'     => $oEstoqueEndereco->endereco_id,
                    'endereco_destino_id'    => $oNovoEndereco->id,
                    'm2_movimentada'         => $oEstoqueEndereco->m2_saldo,
                    'm3_movimentada'         => $oEstoqueEndereco->m3_saldo,
                    'tipo_movimentacao_id'   => 3
                ]);

                $oEstoqueEndereco->endereco_id = $oNovoEndereco->id;
                $oItem->endereco_id = $oNovoEndereco->id;
                $that->EtiquetaProdutos->save($oItem);
                $that->EstoqueEnderecos->save($oEstoqueEndereco);
                $that->Flash->success(__('Movimentação'). __(' has been saved.'));

                if($that->request->getQuery('historyback') ) {
                    SaveBackUtil::doBackReturn($that);
                }

                return $that->redirect(['action'=>'movimentar']);
            }
            $that->Flash->error(__('Movimentação') . __(' could not be saved. Please, try again.'));
        }

        $oItem = $that->EtiquetaProdutos->get($iItem, [
            'contain' => [
                'Enderecos' => [
                    'AreasLeft' => 'LocaisLeft',
                ],
                'DocumentosMercadoriasLote',
                'UnidadeMedidas'
            ]
        ]);

        $aLocais = $that->Locais->find('list')->where(['empresa_id'=> $oItem->empresa_id]);
        $that->set('_serialize', ['oItem', 'aLocais']);
        $that->set('form_templates', Configure::read('Templates'));
        $that->set(compact(['oItem', 'aLocais']));
    }
}
