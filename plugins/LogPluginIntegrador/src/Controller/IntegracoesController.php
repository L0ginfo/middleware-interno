<?php
namespace LogPluginIntegrador\Controller;

use LogPluginIntegrador\Controller\AppController;
use Cake\Core\Configure;
use Util\Core\SaveBackUtil;

/**
 * Integracoes Controller
 *
 * @property \App\Model\Table\IntegracoesTable $Integracoes
 *
 * @method \App\Model\Entity\Integracao[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class IntegracoesController extends AppController
{

    public $customTitlePage = 'Integrações';

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
        $integracoes = $this->paginate($this->Integracoes->find()->order('Integracoes.id DESC'));

        $this->set('_serialize', ['integracoes']);
        $this->set('form_templates', Configure::read('Templates'));
        $this->set(compact('integracoes'));
    }

    /**
     * View method
     *
     * @param string|null $id Integracao id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $integracao = $this->Integracoes->get($id, [
            'contain' => ['IntegracaoLogs', 'IntegracaoTraducoes']
        ]);

        $this->set('integracao', $integracao);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $integracao = $this->Integracoes->newEntity();
        if ($this->request->is('post')) {

            $empresa_atual = $this->getRequest()->getSession()->read('empresa_atual');
            $dataPost = $this->request->getData();
            $dataPost['empresa_id'] = $empresa_atual ?: null;

            $integracao = $this->Integracoes->patchEntity($integracao, $dataPost);
            if ($this->Integracoes->save($integracao)) {
                $this->Flash->success(__('Integracao') . __(' has been saved.'));

                if( $this->request->getQuery('historyback') ) {
                    SaveBackUtil::doBackReturn($this);
                }

                return $this->redirect(['action' => 'edit', $integracao->id]);
            }
            $this->Flash->error(__('Integracao') . __(' could not be saved. Please, try again.'));
        }

        $empresa_atual = $this->getRequest()->getSession()->read('empresa_atual');
        $default_association = ['keyField' => 'id', 'valueField' => 'descricao'];
        $this->set(compact('integracao', 'empresa_atual'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Integracao id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $integracao = $this->Integracoes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $integracao = $this->Integracoes->patchEntity($integracao, $this->request->getData());
            if ($this->Integracoes->save($integracao)) {
                $this->Flash->success(__('Integracao') . __(' has been saved.'));

                return $this->redirect(['action' => 'edit', $integracao->id]);
            }
            $this->Flash->error(__('Integracao') . __(' could not be saved. Please, try again.'));
        }

        $empresa_atual = $this->getRequest()->getSession()->read('empresa_atual');
        $default_association = ['keyField' => 'id', 'valueField' => 'descricao'];

        $this->set(compact('integracao'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Integracao id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $integracao = $this->Integracoes->get($id);
        if ($this->Integracoes->delete($integracao)) {
            $this->Flash->success(__('The') . ' ' . __('integracao') . ' ' . __('has been deleted.'));
        } else {
            $this->Flash->error(__('The') . ' ' . __('integracao') . ' ' . __('could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
