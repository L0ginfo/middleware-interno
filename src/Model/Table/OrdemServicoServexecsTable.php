<?php
namespace App\Model\Table;

use App\Model\Entity\EntradaSaidaContainer;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OrdemServicoServexecs Model
 *
 * @property \App\Model\Table\OrdemServicosTable&\Cake\ORM\Association\BelongsTo $OrdemServicos
 * @property \App\Model\Table\ServicosTable&\Cake\ORM\Association\BelongsTo $Servicos
 * @property \App\Model\Table\EmpresasTable&\Cake\ORM\Association\BelongsTo $Empresas
 *
 * @method \App\Model\Entity\OrdemServicoServexec get($primaryKey, $options = [])
 * @method \App\Model\Entity\OrdemServicoServexec newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\OrdemServicoServexec[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\OrdemServicoServexec|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OrdemServicoServexec saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OrdemServicoServexec patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\OrdemServicoServexec[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\OrdemServicoServexec findOrCreate($search, callable $callback = null, $options = [])
 */
class OrdemServicoServexecsTable extends Table
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

        $this->setTable('ordem_servico_servexecs');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->addBehavior('LogsTabelas');

        $this->belongsTo('OrdemServicos', [
            'foreignKey' => 'ordem_servico_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Servicos', [
            'foreignKey' => 'servico_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Empresas', [
            'foreignKey' => 'empresa_id',
            'joinType' => 'INNER'
        ]);

        $this->hasMany('FaturamentoServicos', [
            'foreignKey' => 'ordem_servico_servexec_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Containers', [
            'foreignKey' => 'container_id',
            'joinType' => 'LEFT'
        ]);

        $this->belongsTo('LeftOrdemServicos', [
            'className' => 'OrdemServicos',
            'foreignKey' => 'ordem_servico_id',
            'propertyName' => 'ordem_servico',
            'joinType' => 'LEFT'
        ]);

        $this->belongsTo('LeftServicos', [
            'className' => 'Servicos',
            'foreignKey' => 'servico_id',
            'propertyName' => 'servico',
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
            ->decimal('quantidade')
            ->requirePresence('quantidade', 'create')
            ->notEmptyString('quantidade');

        $validator
            ->dateTime('data_hora_inicio')
            ->requirePresence('data_hora_inicio', 'create')
            ->notEmptyDateTime('data_hora_inicio');

        $validator
            ->dateTime('data_hora_fim')
            ->requirePresence('data_hora_fim', 'create')
            ->notEmptyDateTime('data_hora_fim');

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
        $rules->add($rules->existsIn(['ordem_servico_id'], 'OrdemServicos'));
        $rules->add($rules->existsIn(['servico_id'], 'Servicos'));
        $rules->add($rules->existsIn(['empresa_id'], 'Empresas'));

        return $rules;
    }
    
    public function beforeSave($event, $entity, $options)
    {
        if (!$entity->created_by)
            $entity->created_by = @$_SESSION['Auth']['User']['id'];

        if ($entity->container_id) {
            $oEntradaSaidaContainers = EntradaSaidaContainer::getLastByContainerId($entity->container_id);
            $entity->entrada_saida_container_id = @$oEntradaSaidaContainers->id;
        }
    }
}
