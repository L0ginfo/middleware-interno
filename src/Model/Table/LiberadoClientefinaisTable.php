<?php

namespace App\Model\Table;

use App\Model\Entity\LiberadoClientefinal;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LiberadoClientefinais Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Docs
 */
class LiberadoClientefinaisTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->table('liberado_clientefinais');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('LogsTabelas');

        $this->belongsTo('EmpresasClientes', [
            'className' => 'Empresas',
            'foreignKey' => 'cod_cliente',
            'bindingKey' => 'codigo_sara',
            'joinType' => 'left'
        ]);

        $this->belongsTo('EmpresasClientesFinais', [
            'className' => 'Empresas',
            'foreignKey' => 'cnpj_final',
            'bindingKey' => 'id ',
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
                ->requirePresence('doc_saida', 'create')
                ->notEmpty('doc_saida');

        $validator
                ->requirePresence('lote', 'create')
                ->notEmpty('lote');

        $validator
                ->requirePresence('cod_cliente', 'create')
                ->notEmpty('cod_cliente');

        $validator
                ->requirePresence('conhecimento', 'create')
                ->notEmpty('conhecimento');

        $validator
                ->requirePresence('num', 'create')
                ->notEmpty('num');

        $validator
                ->requirePresence('cnpj_final', 'create')
                ->notEmpty('cnpj_final');

        $validator
                ->add('quantidade', 'valid', ['rule' => 'decimal'])
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
        return $rules;
    }

}
