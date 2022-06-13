<?php

namespace App\Model\Table;

use App\Model\Entity\LotesEntrada;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LotesEntradas Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Lotes
 * @property \Cake\ORM\Association\BelongsTo $Entradas
 * @property \Cake\ORM\Association\BelongsTo $Itens
 * @property \Cake\ORM\Association\BelongsTo $Containers
 */
class LotesEntradasTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->table('lotes_entradas');
        $this->displayField('id');
        $this->primaryKey('id');


        $this->addBehavior('LogsTabelas');
   

        $this->belongsTo('Lotes', [
            'foreignKey' => 'lote_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Entradas', [
            'foreignKey' => 'entrada_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Itens', [
            'foreignKey' => 'item_id',
            'joinType' => 'left'
        ]);
        $this->belongsTo('Containers', [
            'foreignKey' => 'container_id',
            'joinType' => 'left'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator) {
        $validator
                ->add('id', 'valid', ['rule' => 'numeric'])
                ->allowEmpty('id', 'create');

        $validator
                ->add('quantidade', 'valid', ['rule' => 'numeric'])
                ->requirePresence('quantidade', 'create')
                ->notEmpty('quantidade');

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
        $rules->add($rules->existsIn(['lote_id'], 'Lotes'));
        $rules->add($rules->existsIn(['entrada_id'], 'Entradas'));
        $rules->add($rules->existsIn(['item_id'], 'Itens'));
        $rules->add($rules->existsIn(['container_id'], 'Containers'));
        return $rules;
    }

}
