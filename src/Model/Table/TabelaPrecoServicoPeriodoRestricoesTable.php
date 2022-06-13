<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TabelaPrecoServicoPeriodoRestricoes Model
 *
 * @property \App\Model\Table\TabelasPrecosServicosTable&\Cake\ORM\Association\BelongsTo $TabelasPrecosServicos
 * @property \App\Model\Table\TabelasPrecosPeriodosArmsTable&\Cake\ORM\Association\BelongsTo $TabelasPrecosPeriodosArms
 *
 * @method \App\Model\Entity\TabelaPrecoServicoPeriodoRestricao get($primaryKey, $options = [])
 * @method \App\Model\Entity\TabelaPrecoServicoPeriodoRestricao newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TabelaPrecoServicoPeriodoRestricao[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TabelaPrecoServicoPeriodoRestricao|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TabelaPrecoServicoPeriodoRestricao saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TabelaPrecoServicoPeriodoRestricao patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TabelaPrecoServicoPeriodoRestricao[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TabelaPrecoServicoPeriodoRestricao findOrCreate($search, callable $callback = null, $options = [])
 */
class TabelaPrecoServicoPeriodoRestricoesTable extends Table
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
        

        $this->setTable('tabela_preco_servico_periodo_restricoes');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('TabelasPrecosServicos', [
            'foreignKey' => 'tabela_preco_servico_id',
        ]);
        $this->belongsTo('TabelasPrecosPeriodosArms', [
            'foreignKey' => 'tabela_preco_periodo_arm_id',
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
        $rules->add($rules->existsIn(['tabela_preco_servico_id'], 'TabelasPrecosServicos'));
        $rules->add($rules->existsIn(['tabela_preco_periodo_arm_id'], 'TabelasPrecosPeriodosArms'));

        return $rules;
    }
}
