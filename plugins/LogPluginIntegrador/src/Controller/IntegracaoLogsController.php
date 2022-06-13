<?php
namespace LogPluginIntegrador\Controller;

use LogPluginIntegrador\Controller\AppController;
use Cake\Core\Configure;
use Util\Core\SaveBackUtil;

/**
 * IntegracaoLogs Controller
 *
 * @property \App\Model\Table\IntegracaoLogsTable $IntegracaoLogs
 *
 * @method \App\Model\Entity\IntegracaoLog[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class IntegracaoLogsController extends AppController
{

    public $customTitlePage = 'IntegracaoLogs';

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
            'contain' => ['Integracoes', 'IntegracaoTraducoes']
        ];
        $integracaoLogs = $this->paginate($this->IntegracaoLogs->find()->order('IntegracaoLogs.id DESC'));

        $this->set('_serialize', ['integracaoLogs']);
        $this->set('form_templates', Configure::read('Templates'));
        $this->set(compact('integracaoLogs'));
    }

    /**
     * View method
     *
     * @param string|null $id Integracao Log id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $integracaoLog = $this->IntegracaoLogs->get($id, [
            'contain' => ['Integracoes', 'IntegracaoTraducoes']
        ]);

        $this->set('integracaoLog', $integracaoLog);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $integracaoLog = $this->IntegracaoLogs->newEntity();
        if ($this->request->is('post')) {

            $empresa_atual = $this->getRequest()->getSession()->read('empresa_atual');
            $dataPost = $this->request->getData();
            $dataPost['empresa_id'] = $empresa_atual ?: null;

            $integracaoLog = $this->IntegracaoLogs->patchEntity($integracaoLog, $dataPost);
            if ($this->IntegracaoLogs->save($integracaoLog)) {
                $this->Flash->success(__('Integracao Log') . __(' has been saved.'));

                if( $this->request->getQuery('historyback') ) {
                    SaveBackUtil::doBackReturn($this);
                }

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Integracao Log') . __(' could not be saved. Please, try again.'));
        }

        $empresa_atual = $this->getRequest()->getSession()->read('empresa_atual');
        $default_association = ['keyField' => 'id', 'valueField' => 'descricao'];
        $integracoes = $this->IntegracaoLogs->Integracoes->find('list', ['limit' => 200]);
        $integracoes_options = $this->IntegracaoLogs->Integracoes->find('list', $default_association)->select(array_values($default_association));
        $integracaoTraducoes = $this->IntegracaoLogs->IntegracaoTraducoes->find('list', ['limit' => 200]);
        $integracaoTraducoes_options = $this->IntegracaoLogs->IntegracaoTraducoes->find('list', $default_association)->select(array_values($default_association));
        $this->set(compact('integracaoLog', 'empresa_atual', 'integracoes', 'integracoes_options', 'integracaoTraducoes', 'integracaoTraducoes_options'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Integracao Log id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $integracaoLog = $this->IntegracaoLogs->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $integracaoLog = $this->IntegracaoLogs->patchEntity($integracaoLog, $this->request->getData());
            if ($this->IntegracaoLogs->save($integracaoLog)) {
                $this->Flash->success(__('Integracao Log') . __(' has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Integracao Log') . __(' could not be saved. Please, try again.'));
        }

        $empresa_atual = $this->getRequest()->getSession()->read('empresa_atual');
        $default_association = ['keyField' => 'id', 'valueField' => 'descricao'];




        $integracoes = $this->IntegracaoLogs->Integracoes->find('list', ['limit' => 200]);
        $integracoes_options = $this->IntegracaoLogs->Integracoes->find('list', $default_association)->select(array_values($default_association));
        $integracaoTraducoes = $this->IntegracaoLogs->IntegracaoTraducoes->find('list', ['limit' => 200]);
        $integracaoTraducoes_options = $this->IntegracaoLogs->IntegracaoTraducoes->find('list', $default_association)->select(array_values($default_association));
        $this->set(compact('integracaoLog', 'integracoes', 'integracoes_options', 'integracaoTraducoes', 'integracaoTraducoes_options'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Integracao Log id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $integracaoLog = $this->IntegracaoLogs->get($id);
        if ($this->IntegracaoLogs->delete($integracaoLog)) {
            $this->Flash->success(__('The') . ' ' . __('integracao log') . ' ' . __('has been deleted.'));
        } else {
            $this->Flash->error(__('The') . ' ' . __('integracao log') . ' ' . __('could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
