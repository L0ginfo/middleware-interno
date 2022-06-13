<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * BloqueioContainers Model
 *
 * @method \App\Model\Entity\BloqueioContainer get($primaryKey, $options = [])
 * @method \App\Model\Entity\BloqueioContainer newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\BloqueioContainer[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\BloqueioContainer|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\BloqueioContainer saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\BloqueioContainer patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\BloqueioContainer[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\BloqueioContainer findOrCreate($search, callable $callback = null, $options = [])
 */
class BloqueioContainersTable extends Table
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
        

        $this->setTable('bloqueio_containers');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');
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
            ->scalar('container_numero')
            ->maxLength('container_numero', 255)
            ->requirePresence('container_numero', 'create')
            ->notEmptyString('container_numero');

        $validator
            ->scalar('motivo')
            ->requirePresence('motivo', 'create')
            ->notEmptyString('motivo');

        $validator
            ->integer('ativo')
            ->notEmptyString('ativo');

        return $validator;
    }
}
