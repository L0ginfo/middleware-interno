<?php
namespace LogPluginDashboards\Controller;

use LogPluginDashboards\Controller\AppController;
use Cake\Core\Configure;
use App\Util\SaveBackUtil;

/**
 * Dashboards Controller
 *
 * @property \LogPluginDashboards\Model\Table\DashboardsTable $Dashboards
 *
 * @method \LogPluginDashboards\Model\Entity\Dashboard[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DashboardsController extends AppController
{
    
    public $customTitlePage = 'Dashboards';

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
    public function index()
    {
        $this->paginate = [
            'contain' => ['Perfis', 'Usuarios']
        ];
        $oQuery = $this->Dashboards->find()->order('Dashboards.id DESC');
        
        $dashboards = $this->paginate($oQuery);

        $this->set('_serialize', ['dashboards']);
        $this->set('form_templates', Configure::read('Templates'));
        $this->set(compact('dashboards'));
    }

    /**
     * View method
     *
     * @param string|null $id Dashboard id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $dashboard = $this->Dashboards->get($id, [
            'contain' => ['Perfis', 'Usuarios', 'DashboardCards', 'DashboardGraficos']
        ]);

        $this->set('dashboard', $dashboard);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $dashboard = $this->Dashboards->newEntity();
        if ($this->request->is('post')) {
            
            $empresa_atual = $this->getRequest()->getSession()->read('empresa_atual');
            $dataPost = $this->request->getData();
            $dataPost['empresa_id'] = $empresa_atual ?: null;

            $dashboard = $this->Dashboards->patchEntity($dashboard, $dataPost);
            if ($this->Dashboards->save($dashboard)) {
                $this->Flash->success(__('Dashboard') . __(' has been saved.'));

                if( $this->request->getQuery('historyback') ) {
                    SaveBackUtil::doBackReturn($this);
                }

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Dashboard') . __(' could not be saved. Please, try again.'));
        }
    
        $empresa_atual = $this->getRequest()->getSession()->read('empresa_atual');
        $default_association = ['keyField' => 'id', 'valueField' => 'nome'];
        $perfis_options = $this->Dashboards->Perfis->find('list', $default_association)->select(array_values($default_association));
        $usuarios_options = $this->Dashboards->Usuarios->find('list', $default_association)->select(array_values($default_association));
        $this->set(compact('dashboard', 'empresa_atual', 'perfis_options', 'usuarios_options'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Dashboard id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $dashboard = $this->Dashboards->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $dashboard = $this->Dashboards->patchEntity($dashboard, $this->request->getData());
            if ($this->Dashboards->save($dashboard)) {
                $this->Flash->success(__('Dashboard') . __(' has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Dashboard') . __(' could not be saved. Please, try again.'));
        }

        $empresa_atual = $this->getRequest()->getSession()->read('empresa_atual');
        $default_association = ['keyField' => 'id', 'valueField' => 'nome'];
        $perfis_options = $this->Dashboards->Perfis->find('list', $default_association)->select(array_values($default_association));
        $usuarios_options = $this->Dashboards->Usuarios->find('list', $default_association)->select(array_values($default_association));
        $this->set(compact('dashboard', 'perfis_options', 'usuarios_options'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Dashboard id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $dashboard = $this->Dashboards->get($id);
        if ($this->Dashboards->delete($dashboard)) {
            $this->Flash->success(__('The') . ' ' . __('dashboard') . ' ' . __('has been deleted.'));
        } else {
            $this->Flash->error(__('The') . ' ' . __('dashboard') . ' ' . __('could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
