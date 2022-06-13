<?php

namespace App\Model\Table;

use App\Model\Entity\TipoNatureza;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TipoNaturezas Model
 *
 */
class TipoNaturezasTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->table('tipo_naturezas');
        $this->displayField('nome');
        $this->primaryKey('id');

        $this->addBehavior('LogsTabelas');

        $this->hasMany('DocumentoSaida', [
            'foreignKey' => 'tipo_natureza_id'
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
                ->requirePresence('codigo', 'create')
                ->notEmpty('codigo');

        $validator
                ->requirePresence('nome', 'create')
                ->notEmpty('nome');

        return $validator;
    }

}
