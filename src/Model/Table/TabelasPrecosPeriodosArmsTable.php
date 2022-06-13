<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TabelasPrecosPeriodosArms Model
 *
 * @property \App\Model\Table\TabelasPrecosTable&\Cake\ORM\Association\BelongsTo $TabelasPrecos
 * @property \App\Model\Table\SistemaCamposTable&\Cake\ORM\Association\BelongsTo $SistemaCampos
 * @property \App\Model\Table\ServicosTable&\Cake\ORM\Association\BelongsTo $Servicos
 * @property &\Cake\ORM\Association\BelongsTo $TiposValores
 *
 * @method \App\Model\Entity\TabelasPrecosPeriodosArm get($primaryKey, $options = [])
 * @method \App\Model\Entity\TabelasPrecosPeriodosArm newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TabelasPrecosPeriodosArm[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TabelasPrecosPeriodosArm|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TabelasPrecosPeriodosArm saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TabelasPrecosPeriodosArm patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TabelasPrecosPeriodosArm[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TabelasPrecosPeriodosArm findOrCreate($search, callable $callback = null, $options = [])
 */
class TabelasPrecosPeriodosArmsTable extends Table
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

        $this->setTable('tabelas_precos_periodos_arms');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->addBehavior('LogsTabelas');

        $this->belongsTo('TabelasPrecos', [
            'foreignKey' => 'tabela_preco_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('SistemaCampos', [
            'foreignKey' => 'campo_valor_sistema_id'
        ]);
        $this->belongsTo('Servicos', [
            'foreignKey' => 'servico_id'
        ]);
        $this->belongsTo('TabelaPrecoPeriodicidades', [
            'foreignKey' => 'tabela_preco_periodicidade_id'
        ]);
        $this->belongsTo('TiposValores', [
            'foreignKey' => 'tipo_valor_id',
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
            ->integer('dias')
            ->requirePresence('dias', 'create')
            ->notEmptyString('dias');

        $validator
            ->integer('periodo_inicial')
            ->requirePresence('periodo_inicial', 'create')
            ->notEmptyString('periodo_inicial');

        $validator
            ->integer('periodo_final')
            ->allowEmptyString('periodo_final');

        $validator
            ->decimal('valor')
            ->allowEmptyString('valor');

        $validator
            ->integer('carencia')
            ->requirePresence('carencia', 'create')
            ->notEmptyString('carencia');

        $validator
            ->integer('prorata')
            ->requirePresence('prorata', 'create')
            ->notEmptyString('prorata');

        $validator
            ->decimal('valor_minimo')
            ->allowEmptyString('valor_minimo');

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
        $rules->add($rules->existsIn(['tabela_preco_id'], 'TabelasPrecos'));
        $rules->add($rules->existsIn(['campo_valor_sistema_id'], 'SistemaCampos'));
        $rules->add($rules->existsIn(['servico_id'], 'Servicos'));
        $rules->add($rules->existsIn(['tipo_valor_id'], 'TiposValores'));

        return $rules;
    }
}
