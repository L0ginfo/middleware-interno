<?php
namespace LogPluginColetores\RegraNegocio\ColetorMaritimo;

use App\Model\Entity\DocumentosMercadoria;
use App\Model\Entity\Empresa;
use App\RegraNegocio\GerenciamentoEstoque\DecrementoEstoqueProdutos;
use App\RegraNegocio\GerenciamentoEstoque\IncrementoEstoqueProdutos;
use App\RegraNegocio\GerenciamentoEstoque\ProdutosControlados;
use App\Util\DoubleUtil;
use App\Util\EntityUtil;
use App\Util\LgDbUtil;
use App\Util\SessionUtil;
use App\Util\UniversalCodigoUtil;
use Cake\Http\Client\Response;
use Cake\Log\Log;
use Cake\ORM\TableRegistry;
use Empresas;
use Util\Core\ResponseUtil;

class ColetorMaritimosLingadasManager 
{

    private $OrdemServicoItemLingadasTable;

    public function __construct()
    {
        $this->OrdemServicoItemLingadasTable = TableRegistry::getTableLocator()
            ->get('OrdemServicoItemLingadas');

        $this->oColetorMaritimoManager =  new ColetorMaritimoManager();

    } 


    /**
     * adicionar function
     *
     * @param [type] $aData
     * @return ResposeUtil
     */
    public function adicionar($aData){
        $oResponseUtil = new ResponseUtil();
        
        $aData['peso'] = DoubleUtil::toDBUnformat(@$aData['peso']);

        if(empty($aData['placa'])){
            return $oResponseUtil->setMessage('Informe aplaca do veículo.');
        }

        if(empty($aData['porao_id'])){
            return $oResponseUtil->setMessage('Porão está vazio.');
        }

        if(empty($aData['operador_portuario_id'])){
            return $oResponseUtil->setMessage('Operador Portuário inválido.');
        }
        
        $aData = self::setCaracteristicaCliente($aData);        
       
        $oPlanoCarga = self::getPlanoCarga($aData);

        if(empty($oPlanoCarga)){
            return $oResponseUtil->setMessage('Identificador de plano de carga inválido.');
        }

        $oPlanejamento = LgDbUtil::getFirst('PlanejamentoMaritimos',[
            'id' => $oPlanoCarga->planejamento_maritimo_id
        ]);

        $oTernoAssociado = self::getTernoAssociado($aData);

        if(empty($oTernoAssociado)){
            return $oResponseUtil->setMessage('Solicite ao setor de Operações para associar sua turma de trabalho.');
        }

        $aData = self::doPoraoRules($aData);
        $oProduto = self::getProduto($aData, $oPlanoCarga);

        if(empty($oProduto)){
            return $oResponseUtil->setMessage('Produto inválido.');
        }

        $oOrdemServico = self::getOrdemServico($oPlanoCarga);

        if(empty($oOrdemServico)){
            return $oResponseUtil->setMessage(
                "Falha ao localizar a ordem de serviço do planejamento marítimo $oPlanejamento->numero.");
        }

        $oResv = self::getLastResvOfVehicle($aData['placa'], $oPlanoCarga->planejamento_maritimo_id);

        if(empty($oResv)){
            return $oResponseUtil->setMessage(
                "O operador do gate vinculou esse veículo " .$aData['placa']. " para outro navio. Solicite para alterar o vinculo para o navio " . $oPlanoCarga->planejamento_maritimo->veiculo->descricao . "."
            );
        }

        $bDocumentacaoObrigatoria = self::bDocumentacaoObrigatoria(
            $oPlanoCarga);

        $oPeriodo = UniversalCodigoUtil::getPortoTrabalhoPeriodoAtual();

        return $this->add([
            'cliente_id' => @$aData['cliente_id'],
            'operador_portuario_id' => $aData['operador_portuario_id'],
            'planejamento_maritimo_id' => $oPlanoCarga->planejamento_maritimo_id,
            'porao_id' => $aData['porao_id'],
            'plano_carga_id' =>  $oPlanoCarga->id,
            'resv_id'=> $oResv->id,
            'ordem_servico_id'=> $oOrdemServico->id,
            'codigo' => $oProduto->codigo,
            'produto_id'=> $oProduto->id,
            'sentido_id' => $oPlanoCarga->sentido_id,
            'terno_id' => $oTernoAssociado->terno_id,
            'periodo_id' =>$oPeriodo->id,
            'documentacao_obrigatoria' => $bDocumentacaoObrigatoria,
            'sentido' => @$oPlanoCarga->sentido->codigo,
            'quantidade'=> @$aData['qtde'],
            'peso'=> @$aData['peso'],
            'porao_origem'=> @$aData['porao_origem'],
            'aCaracteristicas' => @$aData['plano_carga_caracteristicas'],
            'mostra_codigo' => $aData['mostra_codigo'] ,
            'mostra_qtd' => $aData['mostra_qtd'] ,  
            'mostra_peso' => $aData['mostra_peso'] ,
            'valida_media' => $aData['valida_media'] ,
            'mostra_porao_origem' => $aData['mostra_porao_origem'] ,
            'media_quantidade' => @$aData['media_quantidade'],
            'media_peso' => @$aData['media_peso'],
        ]);
    }


    private function valideAmount(&$aData, $oPlanoCargaPoroes){

        
        $oResponseUtil = new ResponseUtil();
        $iAmount = $aData['quantidade']?:0;
        $iAvailable = 0;

        $iAvailable = $oPlanoCargaPoroes->qtde_prevista ?:0;
        foreach ($oPlanoCargaPoroes->ordem_servico_item_lingadas as $key => $oOrdemServicoItemLingada) {
            $iAvailable = $iAvailable - $oOrdemServicoItemLingada->qtde;
        }

        if($iAvailable <= 0){
            $oResponseUtil->setMessage('Falha ao adicionar o registro, quantidade disponível: 0.000.');
        }

        if($iAmount <= 0){
            $iAmount = $aData['quantidade'] = $iAvailable;
        }
        
        if($iAmount > 0 && $iAmount <= $iAvailable){
            return $oResponseUtil->setStatus(200);
        }

        $iAvailable = DoubleUtil::format($iAvailable, 3);

        return  $oResponseUtil->setMessage('Falha ao adicionar o registro, quantidade disponível: '.$iAvailable.'.');
    }

    public static function getLastResvOfVehicle($sPlate, $iPlanejamento){

        $oResv = LgDbUtil::getFind('Resvs')
            ->innerJoinWith('Veiculos')
            ->where([
                'Veiculos.veiculo_identificacao' => $sPlate,
                'Resvs.data_hora_saida is' => null
            ])
            ->max('id');

        $oExisteVinculado = LgDbUtil::getFirst('ResvPlanejamentoMaritimos', [
            'resv_id' => $oResv->id
        ]);

        if(empty($oExisteVinculado)) return $oResv;

        $oVinculadoPm = LgDbUtil::getFirst('ResvPlanejamentoMaritimos', [
            'resv_id' => $oResv->id,
            'planejamento_maritimo_id' => $iPlanejamento
        ]);

        if(!empty($oVinculadoPm)) return $oResv;

        return null;
    }

    public static function validaAllCounts($aData, $aPlanoCargaPoroes)
    {
        $oResponse = new ResponseUtil();
        $dQtdeRetirar = @$aData['quantidade'] ?: 0;
        $dQtdeUtilizada = 0.0;
        $dQtdeTotalPrevista = 0.0;

        foreach ($aPlanoCargaPoroes as $oPlanoCargaPorao) {
            $dQtdeTotalPrevista += $oPlanoCargaPorao->qtde_prevista;
            foreach ($oPlanoCargaPorao->ordem_servico_item_lingadas as $oOrdemServicoItemLingada) {
                $dQtdeUtilizada += $oOrdemServicoItemLingada->qtde;
            }
            if ($oPlanoCargaPorao->permite_ultrapassar_limite_previsto) {
                return $oResponse->setStatus(200);
            }
        }

        $dQtdeRetirar = round($dQtdeRetirar, 2);
        $dQtdeTotalPrevista = round($dQtdeTotalPrevista, 2);
        $dQtdeUtilizada = round($dQtdeUtilizada, 2);

        if ($dQtdeRetirar + $dQtdeUtilizada > $dQtdeTotalPrevista)
            return $oResponse
                ->setMessage('Ops! Já foram utilizados ' . DoubleUtil::fromDBUnformat($dQtdeUtilizada) 
                    . ', de um total de '  . DoubleUtil::fromDBUnformat($dQtdeTotalPrevista) . ' previsto! Você está tentando retirar '  . DoubleUtil::fromDBUnformat($dQtdeRetirar));

        return $oResponse
            ->setStatus(200);
    }

    public function saveOrdemServicoItemLingadas($oEntity, $aData)
    {
        $oResponseUtil = new ResponseUtil;

        if($oOrdemServicoItemLingadas = $this->OrdemServicoItemLingadasTable->save($oEntity)){
            self::saveCaracteristicas($oEntity, $aData);
            $sMensagem = ColetorMaritimosLingadasManager::doMensagem($aData, true);
            $oColetorMaritimoManager = new ColetorMaritimoManager();
            $sMensagem = self::doMensagem($aData, true);
            $oPlanoCarga = $oColetorMaritimoManager
                ->getPlanoCarga($aData['plano_carga_id'], $aData['porao_id']);
            $iTempoParalisacao = $oColetorMaritimoManager
                ->getTimestampParalisacao($aData['planejamento_maritimo_id']);
            $oResv = $oColetorMaritimoManager
                ->getResvById($oEntity->resv_id);
            $oResponseUtil
                ->setMessage($sMensagem)
                ->setDataExtra([
                'oPlanoCarga' => $oPlanoCarga,
                'iTempoParalisacao' => $iTempoParalisacao,
                'oResv' =>$oResv
            ]);
            
            $aData['aLingadas'] = [$oOrdemServicoItemLingadas];
            $oResponse = $this->doNewLingadaEstoques($aData);

            if($oResponse->getStatus() == 200){
                $this->setLocal([$oOrdemServicoItemLingadas], $oResponse->getDataExtra());
                $oResponseUtil->setStatus(200);
                $oResponseUtil->setTitle('Sucesso'); 
                $oResponseUtil->setMessage(self::doMensagem($aData));    
            }else{
                $oResponseUtil->setTItle('Ops..');    
                $oResponseUtil->setMessage('Lingada salva com sucesso, porem não foi possível operar automaticamente o item no estoque.');  
            }

            return $oResponseUtil;
        }
    }

    private function saveFractions($aData, $aPlanoCargaPoroes)
    {
        $oResponseUtil = new ResponseUtil;
        $dQtdeRetirarInicial = @$aData['quantidade'] ?: 0;
        $dQtdeRetirar = @$aData['quantidade'] ?: 0;
        $dQtdeUtilizada = 0.0;
        $aOrdemServicoLingadas = [];

        foreach ($aPlanoCargaPoroes as $oPlanoCargaPorao) {
            $dQtdeUtilizada = 0.0;

            foreach ($oPlanoCargaPorao->ordem_servico_item_lingadas as $oOrdemServicoItemLingada) {
                $dQtdeUtilizada += $oOrdemServicoItemLingada->qtde;
            }

            //dump('$dQtdeRetirar 0: ' . $dQtdeRetirar);
            //dump('$dQtdeUtilizada 1: ' . $dQtdeUtilizada);
            //dump('$oPlanoCargaPorao->qtde_prevista 2: ' . $oPlanoCargaPorao->qtde_prevista);

            $oPlanoCargaPorao->qtde_disponivel = $oPlanoCargaPorao->qtde_prevista - $dQtdeUtilizada;

            //dump('$oPlanoCargaPorao->qtde_disponivel 3: ' . $oPlanoCargaPorao->qtde_disponivel);

            if ($oPlanoCargaPorao->qtde_disponivel <= 0) {
                $oPlanoCargaPorao->qtde_disponivel = 0;
                continue;
            }

            if ($dQtdeRetirar < $oPlanoCargaPorao->qtde_disponivel) {
                $oPlanoCargaPorao->qtde_retirar = $dQtdeRetirar;
                $dQtdeRetirar = 0;
            }else {
                $oPlanoCargaPorao->qtde_retirar = $oPlanoCargaPorao->qtde_disponivel;
                $dQtdeRetirar -= $oPlanoCargaPorao->qtde_disponivel;
            }

            //dump('$oPlanoCargaPorao->qtde_retirar 4: ' . $oPlanoCargaPorao->qtde_retirar);

            //dump('$dQtdeRetirar 5: ' . $dQtdeRetirar);

            if (!$dQtdeRetirar)
                break;
        }

        foreach ($aPlanoCargaPoroes as $oPlanoCargaPorao) {

            if (!$oPlanoCargaPorao->qtde_retirar && !$dQtdeRetirar && !$oPlanoCargaPorao->permite_ultrapassar_limite_previsto)
                continue;

            if ($dQtdeRetirar && $oPlanoCargaPorao->permite_ultrapassar_limite_previsto && !$oPlanoCargaPorao->qtde_retirar)
                $aData['quantidade'] = $dQtdeRetirar;
            elseif ($oPlanoCargaPorao->qtde_retirar)
                $aData['quantidade'] = $oPlanoCargaPorao->qtde_retirar;
            else
                continue;
            
            $oEntity = $this->newEntity($aData, $oPlanoCargaPorao);

            $oResponseUtil = $this->saveOrdemServicoItemLingadas($oEntity, $aData);

            if ($oResponseUtil->getStatus() != 200)
                return $oResponseUtil;

            $aOrdemServicoLingadas[] = $oEntity;
        }

        $aDataExtra = $oResponseUtil->getDataExtra() ?: [];
        $oResponseUtil->setDataExtra( $aDataExtra + ['ordem_servico_lingadas' => $aOrdemServicoLingadas]);

        return $oResponseUtil
            ->setStatus(200);
    }
    
    private function add($aData){

        $oResponseUtil = new ResponseUtil();
        $aPlanoCargaPoroes = [];
        $bReturnAll = @$aData['quantidade'] ? true : false;
        if ($bReturnAll) {
            $aPlanoCargaPoroes = self::getPlanoCargaPorao($aData, true);
            $oResponse = self::validaAllCounts($aData, $aPlanoCargaPoroes);
        }else {
            $oPlanoCargaPorao = self::getPlanoCargaPorao($aData);

            if(empty($oPlanoCargaPorao)){
                $oResponseUtil = new ResponseUtil();
                return $oResponseUtil->setMessage(
                    "O produto ".$aData['produto_id'].' não econtra-se no porão selecionado.');
            }

            if ($oPlanoCargaPorao->permite_ultrapassar_limite_previsto) {
                $oResponse =  $oResponseUtil->setStatus(200);
            } else {
                $oResponse  = $this->valideAmount($aData, $oPlanoCargaPorao);
            }

        }

        if($oResponse->getStatus() != 200){
            return $oResponse;
        }

        $aOrdemServicoLingadas = [];

        if ($bReturnAll) {
            $oResponseUtil = $this->saveFractions($aData, $aPlanoCargaPoroes);
            $aOrdemServicoLingadas = @$oResponseUtil->getDataExtra()['ordem_servico_lingadas'];
        }else {
            $oEntity = $this->newEntity($aData, $oPlanoCargaPorao);
            $oResponseUtil = $this->saveOrdemServicoItemLingadas($oEntity, $aData);
            $aOrdemServicoLingadas[] = $oEntity;
        }

        if ($oResponseUtil->getStatus() != 200)
            return $oResponseUtil
                ->setMessage('Falha ao salvar a ordem serviço item lingada.');

        $aDataExtra = $oResponseUtil->getDataExtra() ?: [];
        $oResponseUtil->setDataExtra( $aDataExtra + ['aOrdemServicoItemLingadas' => $aOrdemServicoLingadas]);
        
        return $oResponseUtil;
    }

    public static function getPlanoCargaPorao($aData, $bReturnAll = false){

        $oQuery = LgDbUtil::getFind('PlanoCargaPoroes');

        if(!empty($aData['aCaracteristicas'])){

            $iTotal = sizeof($aData['aCaracteristicas']);
            $aIds = array_map(function($value){return $value['caracteristica_id'];}, $aData['aCaracteristicas']);

            $oQuery->innerJoinWith('PlanoCargaPoraoCaracteristicas')
                ->order(['PlanoCargaPoroes.id'])
                ->group(['PlanoCargaPoroes.id'])
                ->where(['PlanoCargaPoraoCaracteristicas.caracteristica_id IN' => $aIds])
                ->having(['COUNT(PlanoCargaPoraoCaracteristicas.caracteristica_id)' => $iTotal]);
        }

        if(!$aData['documentacao_obrigatoria']){

            $oResult =  $oQuery
                ->contain(['OrdemServicoItemLingadas'])
                ->where([
                    'PlanoCargaPoroes.produto_id' => $aData['produto_id'],
                    'PlanoCargaPoroes.plano_carga_id' => $aData['plano_carga_id'],
                    'PlanoCargaPoroes.porao_id' => $aData['porao_id'],
                    'cancelado' => 0
                ])
                ->first();

            return $oResult;
        }

        $oQuery->contain([
                'OrdemServicoItemLingadas',
                'DocumentosMercadoriasItens' =>[
                    'Produtos' => function ($q) use($aData){
                        return $q->where([
                           'Produtos.id' => $aData['produto_id']
                        ]);
                    },
                    'DocumentosMercadorias.PlanoCargaDocumentos'=> function ($q) use($aData){
                        return $q->where([
                            'PlanoCargaDocumentos.plano_carga_id' => $aData['plano_carga_id'],
                            'PlanoCargaDocumentos.operador_portuario_id' => $aData['operador_portuario_id']
                        ]);
                    }
                ]
            ])
            ->matching('DocumentosMercadoriasItens.Produtos', function ($q) use($aData){
                return $q->where([
                   'Produtos.id' => $aData['produto_id']
                ]);
            })
            ->matching('DocumentosMercadoriasItens.DocumentosMercadorias.PlanoCargaDocumentos', 
                function ($q) use($aData){
                return $q->where([
                    'PlanoCargaDocumentos.plano_carga_id' => $aData['plano_carga_id'],
                    'PlanoCargaDocumentos.operador_portuario_id' => $aData['operador_portuario_id']
                ]);
            });

            if(isset($aData['cliente_id'])){
                $oQuery->matching('DocumentosMercadoriasItens.DocumentosMercadorias', function ($q) use($aData){
                    return $q->where(['DocumentosMercadorias.cliente_id' => $aData['cliente_id']]);
                });
            }

            $aResult = $oQuery->where([
                'PlanoCargaPoroes.plano_carga_id' => $aData['plano_carga_id'], 
                'PlanoCargaPoroes.cancelado' => 0,
                'PlanoCargaPoroes.porao_id' => $aData['porao_id'],
            ]);

            $aResult = $bReturnAll 
                ? $oQuery->toArray()
                : $oQuery->first();

            return $aResult;
    }

    public function newEntity($aData, $oPlanoCargaPoroes){

        $oPlanoCargaItemDestinos = TableRegistry::getTableLocator()
            ->get('PlanoCargaItemDestinos')
            ->find()
            ->where([
                'plano_carga_id' => 
                    @$oPlanoCargaPoroes->plano_carga_id,
                'documento_mercadoria_item_id' => 
                    @$oPlanoCargaPoroes->documento_mercadoria_item_id,
                'destino' => 1
            ])
            ->first();

            $oSumPorOperadorProduto = LgDbUtil::getFind('PlanoCargaPoroes')
                ->select([
                    'total_tonelagem' => 'SUM(PlanoCargaPoroes.tonelagem)',
                    'total_prevista' => 'SUM(PlanoCargaPoroes.qtde_prevista)',
                ])
                ->where([
                    'PlanoCargaPoroes.operador_id IS' => $oPlanoCargaPoroes->operador_id,
                    'PlanoCargaPoroes.produto_id IS' => $oPlanoCargaPoroes->produto_id,
                    'PlanoCargaPoroes.plano_carga_id IS' => $oPlanoCargaPoroes->plano_carga_id,
                ])
                ->first();

            $dSumTonelagemPorOperadorProduto = (double) @$oSumPorOperadorProduto->total_tonelagem;
            $dSumPrevistaPorOperadorProduto = (double) @$oSumPorOperadorProduto->total_prevista;
            
            $aEntity['codigo'] = $aData['codigo'];
            $aEntity['sentido_id'] = $aData['sentido_id'];
            $aEntity['ordem_servico_id'] = $aData['ordem_servico_id'];
            $aEntity['terno_id'] = @$aData['terno_id'];
            $aEntity['periodo_id'] = @$aData['periodo_id'];
            $aEntity['resv_id'] = $aData['resv_id'];
            $aEntity['plano_carga_porao_id'] = $oPlanoCargaPoroes->id;
            $aEntity['produto_id'] = $aData['produto_id'];
            $aEntity['local_id'] = @$oPlanoCargaItemDestinos->local_id?:NULL;
            $aEntity['destino'] = @$oPlanoCargaItemDestinos->local_id?1:0;
            $aEntity['cliente_id'] = @$aData['cliente_id'];
            $aEntity['operador_portuario_id'] = @$aData['operador_portuario_id'];
            $aEntity['qtde'] = @$aData['quantidade']?:0;

            if ($dSumTonelagemPorOperadorProduto && $dSumPrevistaPorOperadorProduto)
                $fTonelagem = DoubleUtil::format(($dSumTonelagemPorOperadorProduto * $aEntity['qtde'])/$dSumPrevistaPorOperadorProduto, 3);
            else
                $fTonelagem = DoubleUtil::format(($oPlanoCargaPoroes->tonelagem * $aEntity['qtde'])/$oPlanoCargaPoroes->qtde_prevista, 3);
            
            $aEntity['peso'] = @$aData['peso'] ?:$fTonelagem;
            $aEntity['porao_origem'] = @$aData['porao_origem'];

            if(@$aData['sentido'] == 'EMBARQUE' && isset($aEntity['local_id'])){
                $oDocItem = $oPlanoCargaPoroes->documentos_mercadorias_item;
                $sLoteCodigo = $this->getLoteCodigo($oDocItem->documentos_mercadoria);
                $sLoteItem = $this->getLoteItem($oDocItem);

                $aQuery = ProdutosControlados::getProdutoControlesValuesToQuery([
                    'produto_id' => $oDocItem->produto_id,
                    'unidade_medida_id' => $oDocItem->unidade_medida_id,
                    'lote_codigo' => $sLoteCodigo,
                    'lote_item'   => $sLoteItem,
                ]);

                $oEtiquetaProduto = LgDbUtil::getFirst('EtiquetaProdutos', $aQuery);
                $aEntity['lote_codigo'] = @$oEtiquetaProduto['lote_codigo'];
                $aEntity['lote_item'] = @$oEtiquetaProduto['lote_item'];
                $aEntity['endereco_id'] = @$oEtiquetaProduto['endereco_id'];
            }

        return $this->OrdemServicoItemLingadasTable->newEntity($aEntity);
    }

    private function getPlanoCargaPoroes($aData){

        if(!$aData['documentacao_obrigatoria']){

            return LgDbUtil::getFind('PlanoCargaPoroes')
                ->contain(['PlanoCargaPackingLists', 'OrdemServicoItemLingadas'])
                ->where([
                    'PlanoCargaPackingLists.produto_codigo' => $aData['codigo'],
                    'PlanoCargaPoroes.plano_carga_id' => $aData['plano_carga_id'],
                    'PlanoCargaPoroes.porao_id' => $aData['porao_id'],
                    'cancelado' => 0
                ])
                ->order('qtde_prevista')
                ->toArray();

        }

        $oQuery = LgDbUtil::getFind('PlanoCargaPoroes')
            ->contain([
                'OrdemServicoItemLingadas',
                'DocumentosMercadoriasItens' =>[
                    'Produtos' => function ($q) use($aData){
                        return $q->where([
                           'Produtos.id' => $aData['produto_id']
                        ]);
                    },
                    'DocumentosMercadorias.PlanoCargaDocumentos'=> function ($q) use($aData){
                        return $q->where([
                            'PlanoCargaDocumentos.plano_carga_id' => $aData['plano_carga_id'],
                            'PlanoCargaDocumentos.operador_portuario_id' => $aData['operador_portuario_id']
                        ]);
                    }
                ]
            ])
            ->matching('DocumentosMercadoriasItens.Produtos', function ($q) use($aData){
                return $q->where([
                   'Produtos.id' => $aData['produto_id']
                ]);
            })
            ->matching('DocumentosMercadoriasItens.DocumentosMercadorias.PlanoCargaDocumentos', 
                function ($q) use($aData){
                return $q->where([
                    'PlanoCargaDocumentos.plano_carga_id' => $aData['plano_carga_id'],
                    'PlanoCargaDocumentos.operador_portuario_id' => $aData['operador_portuario_id']
                ]);
            });

            if($aData['cliente_obrigatorio']){
                $oQuery->matching('DocumentosMercadoriasItens.DocumentosMercadorias', function ($q) use($aData){
                    return $q->where(['DocumentosMercadorias.cliente_id' => $aData['cliente_id']]);
                });
            }

            $aResult = $oQuery->where([
                'PlanoCargaPoroes.plano_carga_id' => $aData['plano_carga_id'], 
                'PlanoCargaPoroes.cancelado' => 0,
                'PlanoCargaPoroes.porao_id' => $aData['porao_id'],
            ])
            ->order('qtde_prevista')
            ->toArray(); 

            return $aResult;
    }

    private function newEntities($aData, $aPlanoCargaPoroes){

        $aEntities = array();
        $iAmount = DoubleUtil::format((double) $aData['quantidade'], 3, '.', '');

        if(empty($aData['local_id']) && isset($aPlanoCargaPoroes[0])){

            $oPlanoCargaItemDestinos = TableRegistry::getTableLocator()
                ->get('PlanoCargaItemDestinos')
                ->find()
                ->where([
                    'plano_carga_id' => 
                        @$aPlanoCargaPoroes[0]->plano_carga_id,
                    'documento_mercadoria_item_id' => 
                        @$aPlanoCargaPoroes[0]->documento_mercadoria_item_id,
                    'destino' => 1
                ])
                ->first();

            $aData['destino'] = @$oPlanoCargaItemDestinos->local_id?1:0;
            $aData['local_id'] = @$oPlanoCargaItemDestinos->local_id?:NULL;
        }

        foreach ($aPlanoCargaPoroes as $key => $oPlanoCargaPoroes) {

            if($iAmount <= 0){
                break;
            }

            $iAvailable = $oPlanoCargaPoroes->qtde_prevista ?:0;

            foreach ($oPlanoCargaPoroes->ordem_servico_item_lingadas as $key => $oOrdemServicoItemLingada) {
                $iAvailable =$iAvailable - $oOrdemServicoItemLingada->qtde;
            }

            if($iAvailable > 0 && $iAmount > 0){

                $aEntity['codigo'] = $aData['codigo'];
                $aEntity['sentido_id'] = $aData['sentido_id'];
                $aEntity['ordem_servico_id'] = $aData['ordem_servico_id'];
                $aEntity['terno_id'] = @$oPlanoCargaPoroes->terno_id?:1;
                $aEntity['resv_id'] = $aData['resv_id'];
                $aEntity['plano_carga_porao_id'] = $oPlanoCargaPoroes->id;
                $aEntity['produto_id'] = $aData['produto_id'];
                $aEntity['local_id'] = @$aData['local_id'];
                $aEntity['destino'] = @$aData['destino'];
                $aEntity['cliente_id'] = @$aData['cliente_id'];
                $aEntity['operador_portuario_id'] = @$aData['operador_portuario_id'];

                if(@$aData['sentido'] == 'EMBARQUE' && isset($aData['local_id'])){
                    $oDocItem = $oPlanoCargaPoroes->documentos_mercadorias_item;
                    $sLoteCodigo = $this->getLoteCodigo($oDocItem->documentos_mercadoria);
                    $sLoteItem = $this->getLoteItem($oDocItem);

                    $aQuery = ProdutosControlados::getProdutoControlesValuesToQuery([
                        'produto_id' => $oDocItem->produto_id,
                        'unidade_medida_id' => $oDocItem->unidade_medida_id,
                        'lote_codigo' => $sLoteCodigo,
                        'lote_item'   => $sLoteItem,
                    ]);

                    $oEtiquetaProduto = LgDbUtil::getFirst('EtiquetaProdutos', $aQuery);

                    $aEntity['lote_codigo'] = @$oEtiquetaProduto['lote_codigo'];
                    $aEntity['lote_item'] = @$oEtiquetaProduto['lote_item'];
                    $aEntity['endereco_id'] = @$oEtiquetaProduto['endereco_id'];
                }

                if($iAvailable >= $iAmount){
                    $aEntity['qtde'] = $iAmount;
                    $iAmount =  $iAmount - $iAmount;
                }else{
                    $aEntity['qtde'] = $iAvailable;
                    $iAmount =  $iAmount - $iAvailable;
                }

                $oEntity = $this->OrdemServicoItemLingadasTable->newEntity($aEntity);
                array_push($aEntities, $oEntity);
            }
        } 
        
        return $aEntities;
    }

    public function remove($id){
        $oResponseUtil = new ResponseUtil();
        
        $oEntity = $this->OrdemServicoItemLingadasTable->get($id);

        $oRemocao =  LgDbUtil::getFirst('LingadaRemocoes', [
            'ordem_servico_item_lingada_id' => $id
        ]);

        if($oRemocao){
            return $oResponseUtil->setMessage('Existem Remoções vinculadas a Lingada.');
        }
        
        $aLingadaAvariasFotos = LgDbUtil::getFind('LingadaAvariaFotos')
            ->innerJoinWith('LingadaAvarias', function ($q) use($id){
                return $q->where(['LingadaAvarias.ordem_servico_item_lingada_id' => $id]);
            })
            ->toArray();

        if(!empty($aLingadaAvariasFotos)){
            foreach ($aLingadaAvariasFotos as $value) {
                LgDbUtil::get('LingadaAvariaFotos')->delete($value);
            }
        }

        $aLingadaAvarias =  LgDbUtil::getFirst('LingadaAvarias', [
            'ordem_servico_item_lingada_id' => $id
        ]);

        if(!empty($aLingadaAvarias)){
            LgDbUtil::get('LingadaAvarias')
                ->deleteAll(['ordem_servico_item_lingada_id' => $id]);
        }

        $aCaracteristicas = LgDbUtil::getFirst('LingadaCaracteristicas', [
            'ordem_servico_item_lingada_id' => $id
        ]);

        if(!empty($aCaracteristicas)){
            LgDbUtil::get('LingadaCaracteristicas')
                ->deleteAll(['ordem_servico_item_lingada_id' => $id]);
        }

        $oPlanoCargaPoroes = LgDbUtil::get('PlanoCargaPoroes')
            ->get($oEntity->plano_carga_porao_id, [
                'contain' => [
                    'PlanoCargas' => [
                        'PlanejamentoMaritimos' => 'TiposViagens',
                        'Sentidos'
                    ]
                ]
            ]);

        $iPlanejamentoMaritimo = @$oPlanoCargaPoroes->plano_carga->planejamento_maritimo_id;
        $bDocumentacao = self::bDocumentacaoObrigatoria($oPlanoCargaPoroes->plano_carga);
        $oSentido = $oPlanoCargaPoroes->plano_carga->sentido;
        $iResv = $oEntity->resv_id;

        if(empty($iPlanejamentoMaritimo)){
            return $oResponseUtil->setMessage('Falha ao remover a Lingada.');
        }

        $oResult = $this->doRemoveLingadaEstoques([
            'aLingadas' => [$oEntity],
            'produto_id' => $oEntity->produto_id,
            'plano_carga_id' => $oPlanoCargaPoroes->plano_carga_id,
            'porao_id' => $oPlanoCargaPoroes->porao_id,
            'documentacao_obrigatoria' => $bDocumentacao,
            'sentido' => $oSentido->codigo
        ]);

        if($oResult->getStatus() != 200) return $oResult;

        try {
            if($this->OrdemServicoItemLingadasTable->delete($oEntity)){
                $oColetorMaritimoManager = new ColetorMaritimoManager();
                $oPlanoCarga = $oColetorMaritimoManager
                    ->getPlanoCarga($oPlanoCargaPoroes->plano_carga_id, $oPlanoCargaPoroes->porao_id);
                $iTempoParalisacao = $oColetorMaritimoManager
                    ->getTimestampParalisacao($iPlanejamentoMaritimo);
                $oResv = $oColetorMaritimoManager
                    ->getResvById($iResv);
                $oResponseUtil->setStatus(200);
                $oResponseUtil->setMessage('Removido com sucesso.');
                $oResponseUtil->setDataExtra([
                    'oPlanoCarga' => $oPlanoCarga,
                    'iTempoParalisacao' =>  $iTempoParalisacao,
                    'oResv' => $oResv
                ]);
                return $oResponseUtil;
            };

        } catch (\Throwable $th) {

        }

        return $oResponseUtil->setMessage('Falha ao remover a Lingada.');
    }

    private function incrementStorage($aData){

        if(empty($aData['documentacao_obrigatoria'])){
            return (new ResponseUtil())
                ->setDataExtra([
                    'sDestino' => null,
                    'iEndereco' => null,
                    'iLocal' => null,
                    'lote_item' => null,
                    'lote_codigo' => null
                ])
                ->setStatus(200)
                ->setMessage('Item vai para o Cliente');
        }

        if(empty($aData['aLingadas'][0]['local_id'])){
            return (new ResponseUtil())
                ->setDataExtra([
                    'sDestino' => 'Cliente',
                    'iEndereco' => null,
                    'iLocal' => 0,
                    'lote_item' => null,
                    'lote_codigo' => null
                ])
                ->setStatus(200)
                ->setMessage('Item vai para o Cliente');
        }

        $aExtraConditions = [];
        
        if (@$aData['aLingadas'][0]->plano_carga_porao_id) {
            $oPlanoCargaPorao = LgDbUtil::getByID('PlanoCargaPoroes', $aData['aLingadas'][0]->plano_carga_porao_id);

            $aExtraConditions = $oPlanoCargaPorao->documento_mercadoria_item_id
                ? ['DocumentosMercadoriasItens.id' => $oPlanoCargaPorao->documento_mercadoria_item_id]
                : [];
        }

        $oDocumentosMercadoriasItens = TableRegistry::getTableLocator()
            ->get('DocumentosMercadoriasItens')
            ->find()
            ->contain(['DocumentosMercadorias', 'PlanoCargaPoroes' => function ($q) use($aData){
                    return $q->where([
                        'plano_carga_id' => $aData['plano_carga_id'],
                        'porao_id' => $aData['porao_id'],
                        'cancelado' => 0,
                    ]);
                }
            ])
            ->matching('PlanoCargaPoroes', function ($q) use($aData){
                return $q->where([
                    'plano_carga_id' => $aData['plano_carga_id'], 
                    'cancelado' => 0,
                    'porao_id' => $aData['porao_id']
                ]);
            })
            ->where( $aExtraConditions + ['DocumentosMercadoriasItens.produto_id' => $aData['produto_id']])
            ->first();

        $sDestino = $aData['aLingadas'][0]['destino'];
        $iLocal = $aData['aLingadas'][0]['local_id'];

        $oEnderecoDefault = TableRegistry::getTableLocator()
            ->get('Enderecos')
            ->find()
            ->contain(['Areas'])
            ->where(['Areas.local_id' => $iLocal])
            ->first();

        $iEndereco = $oEnderecoDefault->id;
        $sLoteCodigo = $this->getLoteCodigo($oDocumentosMercadoriasItens->documentos_mercadoria);
        $sLoteItem = $this->getLoteItem($oDocumentosMercadoriasItens);
        $aProdutosAdicionar  = [];
        foreach ($aData['aLingadas'] as $key => $oOrdemServico) {
            $iEmpresas = Empresa::getEmpresaAtual();
            $sLoteCodigo = $oOrdemServico->lote_codigo ?: $sLoteCodigo;
            $sLoteItem = $oOrdemServico->lote_item ?: $sLoteItem;
            $iEndereco = $oOrdemServico->endereco_id ?: $iEndereco;
            $sLote = null;
            $sSerie = null;
            $svalidade = null;

            $aEntity =  [
                'conditions' => [
                    'produto_id' => $oDocumentosMercadoriasItens->produto_id,
                    'lote'       => $sLote,
                    'serie'      => $sSerie,
                    'validade'   => $svalidade,
                    'unidade_medida_id' => $oDocumentosMercadoriasItens->unidade_medida_id,
                    'empresa_id'  => $iEmpresas,
                    'endereco_id' => $iEndereco 
                ],
                'order' => [
                    'qtde' => 'ASC'
                ],
                'dataExtra' => [
                    'lote_codigo' => $sLoteCodigo,
                    'lote_item'   => $sLoteItem,                           
                    'qtde' => $oOrdemServico->qtde ?:0,
                    'peso' => $oOrdemServico->peso ?:0,           
                    'm2' => 0,            
                    'm3' => 0,
                    'status_estoque_id' => null
                ]
            ];

            $aProdutosAdicionar [] = $aEntity;
        } 

        $oResponse =  IncrementoEstoqueProdutos::manageIncrementoEstoque($aProdutosAdicionar);

        if($oResponse->getStatus() != 200){
            return $oResponse;
        }

        return (new ResponseUtil())->setStatus(200)
            ->setDataExtra([
                'sDestino' => @$sDestino,
                'iEndereco' => $iEndereco,
                'iLocal' => $iLocal?:NULL,
                'lote_item' => $sLoteItem,
                'lote_codigo' => $sLoteCodigo
            ])
            ->setMessage('Item vai para o Armazem');
    }

    private function setLocal($aItens, $aData){

        foreach ($aItens as $key => $value) {
            $value->destino = @$aData['sDestino']? 
                $aData['sDestino']:0;
            $value->local_id = @$aData['iLocal']?:NULL;
            $value->endereco_id = @$aData['iEndereco'];
            $value->lote_codigo = @$aData['lote_codigo'];
            $value->lote_item = @$aData['lote_item'];
        }

        return $this->OrdemServicoItemLingadasTable->saveMany($aItens);
    }

    private function decrementStorage($aData){

        if(empty($aData['documentacao_obrigatoria'])){
            return (new ResponseUtil())
                ->setDataExtra([
                    'sDestino' => null,
                    'iEndereco' => null,
                    'iLocal' => null,
                    'lote_item' => null,
                    'lote_codigo' => null
                ])
                ->setStatus(200)
                ->setMessage('Item vai para o Cliente');
        }

        if(empty($aData['aLingadas'][0]['local_id'])){
            return (new ResponseUtil())
                ->setDataExtra([
                    'sDestino' => null,
                    'iEndereco' => null,
                    'iLocal' => null,
                    'lote_item' => null,
                    'lote_codigo' => null
                ])
                ->setStatus(200)
                ->setMessage('Item vai para o Cliente');
        }

        $oDocumentosMercadoriasItens = TableRegistry::getTableLocator()
            ->get('DocumentosMercadoriasItens')
            ->find()
            ->contain(['DocumentosMercadorias', 'PlanoCargaPoroes' => function ($q) use($aData){
                    return $q->where([
                        'plano_carga_id' => $aData['plano_carga_id'],
                        'porao_id' => $aData['porao_id'],
                        'cancelado' => 0,
                    ]);
                }
            ])
            ->matching('PlanoCargaPoroes', function ($q) use($aData){
                return $q->where([
                    'plano_carga_id' => $aData['plano_carga_id'], 
                    'cancelado' => 0,
                    'porao_id' => $aData['porao_id']
                ]);
            })
            ->where(['DocumentosMercadoriasItens.produto_id' => $aData['produto_id']])
            ->first();


     
        $sDestino = $aData['aLingadas'][0]['destino'];
        $iLocal = $aData['aLingadas'][0]['local_id'];
        $aProdutosRemover = [];

        foreach ($aData['aLingadas'] as $oOrdemServico) {

            $iEmpresa = Empresa::getEmpresaAtual();
            $sLoteCodigo = $oOrdemServico->lote_codigo;
            $sLoteItem = $oOrdemServico->lote_item;
            $iEndereco = $oOrdemServico->endereco_id;
            $sLote = null;
            $sSerie = null;
            $sValidade = null;

            $aEntity = [
                'conditions' => [
                    'produto_id' => $oDocumentosMercadoriasItens->produto_id,
                    'lote'       => $sLote,
                    'serie'      => $sSerie,
                    'validade'   => $sValidade,
                    'unidade_medida_id' => $oDocumentosMercadoriasItens->unidade_medida_id,
                    'endereco_id' => $iEndereco,
                    'empresa_id'  => $iEmpresa,
                ],
                'order' => [
                    'qtde' => 'ASC'
                ],
                'dataExtra' => [
                    'qtde' => $oOrdemServico->qtde?:0,
                    'peso' => $oOrdemServico->peso?:0,
                    'm2' => 0,
                    'm3' => 0,
                    'lote_codigo' => $oOrdemServico->lote_codigo,
                    'lote_item'   => $oOrdemServico->lote_item,
                    'container_id' => null,
                    'status_estoque_id' => null,
                ]
            ];

            // $aEntity =  [
            //     'conditions' => [
            //         'produto_id' => $oDocumentosMercadoriasItens->produto_id,
            //         'unidade_medida_id' => $oDocumentosMercadoriasItens->unidade_medida_id,
            //         'endereco_id' => $oOrdemServico->endereco_id,
            //         'lote_codigo' => $oOrdemServico->lote_codigo,
            //         'lote_item' => $oOrdemServico->lote_item,
            //     ],
            //     'order' => [
            //         'qtde' => 'ASC'
            //     ],
            //     'dataExtra' => [                             
            //         'qtde' => $oOrdemServico->qtde?:0,
            //         'peso' => $oOrdemServico->peso?:0,           
            //         'm2' => 0,            
            //         'm3' => 0, 
            //     ]
            // ];

            $aProdutosRemover [] = $aEntity;
        }
        
        if(empty($aProdutosRemover)){
            return (new ResponseUtil())->setStatus(200)->setMessage('Itens para o Cliente.');
        }

        // Log::write('debug',  '--- PRODUTOS REMOVER LINGADA (DECREMENTO) ---');
        // Log::write('debug',  print_r($aProdutosRemover, true));
        $oResponse = DecrementoEstoqueProdutos::manageRetiradaEstoque($aProdutosRemover, false, [
            'ignora_lote_documental' => false
        ]);

        if($oResponse->getStatus() != 200){
            return $oResponse;
        }

        return (new ResponseUtil())->setStatus(200)
            ->setDataExtra([
                'sDestino' => @$sDestino,
                'iEndereco' => $iEndereco,
                'iLocal' => $iLocal?:NULL,
                'lote_item' => $sLoteItem,
                'lote_codigo' => $sLoteCodigo
            ])
            ->setMessage('Item vai para o Armazem');
    }

    public function uploadAvarias($aData){

        if(empty($aData['ordem_servico_item_lingada_id'])){
            return (new ResponseUtil())->setMessage('Sem Lingada.');
        }

        if(empty($aData['avaria_id'])){
            return (new ResponseUtil())->setMessage('Sem Avaria.');
        }

        $oLingadaAvariasTable = TableRegistry::getTableLocator()
            ->get('LingadaAvarias');
        $oLingadaAvariaFotosTable = TableRegistry::getTableLocator()
            ->get('LingadaAvariaFotos');

        $oLingadaAvaria = $oLingadaAvariasTable
            ->find()
            ->where([
                'ordem_servico_item_lingada_id' => $aData['ordem_servico_item_lingada_id'],
                'avaria_id' => $aData['avaria_id'],
            ])
            ->first();

        if(empty($oLingadaAvaria)){
            $oLingadaAvaria = $oLingadaAvariasTable->newEntity([
                'ordem_servico_item_lingada_id' => $aData['ordem_servico_item_lingada_id'],
                'avaria_id' => $aData['avaria_id'],
                'descricao' => $aData['descricao']
            ]);
        }

        if($oEntity = $oLingadaAvariasTable->save($oLingadaAvaria)){
            if(!empty($aData['files'])){
                $oEntities = [];
                foreach ($aData['files'] as $value) {
                    $name = $this->convertBase64Img($value);
                    if($name){
                        $oEntities[] =  $oLingadaAvariaFotosTable->newEntity([
                            'name'=> $name,
                            'lingada_avaria_id'=> $oEntity->id
                        ]); 
                    }
                }
                $oLingadaAvariaFotosTable->saveMany($oEntities);
            }
            $oColetorMaritimoManager = new ColetorMaritimoManager();
            $oPlanoCarga = $oColetorMaritimoManager
                ->getPlanoCarga($aData['plano_carga_id']);
            $iTempoParalisacao = $oColetorMaritimoManager
                ->getTimestampParalisacao($aData['planejamento_maritimo_id']);
            return (new ResponseUtil())
                ->setStatus(200)
                ->setMessage('Salvo com sucesso.')
                ->setDataExtra([
                    'oPlanoCarga' => $oPlanoCarga,
                    'iTempoParalisacao' =>  $iTempoParalisacao
                ]);
        }

        return (new ResponseUtil())->setMessage('Falha ao salvar avaria.');
    }

    public function convertBase64Img($aFile){

        if(empty($aFile['data'])){
            return false;
        }

        $sExtention = isset($aFile['name']) ? substr(strrchr($aFile['name'], '.'), 1): 'png';
        $img = $aFile['data'];

        try{

            $img = str_replace("data:image/$sExtention;base64,", '', $img);
            $img = str_replace(' ', '+', $img);
            $fileData = base64_decode($img);
            $folder = WWW_ROOT.'uploads'.DS.'avarias';
            $fileName = time().'.'.$sExtention;
            
            if(!file_exists($folder)){
                mkdir($folder);
            }
            
            if ($fileData === false) return false;

            if(file_put_contents($folder.DS.$fileName, $fileData)){
                return $fileName;
            }

            return false;

        } catch (\Exception $e) {
            return false;
        }

    }

    public function removeFile($name){

        if(empty($name)){
            return false;
        }

        return unlink (WWW_ROOT.'uploads'.DS.'avarias'.DS.$name);
    }

    public function doNewLingadaEstoques($aData){

        $sTipoSentido = @$aData['sentido'] ?: '';

        switch ($sTipoSentido) {
            case 'EMBARQUE':
                return $this->decrementStorage($aData);
            case 'DESEMBARQUE':
                return $this->incrementStorage($aData);
            default:
                return (new ResponseUtil())->setStatus(200);
        }
    }

    public function doRemoveLingadaEstoques($aData){
        $sTipoSentido = @$aData['sentido'] ?: '';

        switch ($sTipoSentido) {
            case 'EMBARQUE':
                return $this->incrementStorage($aData);
            case 'DESEMBARQUE':
                return $this->decrementStorage($aData);
            default:
                return (new ResponseUtil())->setStatus(400);
        }

    }

    private function getLoteItem($oDocumentosMercadoriasItens){

        $iAno = date('Y');
        $aux = $iAno . 1;
        $aux = str_pad($aux, 15, 'X', STR_PAD_RIGHT);
        $count_pad = substr_count($aux, 'X');
        $sLoteItem = $iAno;

        for ($i=0; $i < $count_pad; $i++) { 
            $sLoteItem .= '0';
        }

        $sLoteItem .= $oDocumentosMercadoriasItens->sequencia_item;
        return $sLoteItem;
       
    }

    private function getLoteCodigo($oDocumento){

        if (!$oDocumento->lote_codigo) {

            $oDocumentosMercadorias = LgDbUtil::get('DocumentosMercadorias')->find()
                ->where([
                    'documento_transporte_id' => $oDocumento->documento_transporte_id
                ])
                ->toArray();

            foreach ($oDocumentosMercadorias as $keyMerc => $oDocumentoMercadoria) {
                if ($oDocumentoMercadoria->lote_codigo == ''){
                    $oDocumentoMercadoria->lote_codigo = UniversalCodigoUtil::codigoLoteMercadoria( null );
                    $oDocumentoMercadoria->digito_receita = UniversalCodigoUtil::codigoDigitoLoteReceita( $oDocumentoMercadoria->lote_codigo );
                    LgDbUtil::save('DocumentosMercadorias', $oDocumentoMercadoria);
                }
            }

            $oDocumento = LgDbUtil::getFind('DocumentosMercadorias')
                ->where([
                    'documento_transporte_id' => $oDocumento->documento_transporte_id,
                    'documento_mercadoria_id_master IS NOT NULL'
                ])
                ->first();

            return  $oDocumento->lote_codigo;
        }

        return $oDocumento->lote_codigo;
    }

    public static function setCaracteristicaCliente($aData){

        if(empty(@$aData['plano_carga_caracteristicas']) || !is_array(@$aData['plano_carga_caracteristicas'])){
            return $aData;
        }

        $iEntity = EntityUtil::getIdByParams('TipoCaracteristicas', 'descricao', 'Cliente');

        if(empty($iEntity)){
            return $aData;
        }

        $iCaracteristica = array_reduce($aData['plano_carga_caracteristicas'], function($sum, $value) use( $iEntity){
            return $iEntity == @$value['tipo_caracteristica_id'] ? @$value['caracteristica_id'] : NULL;
        });


        if(empty($iCaracteristica)){
            return $aData;
        }

        $oCaracteristicas = LgDbUtil::get('Caracteristicas')
            ->find()
            ->where(['id is' => $iCaracteristica])
            ->first();


        if(empty($oCaracteristicas) || empty($oCaracteristicas->valor) || !is_numeric($oCaracteristicas->valor)){
            return $aData;
        }

        $aData['cliente_id'] = @$oCaracteristicas->valor;
        return $aData;
    }

    public static function getPlanoCarga($aData){

        return LgDbUtil::get('PlanoCargas')
            ->find()
            ->contain([
                'Sentidos',
                'PlanejamentoMaritimos' => ['TiposViagens', 'Veiculos']
            ])
            ->where([
                'PlanoCargas.id' => @$aData['plano_carga_id']
            ])->first();
    }

    public static function getOrdemServico($oPlanoCarga){
        $iId = EntityUtil::getIdByParams('OrdemServicoTipos', 'descricao', 'Operação Marítima');

        $oResvPlanejamentoMaritimo = LgDbUtil::get('ResvPlanejamentoMaritimos')
            ->find()
            ->contain([
                'Resvs'
            ])
            ->matching('Resvs', function ($q){
                return $q->where([
                    'data_hora_saida is' => null, 
                    'data_hora_chegada is not' => null,
                    'Resvs.modal_id' => 3
                ]);
            })
            ->where([
                'planejamento_maritimo_id' => $oPlanoCarga->planejamento_maritimo_id,
            ])
            ->first();

        if(empty($oResvPlanejamentoMaritimo)){
            return false;
        }

        return  LgDbUtil::get('OrdemServicos')
            ->find()
            ->where([
                'resv_id' => $oResvPlanejamentoMaritimo->resv_id,
                'ordem_servico_tipo_id' => $iId
            ])->first();

    }

    public static function bDocumentacaoObrigatoria($oPlanoCarga){
        $oTiposViagem = $oPlanoCarga->planejamento_maritimo->tipos_viagem;
        return isset($oTiposViagem) && $oTiposViagem
            ->documentacao_obrigatoria == 0 ? false: true;
    }

    public static function getProduto($aData){

        $oQuery =  LgDbUtil::getFind('Produtos')
            ->contain([
                'PlanoCargaPoroes' => function ($q) use($aData){
                    return $q->where([
                        'PlanoCargaPoroes.plano_carga_id' => $aData['plano_carga_id'],
                        'PlanoCargaPoroes.porao_id' => $aData['porao_id'],
                        'PlanoCargaPoroes.cancelado' => 0,
                    ]);
                }
            ]);
            
        if(!empty($aData['codigo'])){
            return $oQuery
                ->where(['Produtos.codigo' => @$aData['codigo']])
                ->first();  
        }

        if(!empty($aData['produto_id'])){
            return $oQuery
                ->where(['Produtos.id' => @$aData['produto_id']])
                ->first();  
        }

        return null; 
    }

    public static function doPoraoRules($aData, $bGranel = false){

        $aData['mostra_codigo'] = false;
        $aData['mostra_qtd'] = false;  
        $aData['mostra_peso'] = false;
        $aData['valida_media'] = false;
        $aData['mostra_porao_origem'] = false;

        $oCondicoes = LgDbUtil::getFirst('PlanoCargaPoraoCondicoes',[
            'plano_carga_id' => $aData['plano_carga_id'],
            'porao_id' => $aData['porao_id'],
        ]);

        if($oCondicoes){
            $aData['mostra_codigo'] = $oCondicoes->mostra_codigo;
            $aData['mostra_qtd'] = $oCondicoes->mostra_qtd;  
            $aData['mostra_peso'] = $oCondicoes->mostra_peso;
            $aData['valida_media'] = $oCondicoes->validar_pela_media;
            $aData['mostra_porao_origem'] = $oCondicoes->mostra_porao_origem;
        }
        
        //Faz media
        if($aData['valida_media']){
            $aData = self::doMedia($aData);
        }
        
        //Pega Peso pelo PackingList
        if($aData['mostra_codigo'] && !$aData['mostra_peso']){

            $oPlanoCargaPoroes = LgDbUtil::getFind('PlanoCargaPoroes')
                ->contain(['PlanoCargaPackingLists'])
                ->where([
                    'PlanoCargaPackingLists.produto_codigo' => $aData['codigo'],
                    'PlanoCargaPoroes.plano_carga_id' => $aData['plano_carga_id'],
                    'PlanoCargaPoroes.porao_id' => $aData['porao_id'],
                    'PlanoCargaPoroes.cancelado' => 0
                ])
                ->first();

            $aData['peso'] = @$oPlanoCargaPoroes->plano_carga_packing_list->peso_liquido?:0;
        }

        // Pega o Produto Pelo documento, quando não for PackingList
        if(!$aData['mostra_codigo'] && !@$aData['produto_id']){

            $oQuery = LgDbUtil::getFind('PlanoCargaPoroes')
                ->contain([
                    'DocumentosMercadoriasItens' => [
                        'DocumentosMercadorias.PlanoCargaDocumentos'=> function ($q) use($aData){
                            return $q->where([
                                'PlanoCargaDocumentos.plano_carga_id' => $aData['plano_carga_id'],
                                'PlanoCargaDocumentos.operador_portuario_id' => $aData['operador_portuario_id']
                            ]);
                        }
                    ]
                ])
                ->matching('DocumentosMercadoriasItens.DocumentosMercadorias.PlanoCargaDocumentos', 
                    function ($q) use($aData){
                    return $q->where([
                        'PlanoCargaDocumentos.plano_carga_id' => $aData['plano_carga_id'],
                        'PlanoCargaDocumentos.operador_portuario_id' => $aData['operador_portuario_id']
                    ]);
                });

                if(isset($aData['cliente_id'])){
                    $oQuery->matching('DocumentosMercadoriasItens.DocumentosMercadorias', function ($q) use($aData){
                        return $q->where(['DocumentosMercadorias.cliente_id' => $aData['cliente_id']]);
                    });
                }

                $oPlanoCargaPoroes = $oQuery->where([
                    'PlanoCargaPoroes.plano_carga_id' => $aData['plano_carga_id'], 
                    'PlanoCargaPoroes.cancelado' => 0,
                    'PlanoCargaPoroes.porao_id' => $aData['porao_id'],
                ])
                ->select([
                    'PlanoCargaPoroes.id',
                    'PlanoCargaPoroes.documento_mercadoria_item_id',
                    'produto_id' => 'DocumentosMercadoriasItens.produto_id',
                ])
                ->first(); 

            $aData['produto_id'] = @$oPlanoCargaPoroes->produto_id;
        }

        // Define quantidade padrão, quando não for pelo Packlist.
        if(!$aData['mostra_codigo'] && !$aData['mostra_qtd']){
            $aData['qtde'] = 1;
        }

        return $aData;
    }


    public static function getTernoAssociado($aData){
        $oPeriodoAtual = UniversalCodigoUtil::getPortoTrabalhoPeriodoAtual();
        return LgDbUtil::get('PlanejamentoMaritimoTernos')
            ->find()
            ->innerJoinWith('PlanejamentoMaritimoTernoUsuarios')
            ->join([
                'PlanoCargas' => [
                    'table' => 'plano_cargas',
                    'type' => 'INNER',
                    'conditions' => [
                        'PlanoCargas.planejamento_maritimo_id =
                            PlanejamentoMaritimoTernos
                                .planejamento_maritimo_id'
                    ]
                ],
                'AssociacaoTernos' => [
                    'table' => 'associacao_ternos',
                    'type' => 'INNER',
                    'conditions' => [
                        'AssociacaoTernos.terno_id = 
                            PlanejamentoMaritimoTernos.terno_id',
                        'AssociacaoTernos.plano_carga_id = 
                            PlanoCargas.id'
                    ]
                ]
            ])
            ->where([
                'PlanoCargas.id' =>
                    $aData['plano_carga_id'],
                'AssociacaoTernos.porao_id' => 
                    $aData['porao_id'],
                'PlanejamentoMaritimoTernoUsuarios.usuario_id' => 
                    SessionUtil::getUsuarioConectado(),
                'AssociacaoTernos.periodo_id' => $oPeriodoAtual->id
            ])
            ->select([
                'terno_id' => 
                    'PlanejamentoMaritimoTernos.terno_id',
                'usuario_id' => 
                    'PlanejamentoMaritimoTernoUsuarios.usuario_id',
                'porao_id' => 
                    'AssociacaoTernos.porao_id',
                'plano_carga_id' => 
                    'PlanoCargas.id',
            ])
            ->orderDesc('AssociacaoTernos.id')
            ->first();
    }


    public static function saveCaracteristicas($oEntity, $aData){

        if(empty(@$aData['aCaracteristicas']) && !is_array(@$aData['aCaracteristicas'])){
            return false;
        }

        foreach ($aData['aCaracteristicas'] as $value) {
            try {

                $oPnCaracteristica = LgDbUtil::getFirst('PlanoCargaPoraoCaracteristicas', [
                    'plano_carga_porao_id' => $oEntity->plano_carga_porao_id,
                    'caracteristica_id' => @$value['caracteristica_id']
                ]);

                LgDbUtil::saveNew('LingadaCaracteristicas', [
                    'ordem_servico_item_lingada_id' => $oEntity->id,
                    'caracteristica_id' => @$value['caracteristica_id'],
                    'plano_carga_caracteristica_id' => @$oPnCaracteristica->plano_carga_caracteristica_id,
                    'plano_carga_caracteristica_porao_id' => @$oPnCaracteristica->id,
                ]);
                
            } catch (\Throwable $th) {
                        
            }
        }
    }


    public static function doMedia($aData){
        $aPlanoCargaPoroes = LgDbUtil::getFind('PlanoCargaPoroes')
            ->contain([
                'PlanoCargaPackingLists'
            ])
            ->where([
                'PlanoCargaPoroes.plano_carga_id' => $aData['plano_carga_id'], 
                'PlanoCargaPoroes.porao_id' => $aData['porao_id'],
                'PlanoCargaPoroes.cancelado' => 0,
            ])
            ->toArray();
            
        if(empty($aPlanoCargaPoroes)){        
            $aData['quantidade_media'] = 0;
            $aData['peso_media'] = 0;
            return $aData;
        }

        $fPesoTotal = 0;
        $fQtdTotal = 0;
        $iTotalPoroes = sizeof($aPlanoCargaPoroes);

        foreach ($aPlanoCargaPoroes as $oValue) {
            $oPlan = $oValue->plano_carga_packing_list;
            $fPeso = $aData['mostra_codigo'] ? @$oPlan->peso_liquido : @$oValue->tonelagem;
            $fPeso = empty($fPeso) || $fPeso < 0 ? 0 : $fPeso;
            $fQtd = empty($oValue->qtde_prevista) || $oValue->qtde_prevista < 0 ? 0 : $oValue->qtde_prevista;
            $fPesoTotal += $fPeso;
            $fQtdTotal += $fQtd;
        }

        $fPesoMedia =  $fPesoTotal / $iTotalPoroes;
        $fQtdeMedia = $fQtdTotal / $iTotalPoroes;

        $aData['usa_media'] = true;
        $aData['media_quantidade'] = $fQtdeMedia;
        $aData['media_peso'] = $fPesoMedia;

        return $aData;
    }


    public static function doMensagem($aData, $bGranel = false){

        $aMensagens = [];
        if(!$bGranel && $aData['valida_media'] && $aData['mostra_qtd']  && $aData['quantidade'] > $aData['media_quantidade']){
            $aMensagens[] = 'a quantidade ('.$aData['quantidade'].') é maior media ('.intval($aData['media_quantidade']).')';
        }

        if($aData['valida_media'] && $aData['mostra_peso']  && $aData['peso'] > $aData['media_peso']){
            $aMensagens[] = 'o peso ('.DoubleUtil::fromDBUnformat($aData['peso']).') é maior media ('.DoubleUtil::fromDBUnformat($aData['media_peso']).')';
        }

        $sMensagem = implode(', ', $aMensagens);
        $sMensagem = $sMensagem ? ', porem ' . $sMensagem : $sMensagem;
        return 'Lingada salva com sucesso'.$sMensagem.'.';

    }

    public static function getPeriodo(){
        $sTime = date('H:i:s');
        $query = [];
        if ($sTime >= '19:00:00' || $sTime <= '01:00:00') {
            $query = ['hora_fim' => '01:00:00'];
        } else {
            $query = ['hora_inicio <=' => $sTime, 'hora_fim >=' => $sTime];
        }
        return LgDbUtil::getFirst('PortoTrabalhoPeriodos', [$query], ['ordem']);
    }
    
}