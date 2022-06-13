<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use App\Model\Entity\SeparacaoSituacao;
use App\Model\Entity\EstoqueEndereco;
use App\Model\Entity\OrdemServicoItemSeparacao;
use App\RegraNegocio\OperacaoSeparacao\ActionEstornar\ActionEstornar;
use App\RegraNegocio\OperacaoSeparacao\ActionSeparar\ActionSeparar;
use App\TraitClass\ClosureAsMethodClass;
use App\Util\DoubleUtil;
use App\Util\EntityUtil;
use App\Util\ErrorUtil;
use App\Util\LgDbUtil;
use App\Util\ObjectUtil;
use App\Util\ResponseUtil;

/**
 * OrdemServicoSeparacaoCarga Entity
 *
 * @property int $id
 * @property int $ordem_servico_id
 * @property int $separacao_carga_id
 *
 * @property \App\Model\Entity\OrdemServico $ordem_servico
 * @property \App\Model\Entity\SeparacaoCarga $separacao_carga
 */
class OrdemServicoSeparacaoCarga extends Entity
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
    protected $_accessible = [
        'ordem_servico_id' => true,
        'separacao_carga_id' => true,
        'ordem_servico' => true,
        'separacao_carga' => true,
    ];

    public static function createLink($iOSID, $aSeparacaoIDs)
    {
        $oOrdemServicoSeparacaoCargasTable = TableRegistry::get('OrdemServicoSeparacaoCargas');
        $aData = array();
        $aToInsertSeparacaoIDs = array();

        foreach ($aSeparacaoIDs as $key => $iSeparacaoID) {
            $aToInsert = [
                'ordem_servico_id' => $iOSID,
                'separacao_carga_id' => $iSeparacaoID
            ];

            $oCheckIfExists = $oOrdemServicoSeparacaoCargasTable->find()->where($aToInsert)->first();

            //se nao existir o vinculo, cria o registro
            if (!$oCheckIfExists){
                $aData[] = $aToInsert;
                $aToInsertSeparacaoIDs[] = $iSeparacaoID;
            }
        }

        if (!$aData)
            return true;

        $aOrdemServicoSeparacaoCarga = $oOrdemServicoSeparacaoCargasTable->newEntities($aData);

        if ($oOrdemServicoSeparacaoCargasTable->saveMany($aOrdemServicoSeparacaoCarga)) {
            SeparacaoSituacao::setSituacao($aToInsertSeparacaoIDs, 'Aguardando separação');

            return true;
        }

        return false;
    }

    public static function getOsPendentes()
    {
        $oQuery = TableRegistry::get('OrdemServicos')->find()
            ->contain(['OrdemServicoSeparacaoCargas' => ['SeparacaoCargas' => ['SeparacaoCargaOperadores' => 'Usuarios']]])
            ->where([
                'ordem_servico_tipo_id' => EntityUtil::getIdByParams('OrdemServicoTipos', 'descricao', 'Separação', true),
                'data_hora_fim IS NULL',
                'cancelada' => 0
            ]);

        return $oQuery;
    }

    public static function getWithSeparacaoCargas($oQuery)
    {
        $aOrdemServicos = [];

        foreach ($oQuery->toArray() as $key => $oOrdemServico) {
            if ($oOrdemServico->ordem_servico_separacao_cargas)
                $aOrdemServicos[] = $oOrdemServico;
        }

        foreach ($aOrdemServicos as $key => $oOrdemServico) {
            $aOrdemServicos[$key]->pedidos = [];
            $aOrdemServicos[$key]->operadores = [];

            foreach ($oOrdemServico->ordem_servico_separacao_cargas as $keyOSSeparacao => $oOSSeparacaoCarga) {
                $aOrdemServicos[$key]->pedidos[] = $oOSSeparacaoCarga->separacao_carga->numero_pedido;

                foreach ($oOSSeparacaoCarga->separacao_carga->separacao_carga_operadores as $keyOperador => $oSeparacaoOperador) {
                    $aOrdemServicos[$key]->operadores[ $oSeparacaoOperador->usuario->id ] = $oSeparacaoOperador->usuario->nome;
                }
            }
        }

        return $aOrdemServicos;
    }

    public static function getArrayOperacao($aOrdemServicoSeparacaoCargas)
    {
        $aOperacaoDados = [];

        foreach ($aOrdemServicoSeparacaoCargas as $oOrdemServicoSeparacaoCarga) {
            $iSeparacaoID = $oOrdemServicoSeparacaoCarga->separacao_carga->id;

            $aOperacaoDados[$iSeparacaoID] = [
                'id' => $oOrdemServicoSeparacaoCarga->separacao_carga->id,
                'codigo_pedido' => $oOrdemServicoSeparacaoCarga->separacao_carga->codigo_pedido,
                'numero_pedido' => $oOrdemServicoSeparacaoCarga->separacao_carga->numero_pedido,
                'cliente_id' => $oOrdemServicoSeparacaoCarga->separacao_carga->cliente_id,
            ];

            foreach ($oOrdemServicoSeparacaoCarga->separacao_carga->separacao_carga_itens as $key => $oSeparacaoCargaItem) {
                $aOperacaoDados[$iSeparacaoID]['separacao_carga_itens'][$oSeparacaoCargaItem->id] = $oSeparacaoCargaItem;

            }
        }

        $aOperacaoDados = json_decode(json_encode($aOperacaoDados));

        return $aOperacaoDados;
    }

    public static function manageAction($oThat, $iOSID, $sAction)
    {
        $oResponse = new ResponseUtil();
        $aData = $oThat->request->getData();

        if ($sAction === 'separar')
            return ActionSeparar::doSeparacao($aData, $iOSID);
        elseif ($sAction === 'estornar')
            return ActionEstornar::doEstorno($aData, $iOSID);

        return $oResponse
            ->setMessage('Ação não encontrada!')
            ->setJsonResponse($oThat);
    }

    public static function getDadosOperacaoSeparacao($oOrdemServico = null, $iOSID = null)
    {
        if (!$oOrdemServico && !$iOSID)
            ErrorUtil::custom('Não foi possível obter o ID da OS!');

        if (!$oOrdemServico)
            $oOrdemServico = LgDbUtil::getFind('OrdemServicos')
            ->contain([
                'OrdemServicoSeparacaoCargas' => [
                    'SeparacaoCargas' => [
                        'SeparacaoCargaItens' => [
                            'SeparacaoCargas',
                            'Produtos' => [
                                'UnidadeMedidas'
                            ]
                        ]
                    ]
                ]
            ])
            ->where(['id' => $iOSID])
            ->first();

        $aSeparacaoCargas = self::getArrayOperacao($oOrdemServico->ordem_servico_separacao_cargas);
        $aDadosOperacao   = EstoqueEndereco::getBestEnderecos($aSeparacaoCargas, $iOSID);
        $aDadosOperacao['ordem_servico_id'] = $oOrdemServico->id;
        $aDadosOperacao   = OrdemServicoItemSeparacao::getItensSeparados($aDadosOperacao);
        $aDadosOperacao   = ObjectUtil::getAsObject($aDadosOperacao);

        return $aDadosOperacao;
    }

    public static function getDadosOperacaoBySeparacaoObject($oSeparacaoCarga)
    {
        $oDataFakeOrdemServicoSeparacao = new ClosureAsMethodClass;
        $oDataFakeOrdemServicoSeparacao->separacao_carga = $oSeparacaoCarga;
        $aData = [ $oDataFakeOrdemServicoSeparacao ];

        $aSeparacaoCargas = self::getArrayOperacao($aData);
        $aDadosOperacao   = @EstoqueEndereco::getBestEnderecos($aSeparacaoCargas);

        return $aDadosOperacao;
    }

    public static function getItensSeparadosOperacao($oSeparacaoCarga, $iOSID)
    {
        if (!$iOSID)
            return [];

        $oDataFakeOrdemServicoSeparacao = new ClosureAsMethodClass;
        $oDataFakeOrdemServicoSeparacao->separacao_carga = $oSeparacaoCarga;
        $aData = [ $oDataFakeOrdemServicoSeparacao ];

        $aSeparacaoCargas = self::getArrayOperacao($aData);
        $aDadosOperacao   = @EstoqueEndereco::getBestEnderecos($aSeparacaoCargas, $iOSID);

        $aDadosOperacao['ordem_servico_id'] = $iOSID;
        $aDadosOperacao = OrdemServicoItemSeparacao::getItensSeparados($aDadosOperacao);
        
        return $aDadosOperacao;
    }

    public static function getPercentualSeparado($aDadosOperacao)
    {
        $dPercentualSeparado = 0.00;

        if (!@$aDadosOperacao['enderecos_ordenados']['informativos']['separados'])
            return $dPercentualSeparado;

        $aReturn = self::getPercentuaisSeparadosPorProduto($aDadosOperacao);


        $aProdutoQtdeSeparada = $aReturn['produto_qtde_separada'];
        $aProdutoQtdeSeparar  = $aReturn['produto_qtde_separar'];

        $dQtdeTotalSeparada = 0.00;
        $dQtdeTotalSeparar  = 0.00;

        foreach ($aProdutoQtdeSeparada as $dQtdeSeparada) {
            $dQtdeTotalSeparada += $dQtdeSeparada;
        }

        foreach ($aProdutoQtdeSeparar as $dQtdeSeparar) {
            $dQtdeTotalSeparar += $dQtdeSeparar;
        }

        return DoubleUtil::fromDBUnformat(($dQtdeTotalSeparada / $dQtdeTotalSeparar) * 100);
    }

    public static function getPercentuaisSeparadosPorProduto($aDadosOperacao)
    {
        $aProdutoQtdeSeparada = [];
        $aProdutoQtdeSeparar = [];

        foreach ($aDadosOperacao['enderecos_ordenados']['informativos']['separados'] as $aDataSeparacao) {
            if (array_key_exists($aDataSeparacao['produto']->id, $aProdutoQtdeSeparada)) {
                $aProdutoQtdeSeparada[$aDataSeparacao['produto']->id] += $aDataSeparacao['qtde_separada'];
            }else {
                $aProdutoQtdeSeparada[$aDataSeparacao['produto']->id] = $aDataSeparacao['qtde_separada'];
            }
        }

        foreach ($aDadosOperacao['referencias_produtos'] as $sProdutoKey => $aDataSeparar) {
            if (array_key_exists($aDataSeparar['produto']->id, $aProdutoQtdeSeparar)) {
                $aProdutoQtdeSeparar[$aDataSeparar['produto']->id] += $aDataSeparar['qtde_total_pedido_real'];
            }else {
                $aProdutoQtdeSeparar[$aDataSeparar['produto']->id] = $aDataSeparar['qtde_total_pedido_real'];
            }
        }

        return [
            'produto_qtde_separada' => $aProdutoQtdeSeparada,
            'produto_qtde_separar' => $aProdutoQtdeSeparar,
        ];
    }
}
