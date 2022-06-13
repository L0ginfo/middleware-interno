<?php
namespace App\Model\Table;

use App\Model\Entity\Consolidado;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Consolidados Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Lotes
 * @property \Cake\ORM\Association\BelongsTo $IsoCodes
 */
class ConsolidadosTable extends Table
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

        $this->table('consolidados');

        $this->addBehavior('LogsTabelas');

        $this->belongsTo('Lotes', [
            'foreignKey' => 'lote_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('IsoCodes', [
            'foreignKey' => 'iso_code_id',
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
            ->add('codigo_viagem_sara', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('codigo_viagem_sara');

        $validator
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->requirePresence('id', 'create')
            ->notEmpty('id');

        $validator
            ->allowEmpty('container');

        $validator
            ->add('peso_tara', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('peso_tara');

        $validator
            ->add('free_time_dias', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('free_time_dias');

        $validator
            ->allowEmpty('lacre');

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
        $rules->add($rules->existsIn(['lote_id'], 'Lotes'));
        $rules->add($rules->existsIn(['iso_code_id'], 'IsoCodes'));
        return $rules;
    }
}
