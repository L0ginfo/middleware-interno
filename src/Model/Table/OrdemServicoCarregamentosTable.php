<?php
namespace App\Model\Table;

use App\Model\Entity\EntradaSaidaContainer;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OrdemServicoCarregamentos Model
 *
 * @property \App\Model\Table\EmpresasTable&\Cake\ORM\Association\BelongsTo $Empresas
 * @property \App\Model\Table\EstoquesTable&\Cake\ORM\Association\BelongsTo $Estoques
 * @property \App\Model\Table\OrdemServicosTable&\Cake\ORM\Association\BelongsTo $OrdemServicos
 *
 * @method \App\Model\Entity\OrdemServicoCarregamento get($primaryKey, $options = [])
 * @method \App\Model\Entity\OrdemServicoCarregamento newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\OrdemServicoCarregamento[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\OrdemServicoCarregamento|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OrdemServicoCarregamento saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OrdemServicoCarregamento patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\OrdemServicoCarregamento[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\OrdemServicoCarregamento findOrCreate($search, callable $callback = null, $options = [])
 */
class OrdemServicoCarregamentosTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('ordem_servico_carregamentos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->addBehavior('LogsTabelas');

        $this->belongsTo('Empresas', [
            'foreignKey' => 'empresa_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Estoques', [
            'foreignKey' => 'estoque_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('OrdemServicos', [
            'foreignKey' => 'ordem_servico_id',
            'joinType' => 'INNER'
        ]);

        $this->belongsTo('UnidadeMedidas', [
            'foreignKey' => 'unidade_medida_id',
        ]);

        $this->belongsTo('OrdemServicosLeft', [
            'className' => 'OrdemServicos',
            'foreignKey' => 'ordem_servico_id',
            'propertyName' => 'ordem_servico',
            'joinType' => 'LEFT'
        ]);
        
        $this->belongsTo('Enderecos', [
            'foreignKey' => 'endereco_id',
            'joinType' => 'LEFT'
        ]);
        $this->belongsTo('Produtos', [
            'foreignKey' => 'produto_id',
            'joinType' => 'LEFT'
        ]);
        $this->belongsTo('LiberacoesDocumentais', [
            'foreignKey' => 'liberacao_documental_id',
            'joinType' => 'LEFT'
        ]);
        $this->belongsTo('DocumentosMercadoriasLote', [
            'className'=>'DocumentosMercadorias',
            'foreignKey' => 'lote_codigo',
            'bindingKey' => 'lote_codigo',
            'joinType' => 'LEFT'
        ])
        ->setConditions([
            'DocumentosMercadoriasLote.lote_codigo is NOT NULL',
            'DocumentosMercadoriasLote.lote_codigo <>' => ''
        ]);
        
        $this->belongsTo('Containers', [
            'foreignKey' => 'container_id',
            'joinType' => 'LEFT'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->requirePresence('quantidade_carregada', 'create')
            ->notEmptyString('quantidade_carregada');

        $validator
            ->requirePresence('m2_carregada', 'create')
            ->notEmptyString('m2_carregada');

        $validator
            ->requirePresence('m3_carregada', 'create')
            ->notEmptyString('m3_carregada');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        // $rules->add($rules->existsIn(['empresa_id'], 'Empresas'));
        $rules->add($rules->existsIn(['ordem_servico_id'], 'OrdemServicos'));

        return $rules;
    }

    public function beforeSave($event, $entity, $options)
    {
        if ($entity->container_id) {
            $oEntradaSaidaContainers = EntradaSaidaContainer::getLastByContainerId($entity->container_id, false, true);
            $entity->entrada_saida_container_id = @$oEntradaSaidaContainers->id;
        }
    }
    
}
