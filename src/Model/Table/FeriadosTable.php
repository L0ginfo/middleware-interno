<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Feriados Model
 *
 * @method \App\Model\Entity\Feriado get($primaryKey, $options = [])
 * @method \App\Model\Entity\Feriado newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Feriado[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Feriado|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Feriado saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Feriado patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Feriado[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Feriado findOrCreate($search, callable $callback = null, $options = [])
 */
class FeriadosTable extends Table
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

        $this->setTable('feriados');
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
            ->date('date')
            ->requirePresence('date', 'create')
            ->notEmptyDate('date');

        $validator
            ->scalar('motivo_feriado')
            ->maxLength('motivo_feriado', 45)
            ->requirePresence('motivo_feriado', 'create')
            ->notEmptyString('motivo_feriado');

        return $validator;
    }
}
