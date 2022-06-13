<?php
namespace LogPluginColetores\RegraNegocio\ColetorMaritimo;

use App\Util\EntityUtil;
use App\Util\LgDbUtil;
use Cake\ORM\TableRegistry;
use SebastianBergmann\Environment\Console;
use Util\Core\ResponseUtil;

class ColetorMaritimosAssociacaoTermosManager 
{

    private $AssociacaoTernosTable;

    public function __construct()
    {
        $this->AssociacaoTernosTable = TableRegistry::getTableLocator()->get('AssociacaoTernos');
    } 


    /**
     * adicionar function
     *
     * @param [type] $aData
     * @return ResposeUtil
     */
    public function adicionar($aData){


        $oResponseUtil = new ResponseUtil();

        if(empty($aData['porao_id'])){
            return $oResponseUtil->setMessage('Porao está vazio.');
        }

        if(empty($aData['terno_id'])){
            return $oResponseUtil->setMessage('Terno está vazio.');
        }

        if(empty($aData['plano_carga_id'])){
            return $oResponseUtil->setMessage('Falha ao localizar o plano carga.');
        }

        $iOrdemServicoTipos = EntityUtil::getIdByParams('OrdemServicoTipos', 'descricao', 'Operação Marítima');

        if(empty($iOrdemServicoTipos)){
            return  $oResponseUtil->setMessage('Falha ao localizar o ordem de serviço tipos: Operação Marítima');
        }

        $oPlanoCarga = $this->AssociacaoTernosTable->PlanoCargas
            ->find()
            ->where(['id' => $aData['plano_carga_id']])
            ->first();

        if(empty($oPlanoCarga)){
            return $oResponseUtil->setMessage('Falha ao localizar o plano carga: '. $aData['plano_carga_id']);
        }

        $iModal = EntityUtil::getIdByParams('Modais', 'descricao', 'Marítimo');
        
        if(empty($iModal)){
            return  $oResponseUtil->setMessage('Falha ao localizar o modal: Marítimo');
        }
        
        $ResvPlanejmento = $this->AssociacaoTernosTable
            ->PlanoCargas
            ->PlanejamentoMaritimos
            ->ResvPlanejamentoMaritimos
            ->find()
            ->contain('Resvs')
            ->where([
                'Resvs.data_hora_saida IS' => null,
                'planejamento_maritimo_id' => $oPlanoCarga->planejamento_maritimo_id,
                'Resvs.modal_id' => $iModal
            ])
            ->first();
        
        if(empty($oPlanoCarga)){
            return $oResponseUtil->setMessage('Falha ao localizar a resv aberta do planejemento marítimp: '. $oPlanoCarga->planejamento_maritimo_id);
        }
        
        $oOrdemServico = $this->AssociacaoTernosTable->OrdemServicos
            ->find()
            ->where([
                'data_hora_fim IS' => null, 
                'resv_id' =>  $ResvPlanejmento->resv_id,
                'ordem_servico_tipo_id' => $iOrdemServicoTipos,
            ])
            ->first();

        if(empty($oOrdemServico)){
            return $oResponseUtil->setMessage('Falha ao localizar a ordem serviço aberta do resv: '. $ResvPlanejmento->resv_id);
        }

        $oPlanejamentoMaritimoTerno = LgDbUtil::getByID('PlanejamentoMaritimoTernos', $aData['terno_id']);
        $oPlanejamentoMaritimoTernoPeriodo = LgDbUtil::getFirst('PlanejamentoMaritimoTernoPeriodos', ['planejamento_maritimo_terno_id' => $oPlanejamentoMaritimoTerno->id]);
        $oEntity = $this->AssociacaoTernosTable
            ->find()
            ->where([
                'terno_id' => $oPlanejamentoMaritimoTerno->terno_id,
                'plano_carga_id' =>  $oPlanoCarga->id,
                'porao_id' => $aData['porao_id'],
                'sentido_id' => $oPlanoCarga->sentido_id,
                'ordem_servico_id' => $oOrdemServico->id,
                'planejamento_maritimo_terno_id' => $oPlanejamentoMaritimoTerno->id,
                'periodo_id' => @$oPlanejamentoMaritimoTernoPeriodo->periodo_id,
            ])->first();


        if(isset($oEntity)){
            return $oResponseUtil->setMessage('Associação já cadastrada no sistema.');
        }

        $oEntity = $this->AssociacaoTernosTable->newEntity([
            'terno_id' => $oPlanejamentoMaritimoTerno->terno_id,
            'plano_carga_id' =>  $oPlanoCarga->id,
            'porao_id' => $aData['porao_id'],
            'sentido_id' => $oPlanoCarga->sentido_id,
            'ordem_servico_id' => $oOrdemServico->id,
            'planejamento_maritimo_terno_id' => $oPlanejamentoMaritimoTerno->id,
            'periodo_id' => @$oPlanejamentoMaritimoTernoPeriodo->periodo_id,
        ]);

        if($this->AssociacaoTernosTable->save($oEntity)){
            $oColetorMaritimoManager = new ColetorMaritimoManager();
            $oPlanoCarga = $oColetorMaritimoManager->getPlanoCarga($oPlanoCarga->id);
            $oResponseUtil->setStatus(200);
            $oResponseUtil->setMessage('Salvo com sucesso.');
            $oResponseUtil->setDataExtra(['oPlanoCarga' => $oPlanoCarga]);
        }

        return $oResponseUtil;
    }


    public function remove($id){

        $oResponseUtil = new ResponseUtil();
        $oAssociacao = $this->AssociacaoTernosTable->get($id);
        $oPlanoCarga = $this->AssociacaoTernosTable->PlanoCargas->get($oAssociacao->plano_carga_id);
        
        if($this->AssociacaoTernosTable->delete($oAssociacao)){
            $oColetorMaritimoManager = new ColetorMaritimoManager();
            $oPlanoCarga = $oColetorMaritimoManager->getPlanoCarga($oPlanoCarga->id);
            $oResponseUtil->setStatus(200);
            $oResponseUtil->setMessage('Removido com sucesso.');
            $oResponseUtil->setDataExtra(['oPlanoCarga' => $oPlanoCarga]);
        }

        return $oResponseUtil;
    }


}