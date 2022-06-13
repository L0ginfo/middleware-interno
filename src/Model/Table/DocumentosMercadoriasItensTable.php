<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DocumentosMercadoriasItens Model
 *
 * @property \App\Model\Table\ProdutosTable&\Cake\ORM\Association\BelongsTo $Produtos
 * @property \App\Model\Table\DocumentosMercadoriasTable&\Cake\ORM\Association\BelongsTo $DocumentosMercadorias
 * @property \App\Model\Table\UnidadeMedidasTable&\Cake\ORM\Association\BelongsTo $UnidadeMedidas
 *
 * @method \App\Model\Entity\DocumentosMercadoriasItem get($primaryKey, $options = [])
 * @method \App\Model\Entity\DocumentosMercadoriasItem newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\DocumentosMercadoriasItem[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DocumentosMercadoriasItem|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DocumentosMercadoriasItem saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DocumentosMercadoriasItem patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DocumentosMercadoriasItem[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\DocumentosMercadoriasItem findOrCreate($search, callable $callback = null, $options = [])
 */
class DocumentosMercadoriasItensTable extends Table
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

        $this->setTable('documentos_mercadorias_itens');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->addBehavior('LogsTabelas');

        $this->belongsTo('Produtos', [
            'foreignKey' => 'produto_id'
        ]);

        $this->belongsTo('Ncms', [
            'foreignKey' => 'ncm_id'
        ]);

        $this->belongsTo('DocumentosMercadorias', [
            'foreignKey' => 'documentos_mercadoria_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('DocumentosMercadoriasLeft', [
            'className' => 'DocumentosMercadorias',
            'foreignKey' => 'documentos_mercadoria_id',
            'propertyName' => 'documentos_mercadoria',
            'joinType' => 'LEFT'
        ]);
        $this->belongsTo('UnidadeMedidas', [
            'foreignKey' => 'unidade_medida_id',
            'joinType' => 'INNER'
        ]);

        $this->belongsTo('UnidadeMedidas', [
            'foreignKey' => 'unidade_medida_id',
            'joinType' => 'INNER'
        ]);
      
        //Ordem Servico
        //$this->hasMany('EtiquetaProdutos',[
        //   'foreignKey' => 'documento_mercadoria_item_id',
        //]);

        $this->hasMany('EtiquetaProdutos', [
            'foreignKey' => 'documento_mercadoria_item_id',
            'bindingKey' => 'id',
            'joinType' => 'INNER'
        ]);
        
        $this->hasMany('OrdemServicoItens', [
            'foreignKey' => 'documento_mercadoria_item_id',
            'joinType' => 'INNER'
        ]);

        $this->hasMany('PlanoCargaPoroes', [
            'foreignKey' => 'documento_mercadoria_item_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('ItemContainers', [
            'foreignKey' => 'documento_mercadoria_item_id',
            'joinType' => 'LEFT'
        ]);

        $this->hasMany('PlanoCargaItemDestinos', [ 
            'foreignKey' => 'documento_mercadoria_item_id', 
            'joinType' => 'LEFT'
        ]);

        $this->hasMany('DocumentoMercadoriaItemControleEspecificos', [ 
            'foreignKey' => 'documento_mercadoria_item_id', 
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
            ->integer('sequencia_item')
            ->requirePresence('sequencia_item', 'create')
            ->notEmptyString('sequencia_item');

        $validator
            ->scalar('descricao')
            ->requirePresence('descricao', 'create')
            ->allowEmptyString('descricao');

        $validator
            ->allowEmptyString('quantidade');

        $validator
            ->allowEmptyString('peso_liquido');

        $validator
            ->allowEmptyString('peso_bruto');

        $validator
            ->allowEmptyString('valor_unitario');

        $validator
            ->allowEmptyString('valor_total');

        $validator
            ->allowEmptyString('valor_frete_total');

        $validator
            ->allowEmptyString('valor_seguro_total');

        $validator
            ->allowEmptyString('temperatura');

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
        $rules->add($rules->existsIn(['documentos_mercadoria_id'], 'DocumentosMercadorias'));
        $rules->add($rules->existsIn(['unidade_medida_id'], 'UnidadeMedidas'));

        return $rules;
    }
}
