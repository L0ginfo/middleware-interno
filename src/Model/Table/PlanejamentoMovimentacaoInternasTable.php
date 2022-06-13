<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PlanejamentoMovimentacaoInternas Model
 *
 * @property \App\Model\Table\PlanejamentoMovimentacaoProdutosTable&\Cake\ORM\Association\BelongsTo $PlanejamentoMovimentacaoProdutos
 * @property \App\Model\Table\ResvsTable&\Cake\ORM\Association\BelongsTo $Resvs
 * @property \App\Model\Table\EnderecosTable&\Cake\ORM\Association\BelongsTo $Enderecos
 * @property \App\Model\Table\EnderecosTable&\Cake\ORM\Association\BelongsTo $Enderecos
 * @property \App\Model\Table\EnderecosTable&\Cake\ORM\Association\BelongsTo $Enderecos
 * @property \App\Model\Table\ProdutosTable&\Cake\ORM\Association\BelongsTo $Produtos
 *
 * @method \App\Model\Entity\PlanejamentoMovimentacaoInterna get($primaryKey, $options = [])
 * @method \App\Model\Entity\PlanejamentoMovimentacaoInterna newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PlanejamentoMovimentacaoInterna[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PlanejamentoMovimentacaoInterna|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PlanejamentoMovimentacaoInterna saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PlanejamentoMovimentacaoInterna patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PlanejamentoMovimentacaoInterna[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PlanejamentoMovimentacaoInterna findOrCreate($search, callable $callback = null, $options = [])
 */
class PlanejamentoMovimentacaoInternasTable extends Table
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
        

        $this->setTable('planejamento_movimentacao_internas');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('PlanejamentoMovimentacaoProdutos', [
            'foreignKey' => 'planejamento_movimentacao_produto_id',
        ]);
        $this->belongsTo('Resvs', [
            'foreignKey' => 'resv_id',
        ]);
        $this->belongsTo('Enderecos', [
            'foreignKey' => 'endereco_origem_id',
        ]);
        $this->belongsTo('Enderecos', [
            'foreignKey' => 'endereco_destino_id',
        ]);
        $this->belongsTo('Enderecos', [
            'foreignKey' => 'endereco_destino_planejado_id',
        ]);
        $this->belongsTo('Produtos', [
            'foreignKey' => 'produto_id',
        ]);

        $this->belongsTo('EnderecoOrigem', [
            'foreignKey' => 'endereco_origem_id',
            'joinType' => 'LEFT',
            'className' => 'Enderecos', 
            'propertyName' => 'endereco_origem'
        ]);

        $this->belongsTo('EnderecoDestino', [
            'foreignKey' => 'endereco_destino_id',
            'joinType' => 'LEFT',
            'className' => 'Enderecos', 
            'propertyName' => 'endereco_destino'
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
            ->scalar('lote_codigo')
            ->maxLength('lote_codigo', 255)
            ->allowEmptyString('lote_codigo');

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
        $rules->add($rules->existsIn(['planejamento_movimentacao_produto_id'], 'PlanejamentoMovimentacaoProdutos'));
        $rules->add($rules->existsIn(['resv_id'], 'Resvs'));
        $rules->add($rules->existsIn(['endereco_origem_id'], 'Enderecos'));
        $rules->add($rules->existsIn(['endereco_destino_id'], 'Enderecos'));
        $rules->add($rules->existsIn(['endereco_destino_planejado_id'], 'Enderecos'));
        $rules->add($rules->existsIn(['produto_id'], 'Produtos'));

        return $rules;
    }
}
