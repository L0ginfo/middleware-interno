<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Logradouros Model
 *
 * @property \App\Model\Table\BairrosTable&\Cake\ORM\Association\BelongsTo $Bairros
 * @property \App\Model\Table\TipoLogradourosTable&\Cake\ORM\Association\BelongsTo $TipoLogradouros
 *
 * @method \App\Model\Entity\Logradouro get($primaryKey, $options = [])
 * @method \App\Model\Entity\Logradouro newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Logradouro[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Logradouro|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Logradouro saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Logradouro patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Logradouro[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Logradouro findOrCreate($search, callable $callback = null, $options = [])
 */
class LogradourosTable extends Table
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

        $this->setTable('logradouros');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->addBehavior('LogsTabelas');

        $this->belongsTo('Bairros', [
            'foreignKey' => 'bairro_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('TipoLogradouros', [
            'foreignKey' => 'tipo_logradouro_id'
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
            ->scalar('num_cep')
            ->maxLength('num_cep', 50)
            ->requirePresence('num_cep', 'create')
            ->notEmptyString('num_cep');

        $validator
            ->scalar('descricao')
            ->maxLength('descricao', 50)
            ->notEmptyString('descricao');

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
        $rules->add($rules->existsIn(['bairro_id'], 'Bairros'));
        $rules->add($rules->existsIn(['tipo_logradouro_id'], 'TipoLogradouros'));

        return $rules;
    }
}
