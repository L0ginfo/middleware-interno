<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TipoLogradouros Model
 *
 * @property \App\Model\Table\LogradourosTable&\Cake\ORM\Association\HasMany $Logradouros
 *
 * @method \App\Model\Entity\TipoLogradouro get($primaryKey, $options = [])
 * @method \App\Model\Entity\TipoLogradouro newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TipoLogradouro[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TipoLogradouro|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TipoLogradouro saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TipoLogradouro patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TipoLogradouro[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TipoLogradouro findOrCreate($search, callable $callback = null, $options = [])
 */
class TipoLogradourosTable extends Table
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

        $this->setTable('tipo_logradouros');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->addBehavior('LogsTabelas');


        $this->hasMany('Logradouros', [
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
            ->scalar('sigla')
            ->maxLength('sigla', 20)
            ->requirePresence('sigla', 'create')
            ->notEmptyString('sigla');

        $validator
            ->scalar('descricao')
            ->maxLength('descricao', 50)
            ->requirePresence('descricao', 'create')
            ->notEmptyString('descricao');

        return $validator;
    }
}
