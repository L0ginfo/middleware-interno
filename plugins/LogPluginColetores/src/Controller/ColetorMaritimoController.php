<?php
namespace LogPluginColetores\Controller;

use App\Util\ResponseUtil;
use LogPluginColetores\Controller\AppController;
use Cake\Core\Configure;
use Cake\Event\Event;
use LogPluginColetores\RegraNegocio\ColetorMaritimo\ColetorMaritimoManager;

/**
 * Usuarios Controller
 *
 * @property \LogPluginColetores\Model\Table\UsuariosTable $Usuarios
 *
 * @method \LogPluginColetores\Model\Entity\Usuario[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ColetorMaritimoController extends AppController
{

    public $customTitlePage = 'Coletor Marítimo';

    /**
    * beforeRender method
    *
    * @param Event $event
    * @return void
    */
    public function beforeRender(Event $event)
    {
        if (!isset($this->viewVars['customTitlePage']))
            $this->set('customTitlePage', __($this->customTitlePage));
    }
    /**
    * Initialize method
    *
    * @param array $config The configuration for the Table.
    * @return void
    */
    public function initialize() {
        parent::initialize();

        $aModels = [
        ];

        foreach ($aModels as $aModel) {
            $this->loadModel($aModel);
        }
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index($operacao = null)
    {

        if(isset($operacao)){
            return $this->redirect(['']);
        }

        $oColetorMaritimoManager = new ColetorMaritimoManager();
        $aPlanejamentos = $oColetorMaritimoManager->getAvailableShips();
        $aDirections = $oColetorMaritimoManager->getDirections();
        $aTernos = $oColetorMaritimoManager->getTernos();
        $aRemocoes = $oColetorMaritimoManager->getRemocoes();
        $aAvarias = $oColetorMaritimoManager->getAvarias();
        $aParalisacaoMotivos = $oColetorMaritimoManager->getParalisacaoMotivos();
        $aPoroes = $oColetorMaritimoManager->getPoroes();

        $this->set(compact('aPlanejamentos', 'aDirections', 'aTernos', 'aRemocoes', 'aAvarias', 'aParalisacaoMotivos', 'aPoroes'));
    }
}
