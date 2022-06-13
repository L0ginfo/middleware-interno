<?php
namespace LogPluginIntegrador\Controller;

use LogPluginIntegrador\Controller\AppController;
use Cake\Core\Configure;
use Util\Core\SaveBackUtil;

/**
 * IntegracaoTabelaLogs Controller
 *
 * @property \App\Model\Table\IntegracaoTabelaLogsTable $IntegracaoTabelaLogs
 *
 * @method \App\Model\Entity\IntegracaoTabelaLog[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class IntegracaoTabelaLogsController extends AppController
{
    
    public $customTitlePage = 'IntegracaoTabelaLogs';

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
            'contain' => ['Integracoes']
        ];
        $oQuery = $this->IntegracaoTabelaLogs->find()->order('IntegracaoTabelaLogs.id DESC');
        
        $integracaoTabelaLogs = $this->paginate($oQuery);

        $this->set('_serialize', ['integracaoTabelaLogs']);
        $this->set('form_templates', Configure::read('Templates'));
        $this->set(compact('integracaoTabelaLogs'));
    }

    /**
     * View method
     *
     * @param string|null $id Integracao Tabela Log id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $integracaoTabelaLog = $this->IntegracaoTabelaLogs->get($id, [
            'contain' => ['Integracoes']
        ]);

        $this->set('integracaoTabelaLog', $integracaoTabelaLog);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $integracaoTabelaLog = $this->IntegracaoTabelaLogs->newEntity();
        if ($this->request->is('post')) {
            
            $empresa_atual = $this->getRequest()->getSession()->read('empresa_atual');
            $dataPost = $this->request->getData();
            $dataPost['empresa_id'] = $empresa_atual ?: null;

            $integracaoTabelaLog = $this->IntegracaoTabelaLogs->patchEntity($integracaoTabelaLog, $dataPost);
            if ($this->IntegracaoTabelaLogs->save($integracaoTabelaLog)) {
                $this->Flash->success(__('Integracao Tabela Log') . __(' has been saved.'));

                if( $this->request->getQuery('historyback') ) {
                    SaveBackUtil::doBackReturn($this);
                }

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Integracao Tabela Log') . __(' could not be saved. Please, try again.'));
        }
    
        $empresa_atual = $this->getRequest()->getSession()->read('empresa_atual');
        $default_association = ['keyField' => 'id', 'valueField' => 'descricao'];
        $integracoes_options = $this->IntegracaoTabelaLogs->Integracoes->find('list', $default_association)->select(array_values($default_association));
        $this->set(compact('integracaoTabelaLog', 'empresa_atual', 'integracoes_options'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Integracao Tabela Log id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $integracaoTabelaLog = $this->IntegracaoTabelaLogs->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $integracaoTabelaLog = $this->IntegracaoTabelaLogs->patchEntity($integracaoTabelaLog, $this->request->getData());
            if ($this->IntegracaoTabelaLogs->save($integracaoTabelaLog)) {
                $this->Flash->success(__('Integracao Tabela Log') . __(' has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Integracao Tabela Log') . __(' could not be saved. Please, try again.'));
        }

        $empresa_atual = $this->getRequest()->getSession()->read('empresa_atual');
        $default_association = ['keyField' => 'id', 'valueField' => 'descricao'];




        $integracoes_options = $this->IntegracaoTabelaLogs->Integracoes->find('list', $default_association)->select(array_values($default_association));
        $this->set(compact('integracaoTabelaLog', 'integracoes_options'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Integracao Tabela Log id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $integracaoTabelaLog = $this->IntegracaoTabelaLogs->get($id);
        if ($this->IntegracaoTabelaLogs->delete($integracaoTabelaLog)) {
            $this->Flash->success(__('The') . ' ' . __('integracao tabela log') . ' ' . __('has been deleted.'));
        } else {
            $this->Flash->error(__('The') . ' ' . __('integracao tabela log') . ' ' . __('could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
