<?php
namespace LogPluginColetores\Controller;

use App\Model\Entity\Empresa;
use App\Model\Entity\ParametroGeral;
use LogPluginColetores\Controller\AppController;
use Cake\Core\Configure;
use App\Util\SaveBackUtil;

/**
 * Usuarios Controller
 *
 * @property \LogPluginColetores\Model\Table\UsuariosTable $Usuarios
 *
 * @method \LogPluginColetores\Model\Entity\Usuario[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsuariosController extends AppController
{

    public $customTitlePage = 'Usuarios';

    /**
    * beforeRender method
    *
    * @param Event $event
    * @return void
    */
    public function beforeRender(\Cake\Event\Event $event)
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
        $this->Auth->allow(['login', 'logout']);

        $aModels = [
            'Perfis',
            'EmpresasUsuarios'
        ];

        foreach ($aModels as $aModel) {
            $this->loadModel($aModel);
        }
    }

    public function login() {
        $this->configApp();

        if (env('DB_ADAPTER', 'mysql') != 'sqlsrv')
            $this->disableSQLMode();

        if ($this->Auth->user()) {
            return $this->redirect("/coletores/coletor-maritimo");
        }

        if ($this->request->is('post')) {
            $user = $this->Auth->identify();

            if ($user) {
                $this->Auth->setUser($user);
                $empresasUsuarios = $this->EmpresasUsuarios->find()
                    ->contain('Empresas')
                    ->where([
                        'usuario_id' => $user['id'],
                        'master' => '1',
                        'validade >=' => date('Y-m-d')
                    ])->first();

                // procurando a empresa padrão
                if (!$empresasUsuarios) {
                    $empresasUsuarios = $this->Usuarios->EmpresasUsuarios
                    ->find()
                    ->contain('Empresas')
                    ->where(['usuario_id' => $user['id']])->first();
                }

                $this->getRequest()->getSession()->write('empresa_id', Empresa::getEmpresaPadrao());
                $this->getRequest()->getSession()->write('empresa_atual', Empresa::getEmpresaPadrao());
                $this->getRequest()->getSession()->write('nome_empresa', Empresa::getEmpresaPadrao());

                return $this->redirect($this->Auth->redirectUrl());
            }
            else {
                $this->Flash->error(__('Username or password is incorrect'), 'default', [], 'auth');
            }
        }

        $this->viewBuilder()->setTemplate('login/index');
    }

    public function logout(){
        if ($this->request->is('ajax')) {
            $this->Auth->logout();
            $this->autoRender = false;
        }
        else{
            return $this->redirect($this->Auth->logout());
        }
    }
}
