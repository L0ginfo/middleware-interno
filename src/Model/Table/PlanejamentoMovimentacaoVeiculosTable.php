<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PlanejamentoMovimentacaoVeiculos Model
 *
 * @property \App\Model\Table\VeiculosTable&\Cake\ORM\Association\BelongsTo $Veiculos
 * @property \App\Model\Table\PlanejamentoMovimentacaoProdutosTable&\Cake\ORM\Association\BelongsTo $PlanejamentoMovimentacaoProdutos
 *
 * @method \App\Model\Entity\PlanejamentoMovimentacaoVeiculo get($primaryKey, $options = [])
 * @method \App\Model\Entity\PlanejamentoMovimentacaoVeiculo newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PlanejamentoMovimentacaoVeiculo[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PlanejamentoMovimentacaoVeiculo|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PlanejamentoMovimentacaoVeiculo saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PlanejamentoMovimentacaoVeiculo patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PlanejamentoMovimentacaoVeiculo[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PlanejamentoMovimentacaoVeiculo findOrCreate($search, callable $callback = null, $options = [])
 */
class PlanejamentoMovimentacaoVeiculosTable extends Table
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
        

        $this->setTable('planejamento_movimentacao_veiculos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('Veiculos', [
            'foreignKey' => 'veiculo_id',
        ]);
        $this->belongsTo('PlanejamentoMovimentacaoProdutos', [
            'foreignKey' => 'planejamento_movimentacao_produto_id',
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
        $rules->add($rules->existsIn(['veiculo_id'], 'Veiculos'));
        $rules->add($rules->existsIn(['planejamento_movimentacao_produto_id'], 'PlanejamentoMovimentacaoProdutos'));

        return $rules;
    }
}
