<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Event\Event;
// use App\Controller\Component\AppComponent;

/**
 * RelacionamentoCesvRodoviariaChatTable Model
 */
class RelacionamentoCesvRodoviariaChatTable extends Table
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

		$this->table('relacionamento_cesv_rodoviaria_chat');
		$this->displayField('id');
		$this->primaryKey('id');

		$this->addBehavior('LogsTabelas');

		$this->belongsTo('Usuarios', [
			'foreignKey' => 'id_usuario',
			'joinType' => 'INNER'
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
			->add('id', 'valid', ['rule' => 'numeric'])
			->allowEmpty('id', 'create');

		$validator
			->requirePresence('cesv_id', 'create')
			->notEmpty('cesv_id');

		$validator
			->requirePresence('id_usuario', 'create')
			->notEmpty('id_usuario');

		$validator
			->requirePresence('conversation', 'create')
			->notEmpty('conversation');

		$validator
			->requirePresence('date_time', 'create')
			->notEmpty('date_time');

		return $validator;
	}

	/**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules) {
        $rules->add($rules->existsIn(['id_usuario'], 'Usuarios'));
        return $rules;
    }

    public function beforeSave($event, $entity, $options)
    {
    	$entity->date_time = date('Y-m-d H:i:s');
    }

}