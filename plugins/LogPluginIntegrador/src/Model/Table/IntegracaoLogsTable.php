<?php
namespace LogPluginIntegrador\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * IntegracaoLogs Model
 *
 * @property \App\Model\Table\IntegracoesTable&\Cake\ORM\Association\BelongsTo $Integracoes
 * @property \App\Model\Table\IntegracaoTraducoesTable&\Cake\ORM\Association\BelongsTo $IntegracaoTraducoes
 *
 * @method \App\Model\Entity\IntegracaoLog get($primaryKey, $options = [])
 * @method \App\Model\Entity\IntegracaoLog newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\IntegracaoLog[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\IntegracaoLog|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\IntegracaoLog saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\IntegracaoLog patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\IntegracaoLog[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\IntegracaoLog findOrCreate($search, callable $callback = null, $options = [])
 */
class IntegracaoLogsTable extends Table
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

        $this->setTable('integracao_logs');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('Integracoes', [
            'className' => 'LogPluginIntegrador.Integracoes',
            'foreignKey' => 'integracao_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('IntegracaoTraducoes', [
            'className' => 'LogPluginIntegrador.IntegracaoTraducoes',
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
            ->scalar('url_requisitada')
            ->requirePresence('url_requisitada', 'create')
            ->notEmptyString('url_requisitada');

        $validator
            ->allowEmptyString('header_enviado');

        $validator
            ->allowEmptyString('header_recebido');

        $validator
            ->allowEmptyString('json_enviado');

        $validator
            ->allowEmptyString('json_recebido');

        $validator
            ->allowEmptyString('json_traduzido');

        $validator
            ->integer('status')
            ->requirePresence('status', 'create')
            ->notEmptyString('status');

        $validator
            ->scalar('descricao')
            ->allowEmptyString('descricao');

        $validator
            ->scalar('stackerror')
            ->allowEmptyString('stackerror');

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
        $rules->add($rules->existsIn(['integracao_traducao_id'], 'IntegracaoTraducoes'));

        return $rules;
    }
}
