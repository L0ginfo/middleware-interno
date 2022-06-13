<?php
namespace LogPluginIntegrador\Controller;

use LogPluginIntegrador\Controller\AppController;
use Cake\Core\Configure;
use Util\Core\SaveBackUtil;

/**
 * IntegracaoTraducoes Controller
 *
 * @property \App\Model\Table\IntegracaoTraducoesTable $IntegracaoTraducoes
 *
 * @method \App\Model\Entity\IntegracaoTraducao[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class IntegracaoTraducoesController extends AppController
{

    public $customTitlePage = 'Traduções de Integrações';

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
        $integracaoTraducoes = $this->paginate($this->IntegracaoTraducoes->find()->order('IntegracaoTraducoes.id DESC'));

        $this->set('_serialize', ['integracaoTraducoes']);
        $this->set('form_templates', Configure::read('Templates'));
        $this->set(compact('integracaoTraducoes'));
    }

    /**
     * View method
     *
     * @param string|null $id Integracao Traducao id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $integracaoTraducao = $this->IntegracaoTraducoes->get($id, [
            'contain' => ['Integracoes', 'IntegracaoLogs']
        ]);

        $this->set('integracaoTraducao', $integracaoTraducao);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $integracaoTraducao = $this->IntegracaoTraducoes->newEntity();
        if ($this->request->is('post')) {

            $empresa_atual = $this->getRequest()->getSession()->read('empresa_atual');
            $dataPost = $this->request->getData();
            $dataPost['empresa_id'] = $empresa_atual ?: null;

            $integracaoTraducao = $this->IntegracaoTraducoes->patchEntity($integracaoTraducao, $dataPost);
            if ($this->IntegracaoTraducoes->save($integracaoTraducao)) {
                $this->Flash->success(__('Integracao Traducao') . __(' has been saved.'));

                if( $this->request->getQuery('historyback') ) {
                    SaveBackUtil::doBackReturn($this);
                }

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Integracao Traducao') . __(' could not be saved. Please, try again.'));
        }

        $empresa_atual = $this->getRequest()->getSession()->read('empresa_atual');
        $default_association = ['keyField' => 'id', 'valueField' => 'descricao'];
        $integracoes = $this->IntegracaoTraducoes->Integracoes->find('list', ['limit' => 200]);
        $integracoes_options = $this->IntegracaoTraducoes->Integracoes->find('list', $default_association)->select(array_values($default_association));
        $this->set(compact('integracaoTraducao', 'empresa_atual', 'integracoes', 'integracoes_options'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Integracao Traducao id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $integracaoTraducao = $this->IntegracaoTraducoes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $integracaoTraducao = $this->IntegracaoTraducoes->patchEntity($integracaoTraducao, $this->request->getData());
            if ($this->IntegracaoTraducoes->save($integracaoTraducao)) {
                $this->Flash->success(__('Integracao Traducao') . __(' has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Integracao Traducao') . __(' could not be saved. Please, try again.'));
        }

        $empresa_atual = $this->getRequest()->getSession()->read('empresa_atual');
        $default_association = ['keyField' => 'id', 'valueField' => 'descricao'];




        $integracoes = $this->IntegracaoTraducoes->Integracoes->find('list', ['limit' => 200]);
        $integracoes_options = $this->IntegracaoTraducoes->Integracoes->find('list', $default_association)->select(array_values($default_association));
        $this->set(compact('integracaoTraducao', 'integracoes', 'integracoes_options'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Integracao Traducao id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $integracaoTraducao = $this->IntegracaoTraducoes->get($id);
        if ($this->IntegracaoTraducoes->delete($integracaoTraducao)) {
            $this->Flash->success(__('The') . ' ' . __('integracao traducao') . ' ' . __('has been deleted.'));
        } else {
            $this->Flash->error(__('The') . ' ' . __('integracao traducao') . ' ' . __('could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
