<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Poroes Model
 *
 * @property \App\Model\Table\PlanoCargaPoroesTable&\Cake\ORM\Association\HasMany $PlanoCargaPoroes
 *
 * @method \App\Model\Entity\Porao get($primaryKey, $options = [])
 * @method \App\Model\Entity\Porao newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Porao[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Porao|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Porao saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Porao patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Porao[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Porao findOrCreate($search, callable $callback = null, $options = [])
 */
class PoroesTable extends Table
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
        
        $this->setTable('poroes');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->hasMany('PlanoCargaPoroes', [
            'foreignKey' => 'porao_id',
        ]);

        $this->hasMany('PlanoCargaPoraoCondicoes', [
            'foreignKey' => 'porao_id',
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
            ->scalar('descricao')
            ->maxLength('descricao', 45)
            ->allowEmptyString('descricao');

        return $validator;
    }
}
