<?php

namespace App\Model\Table;

use App\Model\Entity\LoteSolicitacao;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LoteSolicitacoes Model
 *
 * @property \Cake\ORM\Association\BelongsTo $TipoServicos
 * @property \Cake\ORM\Association\HasMany $LoteServicos
 */
class LoteSolicitacoesTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->table('lote_solicitacoes');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('LogsTabelas');

        $this->belongsTo('TipoServicos', [
            'foreignKey' => 'tipo_servico_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('LoteServicos', [
            'foreignKey' => 'lote_solicitacao_id'
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
    public function validationDefault(Validator $validator) {
        $validator
                ->add('id', 'valid', ['rule' => 'numeric'])
                ->allowEmpty('id', 'create');

        $validator
                ->requirePresence('lote', 'create')
                ->notEmpty('lote');

        $validator
                ->allowEmpty('descricao');

        $validator
                ->allowEmpty('comentario');

        $validator
                ->add('data_solicitacao', 'valid', ['rule' => 'datetime'])
                ->requirePresence('data_solicitacao', 'create')
                ->notEmpty('data_solicitacao');



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
        $rules->add($rules->existsIn(['tipo_servico_id'], 'TipoServicos'));
        return $rules;
    }

}
