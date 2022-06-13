<?php
namespace LogPluginColetores\Controller;

use App\Util\LgDbUtil;
use App\Util\ResponseUtil;
use LogPluginColetores\Controller\AppController;
use LogPluginColetores\RegraNegocio\ColetorMaritimo\ColetorMaritimoManager;
use LogPluginColetores\RegraNegocio\ColetorMaritimo\ColetorMaritimosAssociacaoTermosManager;
use LogPluginColetores\RegraNegocio\ColetorMaritimo\ColetorMaritimosLingadasGranelManager;
use LogPluginColetores\RegraNegocio\ColetorMaritimo\ColetorMaritimosLingadasManager;
use LogPluginColetores\RegraNegocio\ColetorMaritimo\ColetorMaritimosRemocoesManager;

/**
 * Usuarios Controller
 *
 * @property \LogPluginColetores\Model\Table\UsuariosTable $Usuarios
 *
 * @method \LogPluginColetores\Model\Entity\Usuario[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PlanejamentoMaritimoController extends AppController
{

     /**
     * Index method
     *
     * @return void
     */
    public function beforeFilter(\Cake\Event\Event $event)
    {
        parent::beforeFilter($event);
        
        $this->Auth->allow([
            'get', 
            'addLigadas', 
            'deleteLigadas', 
            'addAssociacaoTermo', 
            'deleteAssociacaoTermo',
            'addLigadaGranel',
            'deleteLigadaGranel',
            'addRemocao',
            'deleteRemocao',
            'verifyPlate',
            'uploadAvarias',
            'getPlanoCarga',
            'editParalisacao',
            'deleteParalisacao',
            'getPlanoCargaHistoricos',
            'getPlanoCargaSaldoPoroes',
            'filterQuerySelectpicker'
        ]);
    }
    /**
     * get function
     *
     * @param [int] $id
     * @return void
     */
    public function get($id){

        $oResponseUtil = new ResponseUtil(); 
        $oColetorMaritimoManager = new ColetorMaritimoManager();
        $oPlanejamento = $oColetorMaritimoManager
            ->getAvailableShipsById($id);
        $aTernos = $oColetorMaritimoManager
            ->getPlanejementoTernos($oPlanejamento->id);
        $aPlanoCargas = $oColetorMaritimoManager
            ->getPlanOfCargoByPlanning($oPlanejamento->id);
        $aLingadaRemocoes = $oColetorMaritimoManager
            ->getLingadaRemocoesByPlanejemento($oPlanejamento->id);
        $aParalisacoes = $oColetorMaritimoManager
            ->getParalisacoesByPlanejamento($oPlanejamento->id);

        if($oPlanejamento){
            $oResponseUtil
                ->setStatus(200)
                ->setDataExtra([
                    'oPlanejamento' => $oPlanejamento,
                    'aPlanoCargas' => $aPlanoCargas,
                    'aLingadaRemocoes' => $aLingadaRemocoes,
                    'aTernos' => $aTernos,
                    'aParalisacoes' => $aParalisacoes
                ]);
        }

        return $oResponseUtil->setJsonResponse($this);
    }

    
    public function addLigadas(){
        $this->request->allowMethod(['post', 'patch']);
        $aData = $this->request->getData();
        $oColetorMaritimosLIgadasManager = new ColetorMaritimosLingadasManager();
        $oRespose = $oColetorMaritimosLIgadasManager->adicionar($aData);
        $oRespose->setJsonResponse($this);
    }

    public function deleteLigadas($id){
        $this->request->allowMethod(['post', 'delete']);
        $oColetorMaritimosLIgadasManager = new ColetorMaritimosLingadasManager();
        $oRespose = $oColetorMaritimosLIgadasManager->remove($id);
        $oRespose->setJsonResponse($this);
    }


    public function addAssociacaoTermo(){
        $this->request->allowMethod(['post', 'patch']);
        $aData = $this->request->getData();
        $ColetorMaritimosAssociacaoTermosManager = new ColetorMaritimosAssociacaoTermosManager();
        $oRespose = $ColetorMaritimosAssociacaoTermosManager->adicionar($aData);
        $oRespose->setJsonResponse($this);
    }

    public function deleteAssociacaoTermo($id){
        $this->request->allowMethod(['post', 'delete']);
        $ColetorMaritimosAssociacaoTermosManager = new ColetorMaritimosAssociacaoTermosManager();
        $oRespose = $ColetorMaritimosAssociacaoTermosManager->remove($id);
        $oRespose->setJsonResponse($this);
    }


    public function addLigadaGranel(){
        $this->request->allowMethod(['post', 'patch']);
        $aData = $this->request->getData();
        $ColetorMaritimosAssociacaoTermosManager = new ColetorMaritimosLingadasGranelManager();
        $oRespose = $ColetorMaritimosAssociacaoTermosManager->adicionar($aData);
        $oRespose->setJsonResponse($this);
    }

    public function deleteLigadaGranel($id){
        $this->request->allowMethod(['post', 'delete']);
        $ColetorMaritimosAssociacaoTermosManager = new ColetorMaritimosLingadasGranelManager();
        $oRespose = $ColetorMaritimosAssociacaoTermosManager->remove($id);
        $oRespose->setJsonResponse($this);
    }

    public function addRemocao(){
        $this->request->allowMethod(['post', 'patch']);
        $aData = $this->request->getData();
        $ColetorMaritimosAssociacaoTermosManager = new ColetorMaritimosRemocoesManager();
        $oRespose = $ColetorMaritimosAssociacaoTermosManager->adicionar($aData);
        $oRespose->setJsonResponse($this);
    }

    public function deleteRemocao($id){
        $this->request->allowMethod(['post', 'delete']);
        $ColetorMaritimosAssociacaoTermosManager = new ColetorMaritimosRemocoesManager();
        $oRespose = $ColetorMaritimosAssociacaoTermosManager->remove($id);
        $oRespose->setJsonResponse($this);
    }

    public function verifyPlate(){
        $this->request->allowMethod(['post', 'delete']);
        $placa = $this->request->getData('placa');
        $oColetorMaritimoManager = new ColetorMaritimoManager();
        $oRespose = $oColetorMaritimoManager->verifyPlate($placa);
        $oRespose->setJsonResponse($this);
    }

    public function uploadAvarias(){
        $this->request->allowMethod(['post', 'delete']);
        $oColetorMaritimosLIgadasManager = new ColetorMaritimosLingadasManager();
        $oRespose = $oColetorMaritimosLIgadasManager->uploadAvarias($this->request->getData());
        $oRespose->setJsonResponse($this);
    }


    public function addParalisacao(){
        $this->request->allowMethod(['post', 'delete']);
        $oColetorMaritimoManager = new ColetorMaritimoManager();
        $oRespose = $oColetorMaritimoManager->addParalisacao($this->request->getData());
        $oRespose->setJsonResponse($this);
    }

    public function editParalisacao($id = null){
        $this->request->allowMethod(['post', 'delete']);
        $oColetorMaritimoManager = new ColetorMaritimoManager();
        $oRespose = $oColetorMaritimoManager->editParalisacao($id,  $this->request->getData());
        $oRespose->setJsonResponse($this);
    }

    public function deleteParalisacao($id = null){
        $this->request->allowMethod(['post', 'delete']);
        $oColetorMaritimoManager = new ColetorMaritimoManager();
        $oRespose = $oColetorMaritimoManager->deleteParalisacao($id, $this->request->getData());
        $oRespose->setJsonResponse($this);
    }

    public function getPlanoCarga(){
        $oColetorMaritimoManager = new ColetorMaritimoManager();
        $oRespose = $oColetorMaritimoManager->findPlanoCarga($this->request->getData(), null, true);
        $oRespose->setJsonResponse($this);
    }

    public function getPlanoCargaHistoricos($iPlanoCargaID){
        $oResponseUtil = new ResponseUtil;
        $oColetorMaritimoManager = new ColetorMaritimoManager();
        $oPlanoCarga = $oColetorMaritimoManager->getPlanoCarga($iPlanoCargaID, null, true);
        $oResponseUtil->setStatus(200);
        $oResponseUtil->setDataExtra(['oPlanoCarga' => $oPlanoCarga]);
        $oResponseUtil->setJsonResponse($this);
    }

    public function getPlanoCargaSaldoPoroes($iPlanoCargaID){
        $oResponseUtil = new ResponseUtil;
        $oColetorMaritimoManager = new ColetorMaritimoManager();
        $oPlanoCarga = $oColetorMaritimoManager->getPlanoCarga($iPlanoCargaID, null, true);
        $oResponseUtil->setStatus(200);
        $oResponseUtil->setDataExtra(['oPlanoCarga' => $oPlanoCarga]);
        $oResponseUtil->setJsonResponse($this);
    }

    public function filterQuerySelectpicker()
    {
        $aQuery = $this->request->getQuery();
        $aData = $this->request->getData();

        $iPc = @$aQuery['plano_carga_id'] ?:@$aData['plano_carga_id'];
        $iPorao = @$aQuery['porao_id'] ?:@$aData['porao_id'];

        $sQuery = @$aQuery['q'] ?:@$aData['q'];
        $aExtraSearch = [];

        if(empty($iPc) && empty($iPorao)) {
            echo json_encode(['results' => [] ]); die;
        }

        $aExtraSearch = [
            'Produtos.codigo' => $sQuery,
            'PlanoCargaPoroes.porao_id is' => $iPorao,
            'PlanoCargaPoroes.plano_carga_id is' => $iPc,
            'PlanoCargaPoroes.cancelado' => 0
        ];
        
        $codigoProduto = function($q){return @$q->produto->codigo;};
        $aResults = LgDbUtil::get('PlanoCargaPoroes')
            ->find('list', ['keyField' => $codigoProduto, 'valueField' =>  function($q) {
                return $q->produto->codigo . ' - ' . $q->recebedor;
            }])
            ->contain(['Produtos'])
            ->where($aExtraSearch)
            ->distinct(['Produtos.id'])
            ->order(['Produtos.id' => 'DESC'])
            ->limit(5)
            ->toArray();

        echo json_encode(['results' => $aResults]); die;
    }

}
