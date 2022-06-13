<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use App\Util\SaveBackUtil;
use App\Model\Entity\Empresa;
use App\Util\ResponseUtil;

/**
 * Templates Controller
 *
 * @property \App\Model\Table\TemplatesTable $Templates
 *
 * @method \App\Model\Entity\Template[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TemplatesController extends AppController
{
    
    public $customTitlePage = 'Templates';

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
        $oQuery = $this->Templates->find()
            ->contain([])
            ->order('Templates.id DESC');
        
        $templates = $this->paginate($oQuery);

        $this->set('_serialize', ['templates']);
        $this->set('form_templates', Configure::read('Templates'));
        $this->set(compact('templates'));
    }

    /**
     * View method
     *
     * @param string|null $id Template id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $template = $this->Templates->get($id, [
            'contain' => []
        ]);

        if($this->request->is('json')){
            return (new ResponseUtil())
                ->setStatus(200)
                ->setDataExtra($template)
                ->setJsonResponse($this);
        }

        $this->set('template', $template);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $template = $this->Templates->newEntity();

        if ($this->request->is('post')) {
            $aDataPost = $this->request->getData();

            $template = $this->Templates->patchEntity($template, $aDataPost);
            if ($this->Templates->save($template)) {
                $this->Flash->success(__('Template') . __(' has been saved.'));

                if( $this->request->getQuery('historyback') ) {
                    SaveBackUtil::doBackReturn($this);
                }

                return $this->redirect(['action' => 'edit', $template->id]);
            }
            $this->Flash->error(__('Template') . __(' could not be saved. Please, try again.'));
        }
    
        $default_association = ['keyField' => 'id', 'valueField' => 'descricao'];
        $this->set(compact('template', 'empresa_atual'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Template id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $template = $this->Templates->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $aDataPost = $this->request->getData();
            $template = $this->Templates->patchEntity($template, $aDataPost);
            if ($this->Templates->save($template)) {
                $this->Flash->success(__('Template') . __(' has been saved.'));

                return $this->redirect(['action' => 'edit', $template->id]);
            }
            $this->Flash->error(__('Template') . __(' could not be saved. Please, try again.'));
        }

        $default_association = ['keyField' => 'id', 'valueField' => 'descricao'];
        $this->set(compact('template'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Template id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $template = $this->Templates->get($id);
        if ($this->Templates->delete($template)) {
            $this->Flash->success(__('The') . ' ' . __('template') . ' ' . __('has been deleted.'));
        } else {
            $this->Flash->error(__('The') . ' ' . __('template') . ' ' . __('could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }


    public function get($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $template = $this->Templates->get($id);
        if ($this->Templates->delete($template)) {
            $this->Flash->success(__('The') . ' ' . __('template') . ' ' . __('has been deleted.'));
        } else {
            $this->Flash->error(__('The') . ' ' . __('template') . ' ' . __('could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }


    public function filterQuerySelectpicker()
    {

        $sQuery = $this->request->getData('q');
        
        $aResults = $this->Templates
            ->find('list', ['keyField' => 'id', 'valueField' => 'descricao'])
            ->where(['descricao LIKE' => "%$sQuery%" ])
            ->select(['id','cnpj_descricao' => 'descricao'])
            ->limit(5)
            ->toArray();

        echo json_encode(['results' => $aResults]); die;
    }
}
