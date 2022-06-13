<?php
namespace LogPluginDashboards\Controller;

use LogPluginDashboards\Controller\AppController;
use Cake\Core\Configure;
use App\Util\SaveBackUtil;

/**
 * DashboardGraficoFormatos Controller
 *
 * @property \LogPluginDashboards\Model\Table\DashboardGraficoFormatosTable $DashboardGraficoFormatos
 *
 * @method \LogPluginDashboards\Model\Entity\DashboardGraficoFormato[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DashboardGraficoFormatosController extends AppController
{
    
    public $customTitlePage = 'DashboardGraficoFormatos';

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
        $oQuery = $this->DashboardGraficoFormatos->find()->order('DashboardGraficoFormatos.id DESC');
        
        $dashboardGraficoFormatos = $this->paginate($oQuery);

        $this->set('_serialize', ['dashboardGraficoFormatos']);
        $this->set('form_templates', Configure::read('Templates'));
        $this->set(compact('dashboardGraficoFormatos'));
    }

    /**
     * View method
     *
     * @param string|null $id Dashboard Grafico Formato id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $dashboardGraficoFormato = $this->DashboardGraficoFormatos->get($id, [
            'contain' => ['DashboardGraficoTipos']
        ]);

        $this->set('dashboardGraficoFormato', $dashboardGraficoFormato);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $dashboardGraficoFormato = $this->DashboardGraficoFormatos->newEntity();
        if ($this->request->is('post')) {
            
            $empresa_atual = $this->getRequest()->getSession()->read('empresa_atual');
            $dataPost = $this->request->getData();
            $dataPost['empresa_id'] = $empresa_atual ?: null;

            $dashboardGraficoFormato = $this->DashboardGraficoFormatos->patchEntity($dashboardGraficoFormato, $dataPost);
            if ($this->DashboardGraficoFormatos->save($dashboardGraficoFormato)) {
                $this->Flash->success(__('Dashboard Grafico Formato') . __(' has been saved.'));

                if( $this->request->getQuery('historyback') ) {
                    SaveBackUtil::doBackReturn($this);
                }

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Dashboard Grafico Formato') . __(' could not be saved. Please, try again.'));
        }
    
        $empresa_atual = $this->getRequest()->getSession()->read('empresa_atual');
        $default_association = ['keyField' => 'id', 'valueField' => 'descricao'];
        $this->set(compact('dashboardGraficoFormato', 'empresa_atual'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Dashboard Grafico Formato id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $dashboardGraficoFormato = $this->DashboardGraficoFormatos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $dashboardGraficoFormato = $this->DashboardGraficoFormatos->patchEntity($dashboardGraficoFormato, $this->request->getData());
            if ($this->DashboardGraficoFormatos->save($dashboardGraficoFormato)) {
                $this->Flash->success(__('Dashboard Grafico Formato') . __(' has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Dashboard Grafico Formato') . __(' could not be saved. Please, try again.'));
        }

        $empresa_atual = $this->getRequest()->getSession()->read('empresa_atual');
        $default_association = ['keyField' => 'id', 'valueField' => 'descricao'];




        $this->set(compact('dashboardGraficoFormato'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Dashboard Grafico Formato id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $dashboardGraficoFormato = $this->DashboardGraficoFormatos->get($id);
        if ($this->DashboardGraficoFormatos->delete($dashboardGraficoFormato)) {
            $this->Flash->success(__('The') . ' ' . __('dashboard grafico formato') . ' ' . __('has been deleted.'));
        } else {
            $this->Flash->error(__('The') . ' ' . __('dashboard grafico formato') . ' ' . __('could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
