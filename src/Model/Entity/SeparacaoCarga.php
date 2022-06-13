<?php
namespace App\Model\Entity;

use App\RegraNegocio\OrdemServico\SeparacaoCargas\CheckPreReservaSeparacoes;
use App\Util\ArrayUtil;
use App\Util\EntityUtil;
use App\Util\ResponseUtil;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * SeparacaoCarga Entity
 *
 * @property int $id
 * @property string|null $codigo_pedido
 * @property string|null $numero_pedido
 * @property int $cliente_id
 *
 * @property \App\Model\Entity\Empresa $empresa
 * @property \App\Model\Entity\SeparacaoCargaItem[] $separacao_carga_itens
 */
class SeparacaoCarga extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     *   'codigo_pedido' => true,
     *   'numero_pedido' => true,
     *   'cliente_id' => true,
     *   'data_recepcao' => true,
     *   'empresa' => true,
     *   'separacao_carga_itens' => true,
     *   'separacao_situacao_id' => true,
     *   'separacao_carga_operadores' => true,
     *   'separacao_situacao' => true,
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function delete($aSeparacaoIDs)
    {
        $oResponse = new ResponseUtil;
        $iCount = 0;

        foreach ($aSeparacaoIDs as $key => $iSeparacaoID) {
            $oSeparacao = TableRegistry::get('SeparacaoCargas')->find()
                ->where(['id' => $iSeparacaoID])
                ->first();

            if (!$oSeparacao) 
                return $oResponse->setMessage('A Separação "'.$iSeparacaoID.'" não foi encontrada!');

            TableRegistry::get('SeparacaoCargas')->delete($oSeparacao);

            $iCount++;
        }

        return $oResponse
            ->setMessage('No total, ' . $iCount . ' Separação(ões) Deletadas(s) com sucesso!')
            ->setStatus(200)
            ->setDataExtra(['refresh' => true])
            ->getArray();
    }

    public static function gerarOs($aSeparacaoIDs)
    {
        $oResponse = new ResponseUtil;
        $oOrdemServico = new OrdemServico;
        $aData = [
            'retroativo' => 0,
            'ordem_servico_tipo_id' => EntityUtil::getIdByParams('OrdemServicoTipos', 'descricao', 'Separação', true)
        ];

        $oResponse = CheckPreReservaSeparacoes::checkSaldoPedidos($aSeparacaoIDs);
      
        if ($oResponse->getStatus() != 200)
            return $oResponse;

        $aResponse = $oOrdemServico->gerarOS(null, $aData);
        $iOSID = ArrayUtil::getDepth($aResponse, ['dataExtra', 'id']);

        if ($aResponse['status'] != 200)
            return $oResponse->setStatus($aResponse['status'])->setMessage($aResponse['message']);

        if (!$iOSID)
            return $oResponse->setStatus(401)->setMessage('Não foi possível criar a OS, favor contatar o suporte técnico!');

        $bResponse = OrdemServicoSeparacaoCarga::createLink($iOSID, $aSeparacaoIDs);

        if (!$bResponse)
            return $oResponse->setStatus(401)->setMessage('Não foi possível vincular todas as separações, favor contatar o suporte técnico!');
        
        return $oResponse
            ->setMessage('Ordem de Serviço #' . $iOSID . ' gerada com sucesso!')
            ->setStatus(200)
            ->setDataExtra(['refresh' => true])
            ->getArray();
    }

    public static function getSeparacoesComItensPosicionados($iFormacaoCargaVolumeID)
    {
        $oTable = TableRegistry::get('OrdemServicoItemSeparacoes');
        $oTableFind = TableRegistry::get('OrdemServicoItemSeparacoes')->find();
        
        $sSqlSubquery = 
            '(SELECT COALESCE(SUM(fcvi.quantidade), 0)
                FROM formacao_carga_volume_itens fcvi
               WHERE fcvi.ordem_servico_item_separacao_id = OrdemServicoItemSeparacoes.id
               GROUP BY fcvi.ordem_servico_item_separacao_id)';
        
        
        $oSubquery = $oTableFind->newExpr()->add(
            '(
                COALESCE('.$sSqlSubquery.', 0)
             )'
        );
        
        $aOSItensSeparacoes = $oTableFind
            ->select(TableRegistry::get('OrdemServicoItemSeparacoes'))
            ->select(TableRegistry::get('SeparacaoCargaItens'))
            ->select(TableRegistry::get('SeparacaoCargas'))
            ->select(TableRegistry::get('Produtos'))
            ->select(TableRegistry::get('UnidadeMedidas'))
            ->select([
                'qtde_utilizada' => $oTable->find()->newExpr()->add(
                    '(
                        COALESCE('.$sSqlSubquery.', 0)
                     )'
                )
            ])
            ->contain([
                'SeparacaoCargaItens' => [
                    'SeparacaoCargas'
                ],
                'Produtos',
                'UnidadeMedidas',
                'OrdemServicos'
            ])
            ->where([
                'SeparacaoCargas.separacao_situacao_id NOT IN' => [ 5, 3 ], //Planejado, Recusado
                'OrdemServicoItemSeparacoes.qtde_saldo >' => $oSubquery,
                'OrdemServicoItemSeparacoes.endereco_separacao_id IS NOT NULL',
                'OrdemServicos.cancelada IS NOT' => 1 
            ])
            ->toArray();

        $aSeparacoesAgroup = [];

        foreach ($aOSItensSeparacoes as $oOrdemServicoItemSeparacao) {
            $aSeparacoesAgroup[$oOrdemServicoItemSeparacao->separacao_carga_item->separacao_carga_id]['separacao_carga'] = $oOrdemServicoItemSeparacao->separacao_carga_item->separacao_carga;
            $aSeparacoesAgroup[$oOrdemServicoItemSeparacao->separacao_carga_item->separacao_carga_id]['itens'][] = $oOrdemServicoItemSeparacao;
        }

        return $aSeparacoesAgroup;
    }

    public static function getFilters()
    {
        return [
            [
                'name'  => 'cliente',
                'divClass' => 'col-lg-2',
                'label' => 'Cliente',
                'table' => [
                    'className' => 'Empresas',
                    'field'     => 'descricao',
                    'operacao'  => 'contem'
                ]
            ],
            [
                'name'  => 'numero_pedido',
                'divClass' => 'col-lg-2',
                'label' => 'Nº Pedido',
                'table' => [
                    'className' => 'SeparacaoCargas',
                    'field'     => 'numero_pedido',
                    'operacao'  => 'contem'
                ]
            ],
            [
                'name'  => 'data_recepcao',
                'divClass' => 'col-xs-6',
                'label' => 'Data Recepção',
                'table' => [
                    'className' => 'SeparacaoCargas',
                    'field'     => 'data_recepcao',
                    'operacao'  => 'entre',
                    'type'      => 'date',
                ]
            ],
            [
                'name'  => 'situacao',
                'divClass' => 'col-lg-2',
                'label' => 'Situação',
                'table' => [
                    'className' => 'SeparacaoSituacoes',
                    'field'     => 'descricao',
                    'operacao'  => 'contem',
                    'typeVar'   => 'string'
                ]
            ]
        ];
    }
}