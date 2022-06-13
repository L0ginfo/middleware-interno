<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PlanejamentoMovimentacaoProdutos Model
 *
 * @property \App\Model\Table\ProdutosTable&\Cake\ORM\Association\BelongsTo $Produtos
 * @property \App\Model\Table\OperacoesTable&\Cake\ORM\Association\BelongsTo $Operacoes
 * @property \App\Model\Table\EnderecosTable&\Cake\ORM\Association\BelongsTo $Enderecos
 * @property \App\Model\Table\EnderecosTable&\Cake\ORM\Association\BelongsTo $Enderecos
 * @property \App\Model\Table\ControleProducoesTable&\Cake\ORM\Association\BelongsTo $ControleProducoes
 * @property \App\Model\Table\PlanejamentoMovimentacaoInternasTable&\Cake\ORM\Association\HasMany $PlanejamentoMovimentacaoInternas
 * @property \App\Model\Table\PlanejamentoMovimentacaoVeiculosTable&\Cake\ORM\Association\HasMany $PlanejamentoMovimentacaoVeiculos
 * @property \App\Model\Table\PlanejamentoSolicitacaoPesagensTable&\Cake\ORM\Association\HasMany $PlanejamentoSolicitacaoPesagens
 *
 * @method \App\Model\Entity\PlanejamentoMovimentacaoProduto get($primaryKey, $options = [])
 * @method \App\Model\Entity\PlanejamentoMovimentacaoProduto newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PlanejamentoMovimentacaoProduto[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PlanejamentoMovimentacaoProduto|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PlanejamentoMovimentacaoProduto saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PlanejamentoMovimentacaoProduto patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PlanejamentoMovimentacaoProduto[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PlanejamentoMovimentacaoProduto findOrCreate($search, callable $callback = null, $options = [])
 */
class PlanejamentoMovimentacaoProdutosTable extends Table
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
        

        $this->setTable('planejamento_movimentacao_produtos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('Produtos', [
            'foreignKey' => 'produto_id',
        ]);
        $this->belongsTo('Operacoes', [
            'foreignKey' => 'operacao_id',
        ]);
        $this->belongsTo('Enderecos', [
            'foreignKey' => 'endereco_origem_id',
        ]);
        $this->belongsTo('Enderecos', [
            'foreignKey' => 'endereco_destino_id',
        ]);
        $this->belongsTo('ControleProducoes', [
            'foreignKey' => 'controle_producao_id',
        ]);
        $this->hasMany('PlanejamentoMovimentacaoInternas', [
            'foreignKey' => 'planejamento_movimentacao_produto_id',
        ]);
        $this->hasMany('PlanejamentoMovimentacaoVeiculos', [
            'foreignKey' => 'planejamento_movimentacao_produto_id',
        ]);
        $this->hasMany('PlanejamentoSolicitacaoPesagens', [
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

        // $validator
        //     ->dateTime('data_hora_inicio')
        //     ->allowEmptyDateTime('data_hora_inicio');

        // $validator
        //     ->dateTime('data_hora_fim')
        //     ->allowEmptyDateTime('data_hora_fim');

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
        $rules->add($rules->existsIn(['produto_id'], 'Produtos'));
        $rules->add($rules->existsIn(['operacao_id'], 'Operacoes'));
        // $rules->add($rules->existsIn(['endereco_origem_id'], 'Enderecos'));
        // $rules->add($rules->existsIn(['endereco_destino_id'], 'Enderecos'));
        $rules->add($rules->existsIn(['controle_producao_id'], 'ControleProducoes'));

        return $rules;
    }
}
