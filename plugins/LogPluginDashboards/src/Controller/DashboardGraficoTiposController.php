<?php
namespace LogPluginDashboards\Controller;

use LogPluginDashboards\Controller\AppController;
use Cake\Core\Configure;
use App\Util\SaveBackUtil;

/**
 * DashboardGraficoTipos Controller
 *
 * @property \LogPluginDashboards\Model\Table\DashboardGraficoTiposTable $DashboardGraficoTipos
 *
 * @method \LogPluginDashboards\Model\Entity\DashboardGraficoTipo[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DashboardGraficoTiposController extends AppController
{
    
    public $customTitlePage = 'DashboardGraficoTipos';

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
            'contain' => ['DashboardGraficoFormatos']
        ];
        $oQuery = $this->DashboardGraficoTipos->find()->order('DashboardGraficoTipos.id DESC');
        
        $dashboardGraficoTipos = $this->paginate($oQuery);

        $this->set('_serialize', ['dashboardGraficoTipos']);
        $this->set('form_templates', Configure::read('Templates'));
        $this->set(compact('dashboardGraficoTipos'));
    }

    /**
     * View method
     *
     * @param string|null $id Dashboard Grafico Tipo id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $dashboardGraficoTipo = $this->DashboardGraficoTipos->get($id, [
            'contain' => ['DashboardGraficoFormatos', 'DashboardGraficos']
        ]);

        $this->set('dashboardGraficoTipo', $dashboardGraficoTipo);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $dashboardGraficoTipo = $this->DashboardGraficoTipos->newEntity();
        if ($this->request->is('post')) {
            
            $empresa_atual = $this->getRequest()->getSession()->read('empresa_atual');
            $dataPost = $this->request->getData();
            $dataPost['empresa_id'] = $empresa_atual ?: null;

            $dashboardGraficoTipo = $this->DashboardGraficoTipos->patchEntity($dashboardGraficoTipo, $dataPost);
            if ($this->DashboardGraficoTipos->save($dashboardGraficoTipo)) {
                $this->Flash->success(__('Dashboard Grafico Tipo') . __(' has been saved.'));

                if( $this->request->getQuery('historyback') ) {
                    SaveBackUtil::doBackReturn($this);
                }

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Dashboard Grafico Tipo') . __(' could not be saved. Please, try again.'));
        }
    
        $empresa_atual = $this->getRequest()->getSession()->read('empresa_atual');
        $default_association = ['keyField' => 'id', 'valueField' => 'descricao'];
        $dashboardGraficoFormatos_options = $this->DashboardGraficoTipos->DashboardGraficoFormatos->find('list', $default_association)->select(array_values($default_association));
        $this->set(compact('dashboardGraficoTipo', 'empresa_atual', 'dashboardGraficoFormatos_options'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Dashboard Grafico Tipo id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $dashboardGraficoTipo = $this->DashboardGraficoTipos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $dashboardGraficoTipo = $this->DashboardGraficoTipos->patchEntity($dashboardGraficoTipo, $this->request->getData());
            if ($this->DashboardGraficoTipos->save($dashboardGraficoTipo)) {
                $this->Flash->success(__('Dashboard Grafico Tipo') . __(' has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Dashboard Grafico Tipo') . __(' could not be saved. Please, try again.'));
        }

        $empresa_atual = $this->getRequest()->getSession()->read('empresa_atual');
        $default_association = ['keyField' => 'id', 'valueField' => 'descricao'];




        $dashboardGraficoFormatos_options = $this->DashboardGraficoTipos->DashboardGraficoFormatos->find('list', $default_association)->select(array_values($default_association));
        $this->set(compact('dashboardGraficoTipo', 'dashboardGraficoFormatos_options'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Dashboard Grafico Tipo id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $dashboardGraficoTipo = $this->DashboardGraficoTipos->get($id);
        if ($this->DashboardGraficoTipos->delete($dashboardGraficoTipo)) {
            $this->Flash->success(__('The') . ' ' . __('dashboard grafico tipo') . ' ' . __('has been deleted.'));
        } else {
            $this->Flash->error(__('The') . ' ' . __('dashboard grafico tipo') . ' ' . __('could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
