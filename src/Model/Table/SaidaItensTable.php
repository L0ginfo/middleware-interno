<?php
namespace App\Model\Table;

use App\Model\Entity\SaidaItem;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SaidaItens Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Docs
 * @property \Cake\ORM\Association\BelongsTo $Agendamentos
 */
class SaidaItensTable extends Table
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

        $this->table('saida_itens');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('LogsTabelas');

        $this->belongsTo('Docs', [
            'foreignKey' => 'doc_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Agendamentos', [
            'foreignKey' => 'agendamento_id',
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
            ->requirePresence('cod_cliente', 'create')
            ->notEmpty('cod_cliente');

        $validator
            ->requirePresence('nome_cliente', 'create')
            ->notEmpty('nome_cliente');

        $validator
            ->requirePresence('doc_saida', 'create')
            ->notEmpty('doc_saida');

        $validator
            ->requirePresence('sequencia_item', 'create')
            ->notEmpty('sequencia_item');

        $validator
            ->requirePresence('desc_produto', 'create')
            ->notEmpty('desc_produto');

        $validator
            ->add('quantidade_carregada', 'valid', ['rule' => 'numeric'])
            ->requirePresence('quantidade_carregada', 'create')
            ->notEmpty('quantidade_carregada');

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
        $rules->add($rules->existsIn(['doc_id'], 'Docs'));
        $rules->add($rules->existsIn(['agendamento_id'], 'Agendamentos'));
        return $rules;
    }
}
