<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AceiteContainers Model
 *
 * @method \App\Model\Entity\AceiteContainer get($primaryKey, $options = [])
 * @method \App\Model\Entity\AceiteContainer newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\AceiteContainer[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AceiteContainer|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AceiteContainer saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AceiteContainer patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\AceiteContainer[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\AceiteContainer findOrCreate($search, callable $callback = null, $options = [])
 */
class AceiteContainersTable extends Table
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
        
        $this->belongsTo('Usuarios', [
            'foreignKey' => 'created_by',
            'joinType' => 'LEFT'
        ]);

        $this->setTable('aceite_containers');
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
            ->allowEmptyString('motivo');

        $validator
            ->integer('ativo')
            ->notEmptyString('ativo');

        $validator
            ->dateTime('created_at')
            ->notEmptyDateTime('created_at');

        $validator
            ->dateTime('updated_at')
            ->allowEmptyDateTime('updated_at');

        $validator
            ->integer('created_by')
            ->allowEmptyString('created_by');

        return $validator;
    }

    public function beforeSave($event, $entity, $options) {

        if ($entity->isNew())
            $entity->created_by = $_SESSION['Auth']['User']['id'];
            
    }
}
