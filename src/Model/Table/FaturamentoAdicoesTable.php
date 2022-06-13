<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * FaturamentoAdicoes Model
 *
 * @property \App\Model\Table\LiberacaoDocumentalDecisaoTabelaPrecoAdicoesTable&\Cake\ORM\Association\BelongsTo $LiberacaoDocumentalDecisaoTabelaPrecoAdicoes
 * @property \App\Model\Table\FaturamentosTable&\Cake\ORM\Association\BelongsTo $Faturamentos
 * @property \App\Model\Table\TabelasPrecosTable&\Cake\ORM\Association\BelongsTo $TabelasPrecos
 * @property \App\Model\Table\TabelasPrecosPeriodosArmsTable&\Cake\ORM\Association\BelongsTo $TabelasPrecosPeriodosArms
 *
 * @method \App\Model\Entity\FaturamentoAdicao get($primaryKey, $options = [])
 * @method \App\Model\Entity\FaturamentoAdicao newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\FaturamentoAdicao[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\FaturamentoAdicao|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FaturamentoAdicao saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FaturamentoAdicao patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\FaturamentoAdicao[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\FaturamentoAdicao findOrCreate($search, callable $callback = null, $options = [])
 */
class FaturamentoAdicoesTable extends Table
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
        
        $this->addBehavior('LogsTabelas');
        

        $this->setTable('faturamento_adicoes');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('LiberacaoDocumentalDecisaoTabelaPrecoAdicoes', [
            'foreignKey' => 'adicao_id',
        ]);
        $this->belongsTo('Faturamentos', [
            'foreignKey' => 'faturamento_id',
        ]);
        $this->belongsTo('TabelasPrecos', [
            'foreignKey' => 'tabela_preco_id',
        ]);
        $this->belongsTo('TabelasPrecosPeriodosArms', [
            'foreignKey' => 'tab_preco_per_arm_id',
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
            ->scalar('numero_periodo')
            ->maxLength('numero_periodo', 255)
            ->allowEmptyString('numero_periodo');

        $validator
            ->decimal('valor_periodo')
            ->requirePresence('valor_periodo', 'create')
            ->notEmptyString('valor_periodo');

        $validator
            ->decimal('valor_periodo_servico')
            ->requirePresence('valor_periodo_servico', 'create')
            ->notEmptyString('valor_periodo_servico');

        $validator
            ->decimal('valor_restricao_servico')
            ->requirePresence('valor_restricao_servico', 'create')
            ->notEmptyString('valor_restricao_servico');

        $validator
            ->decimal('valor_final_servico')
            ->requirePresence('valor_final_servico', 'create')
            ->notEmptyString('valor_final_servico');

        $validator
            ->decimal('desconto')
            ->requirePresence('desconto', 'create')
            ->notEmptyString('desconto');

        $validator
            ->integer('restricao_servico')
            ->notEmptyString('restricao_servico');

        $validator
            ->integer('insento')
            ->notEmptyString('insento');

        $validator
            ->date('vencimento_periodo')
            ->allowEmptyDate('vencimento_periodo');

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
        $rules->add($rules->existsIn(['adicao_id'], 'LiberacaoDocumentalDecisaoTabelaPrecoAdicoes'));
        $rules->add($rules->existsIn(['faturamento_id'], 'Faturamentos'));
        $rules->add($rules->existsIn(['tabela_preco_id'], 'TabelasPrecos'));
        $rules->add($rules->existsIn(['tab_preco_per_arm_id'], 'TabelasPrecosPeriodosArms'));

        return $rules;
    }
}
