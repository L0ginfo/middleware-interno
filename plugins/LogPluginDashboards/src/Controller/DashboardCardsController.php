<?php
namespace LogPluginDashboards\Controller;

use LogPluginDashboards\Controller\AppController;
use Cake\Core\Configure;
use App\Util\SaveBackUtil;

/**
 * DashboardCards Controller
 *
 * @property \LogPluginDashboards\Model\Table\DashboardCardsTable $DashboardCards
 *
 * @method \LogPluginDashboards\Model\Entity\DashboardCard[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DashboardCardsController extends AppController
{
    
    public $customTitlePage = 'DashboardCards';

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
            'contain' => ['Dashboards']
        ];
        $oQuery = $this->DashboardCards->find()->order('DashboardCards.id DESC');
        
        $dashboardCards = $this->paginate($oQuery);

        $this->set('_serialize', ['dashboardCards']);
        $this->set('form_templates', Configure::read('Templates'));
        $this->set(compact('dashboardCards'));
    }

    /**
     * View method
     *
     * @param string|null $id Dashboard Card id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $dashboardCard = $this->DashboardCards->get($id, [
            'contain' => ['Dashboards']
        ]);

        $this->set('dashboardCard', $dashboardCard);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $dashboardCard = $this->DashboardCards->newEntity();
        if ($this->request->is('post')) {
            
            $empresa_atual = $this->getRequest()->getSession()->read('empresa_atual');
            $dataPost = $this->request->getData();
            $dataPost['empresa_id'] = $empresa_atual ?: null;

            $dashboardCard = $this->DashboardCards->patchEntity($dashboardCard, $dataPost);
            if ($this->DashboardCards->save($dashboardCard)) {
                $this->Flash->success(__('Dashboard Card') . __(' has been saved.'));

                if( $this->request->getQuery('historyback') ) {
                    SaveBackUtil::doBackReturn($this);
                }

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Dashboard Card') . __(' could not be saved. Please, try again.'));
        }
    
        $empresa_atual = $this->getRequest()->getSession()->read('empresa_atual');
        $default_association = ['keyField' => 'id', 'valueField' => 'titulo'];
        $dashboards_options = $this->DashboardCards->Dashboards->find('list', $default_association)->select(array_values($default_association));
        $this->set(compact('dashboardCard', 'empresa_atual', 'dashboards', 'dashboards_options'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Dashboard Card id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $dashboardCard = $this->DashboardCards->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $dashboardCard = $this->DashboardCards->patchEntity($dashboardCard, $this->request->getData());
            if ($this->DashboardCards->save($dashboardCard)) {
                $this->Flash->success(__('Dashboard Card') . __(' has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Dashboard Card') . __(' could not be saved. Please, try again.'));
        }

        $empresa_atual = $this->getRequest()->getSession()->read('empresa_atual');
        $default_association = ['keyField' => 'id', 'valueField' => 'titulo'];
        $dashboards_options = $this->DashboardCards->Dashboards->find('list', $default_association)->select(array_values($default_association));
        $this->set(compact('dashboardCard', 'dashboards_options'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Dashboard Card id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $dashboardCard = $this->DashboardCards->get($id);
        if ($this->DashboardCards->delete($dashboardCard)) {
            $this->Flash->success(__('The') . ' ' . __('dashboard card') . ' ' . __('has been deleted.'));
        } else {
            $this->Flash->error(__('The') . ' ' . __('dashboard card') . ' ' . __('could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
