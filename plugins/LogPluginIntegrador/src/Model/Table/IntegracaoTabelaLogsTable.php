<?php
namespace LogPluginIntegrador\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * IntegracaoTabelaLogs Model
 *
 * @property \App\Model\Table\IntegracoesTable&\Cake\ORM\Association\BelongsTo $Integracoes
 *
 * @method \App\Model\Entity\IntegracaoTabelaLog get($primaryKey, $options = [])
 * @method \App\Model\Entity\IntegracaoTabelaLog newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\IntegracaoTabelaLog[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\IntegracaoTabelaLog|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\IntegracaoTabelaLog saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\IntegracaoTabelaLog patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\IntegracaoTabelaLog[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\IntegracaoTabelaLog findOrCreate($search, callable $callback = null, $options = [])
 */
class IntegracaoTabelaLogsTable extends Table
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

        $this->setTable('integracao_tabela_logs');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('Integracoes', [
            'foreignKey' => 'integracao_id',
            'joinType' => 'INNER',
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
            ->integer('coluna')
            ->allowEmptyString('coluna');

        $validator
            ->scalar('tabela')
            ->maxLength('tabela', 255)
            ->requirePresence('tabela', 'create')
            ->notEmptyString('tabela');

        $validator
            ->scalar('operacao')
            ->maxLength('operacao', 255)
            ->requirePresence('operacao', 'create')
            ->notEmptyString('operacao');

        $validator
            ->scalar('data')
            ->allowEmptyString('data');

        $validator
            ->scalar('error')
            ->allowEmptyString('error');

        $validator
            ->integer('status')
            ->requirePresence('status', 'create')
            ->notEmptyString('status');

        $validator
            ->dateTime('create_at')
            ->requirePresence('create_at', 'create')
            ->notEmpty('create_at');

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
