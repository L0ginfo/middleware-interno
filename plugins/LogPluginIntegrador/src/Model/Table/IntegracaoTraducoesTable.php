<?php
namespace LogPluginIntegrador\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * IntegracaoTraducoes Model
 *
 * @property \App\Model\Table\IntegracoesTable&\Cake\ORM\Association\BelongsTo $Integracoes
 * @property \App\Model\Table\IntegracaoLogsTable&\Cake\ORM\Association\HasMany $IntegracaoLogs
 *
 * @method \App\Model\Entity\IntegracaoTraducao get($primaryKey, $options = [])
 * @method \App\Model\Entity\IntegracaoTraducao newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\IntegracaoTraducao[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\IntegracaoTraducao|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\IntegracaoTraducao saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\IntegracaoTraducao patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\IntegracaoTraducao[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\IntegracaoTraducao findOrCreate($search, callable $callback = null, $options = [])
 */
class IntegracaoTraducoesTable extends Table
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

        // $this->addBehavior('LogsTabelas');

        $this->setTable('integracao_traducoes');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('Integracoes', [
            'className' => 'LogPluginIntegrador.Integracoes',
            'foreignKey' => 'integracao_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('IntegracaoLogs', [
            'className' => 'LogPluginIntegrador.IntegracaoLogs',
            'foreignKey' => 'integracao_traducao_id',
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
            ->requirePresence('nested_json_translate', 'create')
            ->notEmptyString('nested_json_translate');

        $validator
            ->scalar('observacao')
            ->requirePresence('observacao', 'create')
            ->notEmptyString('observacao');

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
        $rules->add($rules->existsIn(['integracao_id'], 'Integracoes'));

        return $rules;
    }
}
