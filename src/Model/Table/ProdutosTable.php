<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Produtos Model
 *
 * @property \App\Model\Table\NcmsTable&\Cake\ORM\Association\BelongsTo $Ncms
 * @property \App\Model\Table\EmpresasTable&\Cake\ORM\Association\BelongsTo $Empresas
 * @property \App\Model\Table\UnidadeMedidasTable&\Cake\ORM\Association\BelongsTo $UnidadeMedidas
 * @property \App\Model\Table\EmpresasTable&\Cake\ORM\Association\BelongsTo $Empresas
 * @property &\Cake\ORM\Association\BelongsTo $ProdutoClassificacoes
 * @property \App\Model\Table\DocumentosMercadoriasItensTable&\Cake\ORM\Association\HasMany $DocumentosMercadoriasItens
 *
 * @method \App\Model\Entity\Produto get($primaryKey, $options = [])
 * @method \App\Model\Entity\Produto newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Produto[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Produto|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Produto saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Produto patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Produto[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Produto findOrCreate($search, callable $callback = null, $options = [])
 */
class ProdutosTable extends Table
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
        

        $this->setTable('produtos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('Ncms', [
            'foreignKey' => 'ncm_id',
        ]);
        $this->belongsTo('Empresas', [
            'foreignKey' => 'empresa_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('UnidadeMedidas', [
            'foreignKey' => 'unidade_medida_id',
        ]);
        $this->belongsTo('ProdutoClassificacoes', [
            'foreignKey' => 'produto_classificacao_id',
        ]);
        $this->hasMany('DocumentosMercadoriasItens', [
            'foreignKey' => 'produto_id',
        ]);
        $this->belongsTo('Depositantes', [
            'className'=>'Empresas', 
            'foreignKey' => 'depositante_id',
        ]);
        $this->hasMany('DocumentosMercadoriasItens', [
            'foreignKey' => 'produto_id'
        ]);

        $this->hasMany('Estoques', [
            'foreignKey' => 'produto_id',
            'joinType' => 'LEFT',
        ]);

        $this->hasMany('OrdemServicoItemLingadas', [
            'foreignKey' => 'produto_id'
        ]);

        $this->hasMany('OrdemServicoItens', [
            'foreignKey' => 'produto_id'
        ]);

        $this->hasMany('ProdutoEstruturas');

        $this->hasMany('PlanoCargaPoroes', [
            'foreignKey' => 'produto_id',
        ]);

        $this->hasMany('ProdutoControleEspecificos', [
            'foreignKey' => 'produto_id',
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
            ->scalar('descricao')
            ->requirePresence('descricao', 'create')
            ->notEmptyString('descricao');

        $validator
            ->scalar('codigo')
            ->maxLength('codigo', 200)
            ->requirePresence('codigo', 'create')
            ->notEmptyString('codigo');

        $validator
            ->integer('is_controlado_validade')
            ->allowEmptyString('is_controlado_validade');

        $validator
            ->integer('is_usado_fifo')
            ->allowEmptyString('is_usado_fifo');

        $validator
            ->integer('controla_serie')
            ->allowEmptyString('controla_serie');

        $validator
            ->scalar('sku')
            ->maxLength('sku', 45)
            ->allowEmptyString('sku');

        $validator
            ->integer('controla_lote')
            ->allowEmptyString('controla_lote');

        $validator
            ->scalar('codigo_barras')
            ->maxLength('codigo_barras', 255)
            ->allowEmptyString('codigo_barras');

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
        //$rules->add($rules->existsIn(['ncm_id'], 'Ncms'));
        $rules->add($rules->existsIn(['empresa_id'], 'Empresas'));
        $rules->add($rules->existsIn(['unidade_medida_id'], 'UnidadeMedidas'));
        //$rules->add($rules->existsIn(['depositante_id'], 'Empresas'));
        $rules->add($rules->existsIn(['produto_classificacao_id'], 'ProdutoClassificacoes'));

        return $rules;
    }
}
