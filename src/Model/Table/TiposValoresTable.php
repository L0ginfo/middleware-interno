<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TiposValores Model
 *
 * @method \App\Model\Entity\TiposValore get($primaryKey, $options = [])
 * @method \App\Model\Entity\TiposValore newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TiposValore[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TiposValore|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TiposValore saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TiposValore patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TiposValore[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TiposValore findOrCreate($search, callable $callback = null, $options = [])
 */
class TiposValoresTable extends Table
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

        $this->setTable('tipos_valores');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->addBehavior('LogsTabelas');

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
            ->scalar('descricao')
            ->maxLength('descricao', 45)
            ->requirePresence('descricao', 'create')
            ->notEmptyString('descricao');

        $validator
            ->scalar('formula')
            ->maxLength('formula', 45)
            ->allowEmptyString('formula');

        return $validator;
    }
}
