<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EventoParametros Model
 *
 * @property \App\Model\Table\OperadoresTable&\Cake\ORM\Association\BelongsTo $Operadores
 * @property \App\Model\Table\EventosTable&\Cake\ORM\Association\HasMany $Eventos
 *
 * @method \App\Model\Entity\EventoParametro get($primaryKey, $options = [])
 * @method \App\Model\Entity\EventoParametro newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\EventoParametro[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EventoParametro|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EventoParametro saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EventoParametro patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\EventoParametro[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\EventoParametro findOrCreate($search, callable $callback = null, $options = [])
 */
class EventoParametrosTable extends Table
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
        

        $this->setTable('evento_parametros');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('Operadores', [
            'foreignKey' => 'operador_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('Eventos', [
            'foreignKey' => 'evento_parametro_id',
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

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['operador_id'], 'Operadores'));

        return $rules;
    }
}
