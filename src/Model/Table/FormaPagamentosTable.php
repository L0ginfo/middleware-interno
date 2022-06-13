<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * FormaPagamentos Model
 *
 * @property \App\Model\Table\EmpresaFormaPagamentosTable&\Cake\ORM\Association\HasMany $EmpresaFormaPagamentos
 * @property \App\Model\Table\FaturamentoBaixasTable&\Cake\ORM\Association\HasMany $FaturamentoBaixas
 * @property \App\Model\Table\FaturamentosTable&\Cake\ORM\Association\HasMany $Faturamentos
 *
 * @method \App\Model\Entity\FormaPagamento get($primaryKey, $options = [])
 * @method \App\Model\Entity\FormaPagamento newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\FormaPagamento[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\FormaPagamento|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FormaPagamento saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FormaPagamento patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\FormaPagamento[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\FormaPagamento findOrCreate($search, callable $callback = null, $options = [])
 */
class FormaPagamentosTable extends Table
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

        $this->setTable('forma_pagamentos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->addBehavior('LogsTabelas');

        $this->hasMany('EmpresaFormaPagamentos', [
            'foreignKey' => 'forma_pagamento_id'
        ]);
        $this->hasMany('FaturamentoBaixas', [
            'foreignKey' => 'forma_pagamento_id'
        ]);
        $this->hasMany('Faturamentos', [
            'foreignKey' => 'forma_pagamento_id'
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
            ->scalar('descricao')
            ->maxLength('descricao', 255)
            ->requirePresence('descricao', 'create')
            ->notEmptyString('descricao');

        return $validator;
    }
}
