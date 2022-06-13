<?php
namespace LogPluginDashboards\Controller;

use App\Util\ResponseUtil;
use LogPluginDashboards\Controller\AppController;
use Cake\Core\Configure;
use App\Util\SaveBackUtil;
use LogPluginDashboards\RegraNegocio\DashboardManager\DashboardFinder;
use LogPluginDashboards\RegraNegocio\DashboardManager\DashboardGraphStructures;

/**
 * DashboardGraficos Controller
 *
 * @property \LogPluginDashboards\Model\Table\DashboardGraficosTable $DashboardGraficos
 *
 * @method \LogPluginDashboards\Model\Entity\DashboardGrafico[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DashboardGraficosController extends AppController
{
    
    public $customTitlePage = 'DashboardGraficos';

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
            'contain' => ['Consultas', 'Dashboards', 'DashboardGraficoTipos']
        ];
        $oQuery = $this->DashboardGraficos->find()->order('DashboardGraficos.id DESC');
        
        $dashboardGraficos = $this->paginate($oQuery);

        $this->set('_serialize', ['dashboardGraficos']);
        $this->set('form_templates', Configure::read('Templates'));
        $this->set(compact('dashboardGraficos'));
    }

    /**
     * View method
     *
     * @param string|null $id Dashboard Grafico id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $dashboardGrafico = $this->DashboardGraficos->get($id, [
            'contain' => ['Consultas', 'Dashboards', 'DashboardGraficoTipos']
        ]);

        $this->set('dashboardGrafico', $dashboardGrafico);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $dashboardGrafico = $this->DashboardGraficos->newEntity();
        if ($this->request->is('post')) {
            
            $empresa_atual = $this->getRequest()->getSession()->read('empresa_atual');
            $dataPost = $this->request->getData();
            $dataPost['empresa_id'] = $empresa_atual ?: null;

            $dashboardGrafico = $this->DashboardGraficos->patchEntity($dashboardGrafico, $dataPost);
            if ($this->DashboardGraficos->save($dashboardGrafico)) {
                $this->Flash->success(__('Dashboard Grafico') . __(' has been saved.'));

                if( $this->request->getQuery('historyback') ) {
                    SaveBackUtil::doBackReturn($this);
                }

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Dashboard Grafico') . __(' could not be saved. Please, try again.'));
        }
    
        $empresa_atual = $this->getRequest()->getSession()->read('empresa_atual');
        $consultas_options = $this->DashboardGraficos->Consultas->find('list', ['keyField' => 'id', 'valueField' => 'codigo'])
            ->select(array_values(['keyField' => 'id', 'valueField' => 'codigo']));
        $dashboards_options = $this->DashboardGraficos->Dashboards->find('list', ['keyField' => 'id', 'valueField' => 'titulo'])
            ->select(array_values(['keyField' => 'id', 'valueField' => 'titulo']));
        $dashboardGraficoTipos_options = $this->DashboardGraficos->DashboardGraficoTipos->find('list', ['keyField' => 'id', 'valueField' => 'descricao'])
            ->select(array_values(['keyField' => 'id', 'valueField' => 'descricao']));
        $this->set(compact('dashboardGrafico', 'empresa_atual', 'consultas_options', 'dashboards_options', 'dashboardGraficoTipos_options'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Dashboard Grafico id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $dashboardGrafico = $this->DashboardGraficos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $dashboardGrafico = $this->DashboardGraficos->patchEntity($dashboardGrafico, $this->request->getData());
            
            if ($this->DashboardGraficos->save($dashboardGrafico)) {
                $this->Flash->success(__('Dashboard Grafico') . __(' has been saved.'));

                return $this->redirect(['action' => 'edit', $id]);
            }
            $this->Flash->error(__('Dashboard Grafico') . __(' could not be saved. Please, try again.'));
        }

        $empresa_atual = $this->getRequest()->getSession()->read('empresa_atual');
        $default_association = ['keyField' => 'id', 'valueField' => 'titulo'];
        $consultas_options = $this->DashboardGraficos->Consultas->find('list', ['keyField' => 'id', 'valueField' => 'codigo'])
            ->select(array_values(['keyField' => 'id', 'valueField' => 'codigo']));
        $dashboards_options = $this->DashboardGraficos->Dashboards->find('list', ['keyField' => 'id', 'valueField' => 'titulo'])
            ->select(array_values(['keyField' => 'id', 'valueField' => 'titulo']));
        $dashboardGraficoTipos_options = $this->DashboardGraficos->DashboardGraficoTipos->find('list', ['keyField' => 'id', 'valueField' => 'descricao'])
            ->select(array_values(['keyField' => 'id', 'valueField' => 'descricao']));
        $this->set(compact('dashboardGrafico', 'consultas_options', 'dashboards_options', 'dashboardGraficoTipos_options'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Dashboard Grafico id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $dashboardGrafico = $this->DashboardGraficos->get($id);
        if ($this->DashboardGraficos->delete($dashboardGrafico)) {
            $this->Flash->success(__('The') . ' ' . __('dashboard grafico') . ' ' . __('has been deleted.'));
        } else {
            $this->Flash->error(__('The') . ' ' . __('dashboard grafico') . ' ' . __('could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function getDataByMacro()
    {
        $oResponse = new ResponseUtil;
        $sMacro = $this->request->getData('macro');
        $iGraph = $this->request->getData('graph');
        $aDates = $this->request->getData('dates');
        
        if (!$this->request->isAjax() || !$sMacro || !$iGraph || ( $sMacro == 'periodo_especifico' && !$aDates ))
            return $oResponse
                ->setMessage(__('Faltam parâmetros para essa pesquisa!'))
                ->setJsonResponse($this);

        $aDashboads = DashboardFinder::get([
            'DashboardGraficos.id' => $iGraph
        ]);

        $oDashboardGrafico = $aDashboads[0]->dashboard_graficos[0];

        $oDashboardGrafico = DashboardGraphStructures::setGraphScript($oDashboardGrafico, $sMacro, $aDates);

        return $oResponse
            ->setStatus(200)
            ->setDataExtra([
                'query_data' => $oDashboardGrafico->query_data,
                'graph_legends' => $oDashboardGrafico->graph_legends,
            ])
            ->setJsonResponse($this);
    }
}
