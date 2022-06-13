<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EmpresaFormaPagamentos Model
 *
 * @property \App\Model\Table\EmpresasTable&\Cake\ORM\Association\BelongsTo $Empresas
 * @property \App\Model\Table\FormaPagamentosTable&\Cake\ORM\Association\BelongsTo $FormaPagamentos
 *
 * @method \App\Model\Entity\EmpresaFormaPagamento get($primaryKey, $options = [])
 * @method \App\Model\Entity\EmpresaFormaPagamento newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\EmpresaFormaPagamento[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EmpresaFormaPagamento|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EmpresaFormaPagamento saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EmpresaFormaPagamento patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\EmpresaFormaPagamento[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\EmpresaFormaPagamento findOrCreate($search, callable $callback = null, $options = [])
 */
class EmpresaFormaPagamentosTable extends Table
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

        $this->setTable('empresa_forma_pagamentos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->addBehavior('LogsTabelas');

        $this->belongsTo('Empresas', [
            'foreignKey' => 'cliente_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('FormaPagamentos', [
            'foreignKey' => 'forma_pagamento_id',
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
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('destino')
            ->maxLength('destino', 255)
            ->requirePresence('destino', 'create')
            ->notEmptyString('destino');

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
        $rules->add($rules->existsIn(['cliente_id'], 'Empresas'));
        $rules->add($rules->existsIn(['forma_pagamento_id'], 'FormaPagamentos'));

        return $rules;
    }
}
