<?php
namespace App\Model\Table;

use App\Model\Entity\EntradaSaidaContainer;
use ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OrdemServicoItens Model
 *
 * @property \App\Model\Table\OrdemServicosTable&\Cake\ORM\Association\BelongsTo $OrdemServicos
 * @property \App\Model\Table\UnidadeMedidasTable&\Cake\ORM\Association\BelongsTo $UnidadeMedidas
 * @property \App\Model\Table\DocumentosMercadoriasItensTable&\Cake\ORM\Association\BelongsTo $DocumentosMercadoriasItens
 * @property \App\Model\Table\EmbalagensTable&\Cake\ORM\Association\BelongsTo $Embalagens
 * @property \App\Model\Table\TermoAvariasTable&\Cake\ORM\Association\HasMany $TermoAvarias
 *
 * @method \App\Model\Entity\OrdemServicoItem get($primaryKey, $options = [])
 * @method \App\Model\Entity\OrdemServicoItem newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\OrdemServicoItem[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\OrdemServicoItem|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OrdemServicoItem saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OrdemServicoItem patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\OrdemServicoItem[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\OrdemServicoItem findOrCreate($search, callable $callback = null, $options = [])
 */
class OrdemServicoItensTable extends Table
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

        $this->setTable('ordem_servico_itens');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->addBehavior('LogsTabelas');

        $this->belongsTo('OrdemServicos', [
            'foreignKey' => 'ordem_servico_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('OrdemServicosLeft', [
            'className' => 'OrdemServicos',
            'foreignKey' => 'ordem_servico_id',
            'propertyName' => 'ordem_servico',
            'joinType' => 'LEFT'
        ]);
        $this->belongsTo('UnidadeMedidas', [
            'foreignKey' => 'unidade_medida_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Enderecos', [
            'foreignKey' => 'endereco_id',
            'joinType' => 'LEFT'
        ]);
        $this->hasMany('EstoqueEnderecos', [
            'className' => 'EstoqueEnderecos',
            'foreignKey' => 'lote_codigo',
            'bindingKey' => 'lote_codigo',
        ]);
        $this->belongsTo('DocumentosMercadoriasItens', [
            'foreignKey' => 'documento_mercadoria_item_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Embalagens', [
            'foreignKey' => 'embalagem_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Produtos', [
            'foreignKey' => 'produto_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('TermoAvarias', [
            'foreignKey' => 'ordem_servico_item_id'
        ]);
        $this->hasMany('TermoAvariasLeft', [
            'joinType' => 'LEFT',
            'className' => 'TermoAvarias',
            'propertyName' => 'termo_avarias',
            'foreignKey' => 'ordem_servico_item_id'
        ]);
        $this->hasMany('EtiquetaProdutosByAgroup', [
            'joinType' => 'LEFT',
            'className' => 'EtiquetaProdutos',
            'foreignKey' => [
                'unidade_medida_id',
                'documento_mercadoria_item_id',
                'produto_id',
                'lote',
                'serie',
                'validade',
                'endereco_id',
            ],
            'targetForeignKey' => [
                'unidade_medida_id',
                'documento_mercadoria_item_id',
                'produto_id',
                'lote',
                'serie',
                'validade',
                'endereco_id',
            ],
            'bindingKey' => [
                'unidade_medida_id',
                'documento_mercadoria_item_id',
                'produto_id',
                'lote',
                'serie',
                'validade',
                'endereco_id',
            ],
        ]);
        $this->hasMany('EtiquetaProdutosLeft', [
            'joinType' => 'LEFT',
            'className' => 'EtiquetaProdutos',
            'foreignKey' => 'ordem_servico_item_id'
        ]);
        $this->belongsTo('Containers', [
            'foreignKey' => 'container_id',
            'joinType' => 'LEFT'
        ]);
        $this->belongsTo('ProdutosLeft', [
            'foreignKey' => 'produto_id',
            'joinType' => 'LEFT',
            'className' => 'Produtos', 
            'propertyName' => 'produto'
        ]);
        $this->belongsTo('ControleEspecificos', [
            'foreignKey' => 'controle_especifico_id',
            'joinType' => 'LEFT'
        ]);

        $this->belongsTo('DocumentosMercadoriasLote', [
            'className'=>'DocumentosMercadorias',
            'foreignKey' => 'lote_codigo',
            'bindingKey' => 'lote_codigo',
            'joinType' => 'LEFT'
        ])
        ->setConditions([
            'DocumentosMercadoriasLote.lote_codigo is NOT NULL',
            'DocumentosMercadoriasLote.lote_codigo <>' => ''
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
            ->requirePresence('quantidade', 'create')
            ->notEmptyString('quantidade');

        $validator
            ->requirePresence('peso', 'create')
            ->notEmptyString('peso');

        $validator
            ->requirePresence('m2', 'create')
            ->notEmptyString('m2');

        $validator
            ->requirePresence('m3', 'create')
            ->notEmptyString('m3');

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
        $rules->add($rules->existsIn(['unidade_medida_id'], 'UnidadeMedidas'));
        $rules->add($rules->existsIn(['documento_mercadoria_item_id'], 'DocumentosMercadoriasItens'));
        $rules->add($rules->existsIn(['embalagem_id'], 'Embalagens'));

        return $rules;
    }

    public function beforeSave(Event $event, EntityInterface $entity, ArrayObject $options)
    {
        if ($entity->lote == '')
            $entity->lote = null;
            
        if ($entity->serie == '')
            $entity->serie = null;
        
        if ($entity->validade == '')
            $entity->validade = null;
            
        if ($entity->status_estoque_id == '')
            $entity->status_estoque_id = 1;

        if ($entity->container_id) {
            $oEntradaSaidaContainers = EntradaSaidaContainer::getLastByContainerId($entity->container_id);
            $entity->entrada_saida_container_id = @$oEntradaSaidaContainers->id;
        }
    }
}
