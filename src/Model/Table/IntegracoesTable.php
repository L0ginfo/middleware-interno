<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Integracoes Model
 *
 * @property \App\Model\Table\IntegracaoLogsTable&\Cake\ORM\Association\HasMany $IntegracaoLogs
 * @property \App\Model\Table\IntegracaoTraducoesTable&\Cake\ORM\Association\HasMany $IntegracaoTraducoes
 *
 * @method \App\Model\Entity\Integracao get($primaryKey, $options = [])
 * @method \App\Model\Entity\Integracao newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Integracao[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Integracao|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Integracao saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Integracao patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Integracao[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Integracao findOrCreate($search, callable $callback = null, $options = [])
 */
class IntegracoesTable extends Table
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

        $this->addBehavior('LogsTabelas');


        $this->setTable('integracoes');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->hasMany('IntegracaoLogs', [
            'foreignKey' => 'integracao_id',
        ]);
        $this->hasMany('IntegracaoTraducoes', [
            'foreignKey' => 'integracao_id',
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
            ->scalar('nome')
            ->maxLength('nome', 255)
            ->requirePresence('nome', 'create')
            ->notEmptyString('nome');

        $validator
            ->scalar('descricao')
            ->requirePresence('descricao', 'create')
            ->notEmptyString('descricao');

        $validator
            ->scalar('codigo_unico')
            ->maxLength('codigo_unico', 255)
            ->requirePresence('codigo_unico', 'create')
            ->notEmptyString('codigo_unico')
            ->add('codigo_unico', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->allowEmptyString('json_header');

        $validator
            ->scalar('url_endpoint')
            ->maxLength('url_endpoint', 255)
            ->allowEmptyString('url_endpoint');

        $validator
            ->integer('ativo')
            ->requirePresence('ativo', 'create')
            ->notEmptyString('ativo');

        $validator
            ->integer('gravar_log')
            ->notEmptyString('gravar_log');

        $validator
            ->scalar('private_key')
            ->maxLength('private_key', 255)
            ->allowEmptyString('private_key');

        $validator
            ->dateTime('data_integracao')
            ->allowEmptyDateTime('data_integracao');

        $validator
            ->scalar('tipo')
            ->requirePresence('tipo', 'create')
            ->notEmptyString('tipo');

        $validator
            ->scalar('db_host')
            ->maxLength('db_host', 255)
            ->allowEmptyString('db_host');

        $validator
            ->integer('db_porta')
            ->allowEmptyString('db_porta');

        $validator
            ->scalar('db_database')
            ->maxLength('db_database', 255)
            ->allowEmptyString('db_database');

        $validator
            ->scalar('db_user')
            ->maxLength('db_user', 255)
            ->allowEmptyString('db_user');

        $validator
            ->scalar('db_pass')
            ->maxLength('db_pass', 255)
            ->allowEmptyString('db_pass');

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
        $rules->add($rules->isUnique(['codigo_unico']));

        return $rules;
    }

    public function beforeSave($event, $entity, $options)
    {
        if (!$entity->private_key) {
            $entity->private_key = sha1(md5(date('Y-m-d H:i:s')));
        }
    }
}
