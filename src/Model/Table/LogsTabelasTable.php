<?php
namespace App\Model\Table;

use App\Model\Entity\Log;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Logs Model
 *
 */
class LogsTabelasTable extends Table
{

    public static function defaultConnectionName() {
        return 'logs';
    }

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->table('logs_tabelas');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->addBehavior('Timestamp');
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
            ->requirePresence('tabela', 'create')
            ->notEmpty('tabela');

        $validator
            ->requirePresence('operacao', 'create')
            ->notEmpty('operacao');

        $validator
            ->add('id_coluna', 'valid', ['rule' => 'numeric'])
            ->requirePresence('id_coluna', 'create')
            ->notEmpty('id_coluna');

        $validator
            ->requirePresence('valores', 'create')
            ->notEmpty('valores');

        $validator
            ->add('created_by', 'valid', ['rule' => 'numeric'])
            ->requirePresence('created_by', 'create')
            ->notEmpty('created_by');

        return $validator;
    }
}
