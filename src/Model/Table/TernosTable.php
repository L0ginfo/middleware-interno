<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Ternos Model
 *
 * @property \App\Model\Table\PlanoCargaPoroesTable&\Cake\ORM\Association\HasMany $PlanoCargaPoroes
 *
 * @method \App\Model\Entity\Terno get($primaryKey, $options = [])
 * @method \App\Model\Entity\Terno newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Terno[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Terno|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Terno saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Terno patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Terno[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Terno findOrCreate($search, callable $callback = null, $options = [])
 */
class TernosTable extends Table
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
        

        $this->setTable('ternos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->hasMany('PlanoCargaPoroes', [
            'foreignKey' => 'terno_id',
        ]);

        $this->hasMany('AssociacaoTernos', [
            'foreignKey' => 'terno_id',
        ]);

        $this->hasMany('PlanejamentoMaritimoTernos', [
            'foreignKey' => 'terno_id'
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
            ->requirePresence('descricao', 'create')
            ->notEmptyString('descricao');

        return $validator;
    }
}
