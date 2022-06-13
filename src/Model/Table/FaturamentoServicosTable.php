<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * FaturamentoServicos Model
 *
 * @property &\Cake\ORM\Association\BelongsTo $OrdemServicoServexecs
 * @property \App\Model\Table\TabelasPrecosServicosTable&\Cake\ORM\Association\BelongsTo $TabelasPrecosServicos
 * @property \App\Model\Table\FaturamentosTable&\Cake\ORM\Association\BelongsTo $Faturamentos
 * @property \App\Model\Table\EmpresasTable&\Cake\ORM\Association\BelongsTo $Empresas
 *
 * @method \App\Model\Entity\FaturamentoServico get($primaryKey, $options = [])
 * @method \App\Model\Entity\FaturamentoServico newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\FaturamentoServico[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\FaturamentoServico|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FaturamentoServico saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FaturamentoServico patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\FaturamentoServico[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\FaturamentoServico findOrCreate($search, callable $callback = null, $options = [])
 */
class FaturamentoServicosTable extends Table
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

        $this->setTable('faturamento_servicos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->addBehavior('LogsTabelas');

        $this->belongsTo('OrdemServicoServexecs', [
            'foreignKey' => 'ordem_servico_servexec_id'
        ]);
        $this->belongsTo('TabelasPrecosServicos', [
            'foreignKey' => 'tabela_preco_servico_id',
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
        $this->belongsTo('Servicos', [
            'foreignKey' => 'servico_id',
            'joinType' => 'INNER'
        ]);

        $this->belongsTo('DocumentosMercadorias', [
            'foreignKey' => 'documento_mercadoria_id',
            'joinType' => 'LEFT'
        ]);

        $this->belongsTo('LeftServicos', [
            'className' => 'Servicos',
            'foreignKey' => 'servico_id',
            'propertyName' => 'servico',
            'joinType' => 'LEFT'
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
            ->decimal('quantidade')
            ->requirePresence('quantidade', 'create')
            ->notEmptyString('quantidade');

        $validator
            ->decimal('valor_unitario')
            ->requirePresence('valor_unitario', 'create')
            ->notEmptyString('valor_unitario');

        $validator
            ->decimal('valor_total')
            ->requirePresence('valor_total', 'create')
            ->notEmptyString('valor_total');

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
        $rules->add($rules->existsIn(['ordem_servico_servexec_id'], 'OrdemServicoServexecs'));
        $rules->add($rules->existsIn(['tabela_preco_servico_id'], 'TabelasPrecosServicos'));
        $rules->add($rules->existsIn(['faturamento_id'], 'Faturamentos'));
        $rules->add($rules->existsIn(['empresa_id'], 'Empresas'));

        return $rules;
    }
}
