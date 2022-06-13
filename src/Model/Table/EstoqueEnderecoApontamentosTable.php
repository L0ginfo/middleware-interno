<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EstoqueEnderecoApontamentos Model
 *
 * @property \App\Model\Table\OrdemServicosTable&\Cake\ORM\Association\BelongsTo $OrdemServicos
 * @property \App\Model\Table\ProdutosTable&\Cake\ORM\Association\BelongsTo $Produtos
 * @property \App\Model\Table\ProdutosTable&\Cake\ORM\Association\BelongsTo $Produtos
 * @property \App\Model\Table\UnidadeMedidasTable&\Cake\ORM\Association\BelongsTo $UnidadeMedidas
 * @property \App\Model\Table\UnidadeMedidasTable&\Cake\ORM\Association\BelongsTo $UnidadeMedidas
 * @property \App\Model\Table\EnderecosTable&\Cake\ORM\Association\BelongsTo $Enderecos
 *
 * @method \App\Model\Entity\EstoqueEnderecoApontamento get($primaryKey, $options = [])
 * @method \App\Model\Entity\EstoqueEnderecoApontamento newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\EstoqueEnderecoApontamento[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EstoqueEnderecoApontamento|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EstoqueEnderecoApontamento saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EstoqueEnderecoApontamento patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\EstoqueEnderecoApontamento[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\EstoqueEnderecoApontamento findOrCreate($search, callable $callback = null, $options = [])
 */
class EstoqueEnderecoApontamentosTable extends Table
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
        

        $this->setTable('estoque_endereco_apontamentos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('OrdemServicos', [
            'foreignKey' => 'ordem_servico_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Produtos', [
            'foreignKey' => 'produto_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Produtos', [
            'foreignKey' => 'produto_final_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('UnidadeMedidas', [
            'foreignKey' => 'unidade_medida_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('UnidadeMedidas', [
            'foreignKey' => 'unidade_medida_final_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Enderecos', [
            'foreignKey' => 'endereco_id',
            'joinType' => 'INNER',
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
            ->maxLength('lote_codigo', 15)
            ->allowEmptyString('lote_codigo');

        $validator
            ->scalar('lote_item')
            ->maxLength('lote_item', 15)
            ->allowEmptyString('lote_item');

        $validator
            ->decimal('qtde_saldo')
            ->requirePresence('qtde_saldo', 'create')
            ->notEmptyString('qtde_saldo');

        $validator
            ->decimal('peso_saldo')
            ->requirePresence('peso_saldo', 'create')
            ->notEmptyString('peso_saldo');

        $validator
            ->decimal('m2_saldo')
            ->requirePresence('m2_saldo', 'create')
            ->notEmptyString('m2_saldo');

        $validator
            ->decimal('m3_saldo')
            ->requirePresence('m3_saldo', 'create')
            ->notEmptyString('m3_saldo');

        $validator
            ->scalar('lote')
            ->maxLength('lote', 255)
            ->allowEmptyString('lote');

        $validator
            ->scalar('serie')
            ->maxLength('serie', 255)
            ->allowEmptyString('serie');

        $validator
            ->dateTime('validade')
            ->allowEmptyDateTime('validade');

        $validator
            ->dateTime('created_at')
            ->notEmptyDateTime('created_at');

        $validator
            ->dateTime('updated_at')
            ->allowEmptyDateTime('updated_at');

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
        $rules->add($rules->existsIn(['ordem_servico_id'], 'OrdemServicos'));
        $rules->add($rules->existsIn(['produto_id'], 'Produtos'));
        $rules->add($rules->existsIn(['produto_final_id'], 'Produtos'));
        $rules->add($rules->existsIn(['unidade_medida_id'], 'UnidadeMedidas'));
        $rules->add($rules->existsIn(['unidade_medida_final_id'], 'UnidadeMedidas'));
        $rules->add($rules->existsIn(['endereco_id'], 'Enderecos'));

        return $rules;
    }
}
