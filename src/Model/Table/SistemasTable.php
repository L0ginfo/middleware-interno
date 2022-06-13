<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Sistemas Model
 *
 * @property \App\Model\Table\PerfisTable&\Cake\ORM\Association\HasMany $Perfis
 *
 * @method \App\Model\Entity\Sistema get($primaryKey, $options = [])
 * @method \App\Model\Entity\Sistema newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Sistema[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Sistema|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Sistema saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Sistema patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Sistema[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Sistema findOrCreate($search, callable $callback = null, $options = [])
 */
class SistemasTable extends Table
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

        $this->setTable('sistemas');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->addBehavior('LogsTabelas');

        $this->hasMany('Perfis', [
            'foreignKey' => 'sistema_id'
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
            ->integer('ativo')
            ->requirePresence('ativo', 'create')
            ->notEmptyString('ativo');

        $validator
            ->scalar('email_assinatura')
            ->maxLength('email_assinatura', 4294967295)
            ->allowEmptyString('email_assinatura');

        $validator
            ->scalar('email_padrao')
            ->maxLength('email_padrao', 4294967295)
            ->allowEmptyString('email_padrao');

        $validator
            ->scalar('email_padrao_TFA')
            ->maxLength('email_padrao_TFA', 4294967295)
            ->allowEmptyString('email_padrao_TFA');

        $validator
            ->scalar('sem_registro')
            ->maxLength('sem_registro', 4294967295)
            ->allowEmptyString('sem_registro');

        $validator
            ->scalar('sistema_email_padrao_transportadora')
            ->maxLength('sistema_email_padrao_transportadora', 255)
            ->allowEmptyString('sistema_email_padrao_transportadora');

        $validator
            ->dateTime('created_at')
            ->allowEmptyDateTime('created_at');

        $validator
            ->integer('created_by')
            ->allowEmptyString('created_by');

        $validator
            ->dateTime('updated_at')
            ->allowEmptyDateTime('updated_at');

        $validator
            ->integer('updated_by')
            ->allowEmptyString('updated_by');

        return $validator;
    }
}
