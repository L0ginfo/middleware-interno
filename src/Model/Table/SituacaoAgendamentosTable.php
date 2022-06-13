<?php
namespace App\Model\Table;

use App\Model\Entity\SituacaoAgendamento;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SituacaoAgendamentos Model
 *
 * @property \Cake\ORM\Association\HasMany $Agendamentos
 */
class SituacaoAgendamentosTable extends Table
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

        $this->table('situacao_agendamentos');
        $this->displayField('descricao');
        $this->primaryKey('id');

        $this->addBehavior('LogsTabelas');

        $this->hasMany('Agendamentos', [
            'foreignKey' => 'situacao_agendamento_id'
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
            ->requirePresence('nome', 'create')
            ->notEmpty('nome');

        $validator
            ->requirePresence('descricao', 'create')
            ->notEmpty('descricao');

        $validator
            ->allowEmpty('icone');

        $validator
            ->add('automatico', 'valid', ['rule' => 'numeric'])
            ->requirePresence('automatico', 'create')
            ->notEmpty('automatico');

        $validator
            ->allowEmpty('color');

        $validator
            ->allowEmpty('situacao_futura');

        $validator
            ->add('ativo', 'valid', ['rule' => 'numeric'])
            ->requirePresence('ativo', 'create')
            ->notEmpty('ativo');

        return $validator;
    }
}
