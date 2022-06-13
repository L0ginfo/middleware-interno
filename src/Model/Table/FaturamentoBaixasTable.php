<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * FaturamentoBaixas Model
 *
 * @property \App\Model\Table\TipoPagamentosTable&\Cake\ORM\Association\BelongsTo $TipoPagamentos
 * @property \App\Model\Table\BancosTable&\Cake\ORM\Association\BelongsTo $Bancos
 * @property \App\Model\Table\FaturamentoArmazenagensTable&\Cake\ORM\Association\BelongsTo $FaturamentoArmazenagens
 *
 * @method \App\Model\Entity\FaturamentoBaixa get($primaryKey, $options = [])
 * @method \App\Model\Entity\FaturamentoBaixa newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\FaturamentoBaixa[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\FaturamentoBaixa|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FaturamentoBaixa saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FaturamentoBaixa patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\FaturamentoBaixa[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\FaturamentoBaixa findOrCreate($search, callable $callback = null, $options = [])
 */
class FaturamentoBaixasTable extends Table
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

        $this->setTable('faturamento_baixas');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->addBehavior('LogsTabelas');

        $this->belongsTo('TipoPagamentos', [
            'foreignKey' => 'tipo_pagamento_id',
            'joinType' => 'LEFT'
        ]);
        $this->belongsTo('Bancos', [
            'foreignKey' => 'banco_id',
            'joinType' => 'LEFT'
        ]);
        $this->belongsTo('FaturamentoArmazenagens', [
            'foreignKey' => 'faturamento_armazenagem_id',
            'joinType' => 'LEFT'
        ]);
        $this->belongsTo('Faturamentos', [
            'foreignKey' => 'faturamento_id',
            'joinType' => 'LEFT'
        ]);
        $this->belongsTo('StatusIntegracoes', [
            'foreignKey' => 'status_integracao_id',
            'joinType' => 'LEFT'
        ]);

        $this->hasMany('ReportResponsesIntegracoes', [
            'foreignKey' => 'id_coluna',
            'joinType' => 'LEFT',
            'className' => 'ReportResponses',
            'propertyName' => 'report_response_integracoes'
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
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->integer('sequencia_baixa')
            ->requirePresence('sequencia_baixa', 'create')
            ->notEmptyString('sequencia_baixa');

        $validator
            ->dateTime('data_baixa')
            ->requirePresence('data_baixa', 'create')
            ->notEmptyDateTime('data_baixa');

        $validator
            ->scalar('agencia')
            ->maxLength('agencia', 45)
            ->allowEmptyString('agencia');

        $validator
            ->scalar('conta')
            ->maxLength('conta', 45)
            ->allowEmptyString('conta');

        $validator
            ->scalar('valor_baixa')
            ->requirePresence('valor_baixa', 'create')
            ->notEmptyString('valor_baixa');

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

        return $rules;
    }
}
