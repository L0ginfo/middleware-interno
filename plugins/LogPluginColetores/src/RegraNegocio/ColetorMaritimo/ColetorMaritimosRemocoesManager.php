<?php
namespace LogPluginColetores\RegraNegocio\ColetorMaritimo;

use App\Util\DoubleUtil;
use App\Util\EntityUtil;
use App\Util\LgDbUtil;
use App\Util\SessionUtil;
use Cake\Http\Client\Response;
use Cake\ORM\TableRegistry;
use Util\Core\ResponseUtil;

class ColetorMaritimosRemocoesManager 
{

    private $LingadaRemocoes;

    public function __construct()
    {
        $this->LingadaRemocoes = TableRegistry::getTableLocator()->get('LingadaRemocoes');
    } 

    public function adicionar($aData){


        $oResponseUtil = new ResponseUtil();
        $aData['quantidade'] = DoubleUtil::toDBUnformat(@$aData['quantidade']);
        $aData['peso'] = DoubleUtil::toDBUnformat(@$aData['peso']);

        if(empty($aData['remocao_id'])){
            return $oResponseUtil->setMessage('Remoção está vazia.');
        }

        if(empty($aData['porao_id'])){
            return $oResponseUtil->setMessage('Porão está vazio.');
        }

        if(empty($aData['operador_portuario_id'])){
            return $oResponseUtil->setMessage('Operador Portuário inválido.');
        }
        
        $aData = ColetorMaritimosLingadasManager::
            setCaracteristicaCliente($aData);
             
        $oPlanoCarga = ColetorMaritimosLingadasManager::
            getPlanoCarga($aData);

        if(empty($oPlanoCarga)){
            return $oResponseUtil
                ->setMessage('Identificador de plano de carga inválido.');
        }

        $oPmTerno = self::getTerno($aData);

        if(empty($oPmTerno)){
            return $oResponseUtil
                ->setMessage('Falha ao localizar o terno do usuario.');
        }

        $oProduto = ColetorMaritimosLingadasManager::
            getProduto($aData, $oPlanoCarga);

        if(empty($oProduto)){
            return $oResponseUtil
                ->setMessage('Falha ao localizar o produto.');
        }

        $oOrdemServico = ColetorMaritimosLingadasManager::
        getOrdemServico($oPlanoCarga);

        if(empty($oOrdemServico)){
            $sNumero = @$oPlanoCarga->planejamento_Maritimo->numero;
            return $oResponseUtil->setMessage("Falha ao localizar a ordem serviço do planejamento marítimo: $sNumero.");
        }

        $bDocumentacaoObrigatoria = ColetorMaritimosLingadasManager::
            bDocumentacaoObrigatoria($oPlanoCarga);

        $oPlanoCargaPorao = ColetorMaritimosLingadasManager::
        getPlanoCargaPorao([
            'produto_id' => $oProduto->id,
            'plano_carga_id' => $oPlanoCarga->id,
            'porao_id' => @$aData['porao_id'],
            'aCaracteristicas' => @$aData['plano_carga_caracteristicas'],
            'operador_portuario_id' =>  @$aData['operador_portuario_id'],
            'documentacao_obrigatoria' => $bDocumentacaoObrigatoria,
        ]);


        if(empty($oPlanoCargaPorao)){
            return $oResponseUtil->setMessage('Falha ao localizar o Plano de porão do produto: '.@$oProduto->descricao.'.');
        }

        $oPeriodo = self::getPeriodo();

        if(!@$aData['quantidade']) {
            @$aData['quantidade'] = $oPlanoCargaPorao->qtde_prevista;
            @$aData['peso'] = $oPlanoCargaPorao->tonelagem;
        }

        if(!@$aData['peso']) {
            @$aData['peso'] = ($oPlanoCargaPorao->tonelagem / $oPlanoCargaPorao->qtde_prevista) * @$aData['quantidade'];
        }
        
        
        $oEntity = $this->LingadaRemocoes->newEntity([
            'porao_id' => @$aData['porao_id'],
            'remocao_id' => @$aData['remocao_id'],
            'peso' => @$aData['peso'],
            'quantidade' => @$aData['quantidade'],
            'cliente_id' => @$aData['cliente_id'],
            'terno_id' => $oPmTerno->terno_id,
            'produto_id' => $oProduto->id,
            'periodo_id' => $oPeriodo->id,
            'plano_carga_id' => $oPlanoCarga->id,
            'plano_carga_porao_id' => $oPlanoCargaPorao->id,
            'ordem_servico_id' => @$oOrdemServico->id,
            'operador_portuario_id' => @$aData['operador_portuario_id'],
        ]);

        if($this->LingadaRemocoes->save($oEntity)){
            self::saveCaracteristicas($oEntity, @$aData[
                'plano_carga_caracteristicas'
            ]);
            $oColetorMaritimoManager = new ColetorMaritimoManager();
            $oPlanoCarga = $oColetorMaritimoManager->getPlanoCarga($oPlanoCargaPorao->plano_carga_id);
            $iTempoParalisacao = $oColetorMaritimoManager->getTimestampParalisacao(
                $oPlanoCarga->planejamento_maritimo_id);
            $oResponseUtil->setStatus(200);
            $oResponseUtil->setMessage('Removido com sucesso.');
            $oResponseUtil->setDataExtra([
                'oPlanoCarga' => $oPlanoCarga,
                'iTempoParalisacao' =>  $iTempoParalisacao
            ]);
            
            return $oResponseUtil;
        }

        return $oResponseUtil;

    }

    public function remove($id){
        $oResponseUtil = new ResponseUtil();
        $oLindadaRemocao = $this->LingadaRemocoes->get($id);

        LgDbUtil::get('LingadaRemocaoCaracteristicas')->deleteAll([
            'lingada_remocao_id' => $id
        ]);

        $oPlanoCargaPoroes = LgDbUtil::getFirst('PlanoCargaPoroes', [
            'id' => $oLindadaRemocao->plano_carga_porao_id
        ]);

        if($this->LingadaRemocoes->delete($oLindadaRemocao)){
            $oResponseUtil->setStatus(200)
                ->setMessage('Removido com sucesso.');
            $oColetorMaritimoManager = new ColetorMaritimoManager();
            $oPlanoCarga = $oColetorMaritimoManager
                ->getPlanoCarga($oPlanoCargaPoroes->plano_carga_id);
            $iTempoParalisacao = $oColetorMaritimoManager->getTimestampParalisacao(
                $oPlanoCarga->planejamento_maritimo_id);
            $oResponseUtil->setStatus(200);
            $oResponseUtil->setMessage('Removido com sucesso.');
            $oResponseUtil->setDataExtra([
                'oPlanoCarga' => $oPlanoCarga,
                'iTempoParalisacao' =>  $iTempoParalisacao
            ]);
            return $oResponseUtil;
        }


        return $oResponseUtil;
    }


    public static function getTerno($aData){

        $iUserId = SessionUtil::getUsuarioConectado();

        return LgDbUtil::get('PlanejamentoMaritimoTernos')
            ->find()
            ->innerJoinWith('PlanejamentoMaritimoTernoUsuarios')
            ->join([
                'PlanoCargas' => [
                    'table' => 'plano_cargas',
                    'type' => 'INNER',
                    'conditions' => 'PlanoCargas.planejamento_maritimo_id = PlanejamentoMaritimoTernos.planejamento_maritimo_id',
                ]
            ])
            ->where([
                'PlanejamentoMaritimoTernoUsuarios.usuario_id' => $iUserId,
                'PlanoCargas.id' => $aData['plano_carga_id']
            ])
            ->select([
                'terno_id' => 'PlanejamentoMaritimoTernos.terno_id',
                'usuario_id' => 'PlanejamentoMaritimoTernoUsuarios.usuario_id',
            ])
            ->first();
    }


    public static function saveCaracteristicas($oEntity, $aCaracteristicas){

        if(empty($aCaracteristicas)){
            return false;
        }

        foreach ($aCaracteristicas as $value) {
            try {
                LgDbUtil::saveNew('LingadaRemocaoCaracteristicas', [
                    'lingada_remocao_id' => $oEntity->id,
                    'caracteristica_id' => @$value['caracteristica_id'],
                ]);
            } catch (\Throwable $th) {
                        
            }
        }
    }

    public static function getPeriodo(){
        $sTime = date('H:i:s');
        return LgDbUtil::getFirst('PortoTrabalhoPeriodos', [
            'OR' =>[
                [
                    'hora_inicio <=' => $sTime,
                    'hora_fim >=' => $sTime,
                ],
                [
                    'hora_inicio > hora_fim',
                    'hora_inicio <=' => $sTime,
                    'hora_fim <=' => $sTime,
                ]
            ]

        ], ['ordem']);
    }


}