<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Regioes Model
 *
 * @property \App\Model\Table\EstadosTable&\Cake\ORM\Association\HasMany $Estados
 *
 * @method \App\Model\Entity\Regiao get($primaryKey, $options = [])
 * @method \App\Model\Entity\Regiao newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Regiao[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Regiao|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Regiao saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Regiao patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Regiao[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Regiao findOrCreate($search, callable $callback = null, $options = [])
 */
class RegioesTable extends Table
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

        $this->setTable('regioes');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->addBehavior('LogsTabelas');

        $this->hasMany('Estados', [
            'foreignKey' => 'regiao_id'
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
            ->maxLength('nome', 50)
            ->requirePresence('nome', 'create')
            ->notEmptyString('nome');

        return $validator;
    }
}
