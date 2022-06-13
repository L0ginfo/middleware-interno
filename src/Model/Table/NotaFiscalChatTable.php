<?php

namespace App\Model\Table;

use App\Model\Entity\NotaFiscalChat;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Event\Event;
use ArrayObject;
// use Cake\Datasource\ConnectionManager;
// use PDO;
// use PDOException;
// use App\Controller\Component\ClonarComponent;
// use App\Controller\Component\AppComponent;

/**
 * NotaFiscalChat Model
 */
class NotaFiscalChatTable extends Table
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

		$this->table('nota_fiscal_chat');
		$this->displayField('id');
		$this->primaryKey('id');
		
		$this->addBehavior('LogsTabelas');

		$this->belongsTo('NotaFiscal', [
			'foreignKey' => 'nota_fiscal_id',
			'joinType' => 'INNER'
		]);

		$this->belongsTo('Usuarios', [
			'foreignKey' => 'usuario_id',
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
			->requirePresence('nota_fiscal_id', 'create')
			->notEmpty('nota_fiscal_id');

		$validator
			->requirePresence('usuario_id', 'create')
			->notEmpty('usuario_id');

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
        $rules->add($rules->existsIn(['usuario_id'], 'Usuarios'));
        $rules->add($rules->existsIn(['nota_fiscal_id'], 'NotaFiscal'));
        return $rules;
    }

    public function beforeSave($event, $entity, $options)
    {
    	$entity->date_time = date('Y-m-d H:i:s');
    }

}