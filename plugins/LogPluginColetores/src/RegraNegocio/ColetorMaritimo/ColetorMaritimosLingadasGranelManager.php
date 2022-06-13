<?php
namespace LogPluginColetores\RegraNegocio\ColetorMaritimo;

use App\RegraNegocio\PlanejamentoMaritimo\LingadasManager;
use App\Util\DoubleUtil;
use App\Util\EntityUtil;
use App\Util\LgDbUtil;
use Cake\ORM\TableRegistry;
use Util\Core\ResponseUtil;

class ColetorMaritimosLingadasGranelManager 
{

    private $OrdemServicoItemLingadasTable;

    public function __construct()
    {
        $this->OrdemServicoItemLingadasTable = TableRegistry::getTableLocator()->get('OrdemServicoItemLingadas');

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

        $aData['peso'] = DoubleUtil::toDBUnformat($aData['peso']);

        if(empty($aData['placa'])){
            return $oResponseUtil->setMessage('Placa está vazia.');
        }

        if(empty($aData['porao_id'])){
            return $oResponseUtil->setMessage('Porão está vazio.');
        }

        if(empty($aData['operador_portuario_id'])){
            return $oResponseUtil->setMessage('Operador Portuário inválido.');
        }
        
        $aData = ColetorMaritimosLingadasManager::setCaracteristicaCliente($aData);

        $oPlanoCarga = ColetorMaritimosLingadasManager::getPlanoCarga($aData);

        if(empty($oPlanoCarga)){
            return $oResponseUtil->setMessage('Identificador plano de carga inválido.');
        }

        $oPlanejamento = LgDbUtil::getFirst('PlanejamentoMaritimos',[
            'id' => $oPlanoCarga->planejamento_maritimo_id
        ]);

        $oTernoAssociado = ColetorMaritimosLingadasManager::getTernoAssociado($aData);

        if(empty($oTernoAssociado)){
            return $oResponseUtil->setMessage('Solicite ao setor de Operações para associar sua turma de trabalho.');
        }

        $aData = ColetorMaritimosLingadasManager::doPoraoRules($aData, true);
        $oProduto = ColetorMaritimosLingadasManager::getProduto($aData, $oPlanoCarga);

        if(empty($oProduto)){
            return $oResponseUtil->setMessage('Produto inválido.');
        }

        $oOrdemServico = ColetorMaritimosLingadasManager::getOrdemServico($oPlanoCarga);

        if(empty($oOrdemServico)){
            $oResponseUtil = new ResponseUtil();
            return $oResponseUtil->setMessage("Falha ao localizar a ordem serviço do planejamento marítimo: $oPlanejamento->numero");
        }
        
        $oResv = ColetorMaritimosLingadasManager::getLastResvOfVehicle($aData['placa'], $oPlanoCarga->planejamento_maritimo_id);

        if(empty($oResv)){
            return $oResponseUtil->setMessage(
                "O operador do gate vinculou esse veículo " .$aData['placa']. " para outro navio. Solicite para alterar o vinculo para o navio " . $oPlanoCarga->planejamento_maritimo->veiculo->descricao . "."
            );
        }

        $bDocumentacaoObrigatoria = ColetorMaritimosLingadasManager::bDocumentacaoObrigatoria(
            $oPlanoCarga);

        $oPeriodo = ColetorMaritimosLingadasManager::getPeriodo();

        return $this->add([
            'cliente_id' => @$aData['cliente_id'],
            'operador_portuario_id' => $aData['operador_portuario_id'],
            'planejamento_maritimo_id' => $oPlanoCarga->planejamento_maritimo_id,
            'porao_id' => $aData['porao_id'],
            'codigo' => $oProduto->codigo,
            'plano_carga_id' =>  $oPlanoCarga->id,
            'resv_id'=> $oResv->id,
            'ordem_servico_id'=> $oOrdemServico->id,
            'produto_id'=> $oProduto->id,
            'sentido_id' => $oPlanoCarga->sentido_id,
            'terno_id' => $oTernoAssociado->terno_id,
            'periodo_id' => $oPeriodo->id,
            'documentacao_obrigatoria' => $bDocumentacaoObrigatoria,
            'sentido' => @$oPlanoCarga->sentido->codigo,
            'quantidade'=> @$aData['qtde'],
            'peso'=> @$aData['peso'],
            'aCaracteristicas' => @$aData['plano_carga_caracteristicas'],
            'mostra_codigo' => $aData['mostra_codigo'] ,
            'mostra_qtd' => $aData['mostra_qtd'] ,  
            'mostra_peso' => $aData['mostra_peso'] ,
            'valida_media' => $aData['valida_media'] ,
            'media_quantidade' => @$aData['media_quantidade'],
            'media_peso' => @$aData['media_peso'],
        ]);
    }


    private function getLastResvOfVehicle($sPlate){
        return  TableRegistry::getTableLocator()->get('Resvs')
         ->find()
         ->contain([
             'Veiculos'
         ])
         ->where([
             'Veiculos.veiculo_identificacao' => $sPlate,
             'Resvs.data_hora_saida is' => null
         ])
         ->last();
    }

    
    private function validateResvVehicle($placa){

        $result = TableRegistry::getTableLocator()->get('ResvsVeiculos')
            ->find()
            ->contain([
                'Resvs', 
                'Veiculos'
            ])
            ->where([
                'Veiculos.veiculo_identificacao' => $placa,
                'Resvs.data_hora_saida is not' => null
            ])
            ->first();

        return ($result);
    }

    private function add($aData){

        $oResponseUtil = new ResponseUtil();
        $oPlanoCargaPoroes = ColetorMaritimosLingadasManager::getPlanoCargaPorao($aData);
                    
        if(empty($oPlanoCargaPoroes)){
            $oResponseUtil = new ResponseUtil();
            return $oResponseUtil->setMessage(
                "Falha ao localizar o Plano de carga porões do produto:".$aData['produto_id'].'.');
        }

        $oOrdemServico = LgDbUtil::getFirst('OrdemServicoItemLingadas',[
            'plano_carga_porao_id' => $oPlanoCargaPoroes->id,
            'resv_id' => $aData['resv_id']
        ]);

        if($oOrdemServico){
            return $oResponseUtil->setMessage(
                "Lingada do produto: ".$aData['produto_id'].', já cadastrada no sistema.');
        }

        if ($oPlanoCargaPoroes->permite_ultrapassar_limite_previsto) {
            $oRespose =  $oResponseUtil->setStatus(200);
        } else {
            $oRespose  = $this->valideAmount($aData, $oPlanoCargaPoroes);
        }

        if($oRespose->getStatus() !== 200) return  $oRespose;

        $aData['plano_carga_porao_id'] =  $oPlanoCargaPoroes->id;
        $aData['peso'] =  $aData['peso'];
        $aData['qtde'] = $aData['peso'];

        $oEntity = $this->OrdemServicoItemLingadasTable->newEntity($aData);

        if($this->OrdemServicoItemLingadasTable->save($oEntity)){
            ColetorMaritimosLingadasManager::saveCaracteristicas($oEntity, $aData);
            $sMensagem = ColetorMaritimosLingadasManager::doMensagem($aData, true);
            $oColetorMaritimoManager = new ColetorMaritimoManager();
            $oPlanoCarga = $oColetorMaritimoManager
                ->getPlanoCarga($aData['plano_carga_id']);
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
            return $oResponseUtil;
        }

        $oResponseUtil->setMessage('Falha ao salvar a ordem servico item lingada.');
        $oResponseUtil->setDataExtra(['aOrdemServicoItemLingadas' => [$oEntity]]);
        return $oResponseUtil;
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

        $aCaracteriscas = LgDbUtil::getFirst('LingadaCaracteristicas', [
            'ordem_servico_item_lingada_id' => $id
        ]);

        if(!empty($aCaracteriscas)){
            LgDbUtil::get('LingadaCaracteristicas')
                ->deleteAll(['ordem_servico_item_lingada_id' => $id]);
        }

        $oPlanoCargaPoroes = LgDbUtil::get('PlanoCargaPoroes')
            ->get($oEntity->plano_carga_porao_id, ['contain' => ['PlanoCargas']]);
        $iPlanejamentoMaritimo = @$oPlanoCargaPoroes
            ->plano_carga->planejamento_maritimo_id;
        $iResv = $oEntity->resv_id;

        try {
        
            if($this->OrdemServicoItemLingadasTable->delete($oEntity)){
                $oColetorMaritimoManager = new ColetorMaritimoManager();
                $oColetorMaritimoManager = new ColetorMaritimoManager();
                $oPlanoCarga = $oColetorMaritimoManager
                    ->getPlanoCarga($oPlanoCargaPoroes->plano_carga_id);
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

    private function valideAmount(&$aData, $oPlanoCargaPoroes){

        $oResponseUtil = new ResponseUtil();
        $iAmount = $aData['peso']?:0;
        $iAvailable = 0;

        $iAvailable = $oPlanoCargaPoroes->tonelagem ?:0;
        foreach ($oPlanoCargaPoroes->ordem_servico_item_lingadas as $key => $oOrdemServicoItemLingada) {
            $iAvailable = $iAvailable - $oOrdemServicoItemLingada->peso;
        }

        if($iAvailable <= 0){
            $oResponseUtil->setMessage('Falha ao adicionar o registro, peso disponível: 0.000.');
        }

        if($iAmount < 0){
            $iAmount = $aData['peso'] = 0;
        }
        
        if($iAmount >= 0 && $iAmount <= $iAvailable){
            return $oResponseUtil->setStatus(200);
        }

        $iAvailable = DoubleUtil::format($iAvailable, 3);

        return  $oResponseUtil->setMessage('Falha ao adicionar o registro, quantidade disponível: '.$iAvailable.'.');
    }
}