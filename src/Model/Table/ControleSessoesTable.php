<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ControleSessoes Model
 *
 * @method \App\Model\Entity\ControleSessao get($primaryKey, $options = [])
 * @method \App\Model\Entity\ControleSessao newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ControleSessao[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ControleSessao|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ControleSessao saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ControleSessao patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ControleSessao[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ControleSessao findOrCreate($search, callable $callback = null, $options = [])
 */
class ControleSessoesTable extends Table
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
        

        $this->setTable('controle_sessoes');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id_token');
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
            ->allowEmptyString('data');

        $validator
            ->integer('expires')
            ->allowEmptyString('expires');

        $validator
            ->dateTime('created_at')
            ->allowEmptyDateTime('created_at');

        $validator
            ->dateTime('modified_at')
            ->allowEmptyDateTime('modified_at');

        return $validator;
    }

}
