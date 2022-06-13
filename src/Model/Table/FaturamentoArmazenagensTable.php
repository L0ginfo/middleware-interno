<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * FaturamentoArmazenagens Model
 *
 * @property \App\Model\Table\TabPrecosValidaPerArmsTable&\Cake\ORM\Association\BelongsTo $TabPrecosValidaPerArms
 * @property \App\Model\Table\TabelasPrecosPeriodosArmsTable&\Cake\ORM\Association\BelongsTo $TabelasPrecosPeriodosArms
 * @property \App\Model\Table\FaturamentosTable&\Cake\ORM\Association\BelongsTo $Faturamentos
 * @property \App\Model\Table\EmpresasTable&\Cake\ORM\Association\BelongsTo $Empresas
 *
 * @method \App\Model\Entity\FaturamentoArmazenagem get($primaryKey, $options = [])
 * @method \App\Model\Entity\FaturamentoArmazenagem newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\FaturamentoArmazenagem[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\FaturamentoArmazenagem|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FaturamentoArmazenagem saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FaturamentoArmazenagem patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\FaturamentoArmazenagem[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\FaturamentoArmazenagem findOrCreate($search, callable $callback = null, $options = [])
 */
class FaturamentoArmazenagensTable extends Table
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

        $this->setTable('faturamento_armazenagens');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->addBehavior('LogsTabelas');

        $this->belongsTo('TabPrecosValidaPerArms', [
            'foreignKey' => 'tab_preco_valida_per_arm_id'
        ]);
        $this->belongsTo('TabelasPrecosPeriodosArms', [
            'foreignKey' => 'tab_preco_per_arm_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Faturamentos', [
            'foreignKey' => 'faturamento_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Empresas', [
            'foreignKey' => 'empresa_id',
            'joinType' => 'INNER'
        ]);

        $this->hasMany('FaturamentoBaixas', [
            'foreignKey' => 'faturamento_armazenagem_id',
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
            ->integer('periodo_dias')
            ->requirePresence('periodo_dias', 'create')
            ->notEmptyString('periodo_dias');

        $validator
            ->date('vencimento_periodo')
            ->requirePresence('vencimento_periodo', 'create')
            ->notEmptyDate('vencimento_periodo');

        $validator
            ->decimal('valor_periodo')
            ->requirePresence('valor_periodo', 'create')
            ->notEmptyString('valor_periodo');

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
        $rules->add($rules->existsIn(['tab_preco_valida_per_arm_id'], 'TabPrecosValidaPerArms'));
        $rules->add($rules->existsIn(['tab_preco_per_arm_id'], 'TabelasPrecosPeriodosArms'));
        $rules->add($rules->existsIn(['faturamento_id'], 'Faturamentos'));
        $rules->add($rules->existsIn(['empresa_id'], 'Empresas'));

        return $rules;
    }
}
