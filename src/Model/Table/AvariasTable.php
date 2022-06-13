<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Avarias Model
 *
 * @property \App\Model\Table\TermoAvariasTable&\Cake\ORM\Association\HasMany $TermoAvarias
 *
 * @method \App\Model\Entity\Avaria get($primaryKey, $options = [])
 * @method \App\Model\Entity\Avaria newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Avaria[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Avaria|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Avaria saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Avaria patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Avaria[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Avaria findOrCreate($search, callable $callback = null, $options = [])
 */
class AvariasTable extends Table
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

        $this->setTable('avarias');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->addBehavior('LogsTabelas');

        $this->hasMany('TermoAvarias', [
            'foreignKey' => 'avaria_id'
        ]);
        $this->hasMany('AvariaRespostas', [
            'foreignKey' => 'avaria_id'
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
            ->scalar('codigo')
            ->maxLength('codigo', 10)
            ->requirePresence('codigo', 'create')
            ->notEmptyString('codigo');

        $validator
            ->scalar('descricao')
            ->maxLength('descricao', 45)
            ->requirePresence('descricao', 'create')
            ->notEmptyString('descricao');

        return $validator;
    }
}
