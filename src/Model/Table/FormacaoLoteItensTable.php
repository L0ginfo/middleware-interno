<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * FormacaoLoteItens Model
 *
 * @property \App\Model\Table\FormacaoLotesTable&\Cake\ORM\Association\BelongsTo $FormacaoLotes
 * @property \App\Model\Table\OrdemServicosTable&\Cake\ORM\Association\BelongsTo $OrdemServicos
 * @property \App\Model\Table\UnidadeMedidasTable&\Cake\ORM\Association\BelongsTo $UnidadeMedidas
 * @property \App\Model\Table\DocumentosMercadoriasItensTable&\Cake\ORM\Association\BelongsTo $DocumentosMercadoriasItens
 * @property \App\Model\Table\EmbalagensTable&\Cake\ORM\Association\BelongsTo $Embalagens
 * @property \App\Model\Table\ProdutosTable&\Cake\ORM\Association\BelongsTo $Produtos
 * @property \App\Model\Table\EnderecosTable&\Cake\ORM\Association\BelongsTo $Enderecos
 * @property \App\Model\Table\StatusEstoquesTable&\Cake\ORM\Association\BelongsTo $StatusEstoques
 *
 * @method \App\Model\Entity\FormacaoLoteItem get($primaryKey, $options = [])
 * @method \App\Model\Entity\FormacaoLoteItem newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\FormacaoLoteItem[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\FormacaoLoteItem|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FormacaoLoteItem saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FormacaoLoteItem patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\FormacaoLoteItem[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\FormacaoLoteItem findOrCreate($search, callable $callback = null, $options = [])
 */
class FormacaoLoteItensTable extends Table
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
        

        $this->setTable('formacao_lote_itens');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('FormacaoLotes', [
            'foreignKey' => 'formacao_lote_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('OrdemServicos', [
            'foreignKey' => 'ordem_servico_id',
        ]);
        $this->belongsTo('UnidadeMedidas', [
            'foreignKey' => 'unidade_medida_id',
        ]);
        $this->belongsTo('DocumentosMercadoriasItens', [
            'foreignKey' => 'documento_mercadoria_item_id',
        ]);
        $this->belongsTo('Embalagens', [
            'foreignKey' => 'embalagem_id',
        ]);
        $this->belongsTo('Produtos', [
            'foreignKey' => 'produto_id',
        ]);
        $this->belongsTo('Enderecos', [
            'foreignKey' => 'endereco_id',
        ]);
        $this->belongsTo('StatusEstoques', [
            'foreignKey' => 'status_estoque_id',
        ]);
        $this->belongsTo('DocumentosMercadoriasLoteInner', [
            'className'=>'DocumentosMercadorias',
            'foreignKey' => 'lote_codigo',
            'bindingKey' => 'lote_codigo',
            'joinType' => 'INNER'
        ])
        ->setConditions([
            'DocumentosMercadoriasLoteInner.lote_codigo is NOT NULL',
            'DocumentosMercadoriasLoteInner.lote_codigo <>' => ''
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

        $validator
            ->scalar('lote_item')
            ->maxLength('lote_item', 255)
            ->allowEmptyString('lote_item');

        $validator
            ->integer('sequencia_item')
            ->allowEmptyString('sequencia_item');

        $validator
            ->decimal('quantidade')
            ->allowEmptyString('quantidade');

        $validator
            ->decimal('peso')
            ->allowEmptyString('peso');

        $validator
            ->decimal('temperatura')
            ->allowEmptyString('temperatura');

        $validator
            ->decimal('m2')
            ->allowEmptyString('m2');

        $validator
            ->decimal('m3')
            ->allowEmptyString('m3');

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
        $rules->add($rules->existsIn(['formacao_lote_id'], 'FormacaoLotes'));
        $rules->add($rules->existsIn(['ordem_servico_id'], 'OrdemServicos'));
        $rules->add($rules->existsIn(['unidade_medida_id'], 'UnidadeMedidas'));
        $rules->add($rules->existsIn(['documento_mercadoria_item_id'], 'DocumentosMercadoriasItens'));
        $rules->add($rules->existsIn(['embalagem_id'], 'Embalagens'));
        $rules->add($rules->existsIn(['produto_id'], 'Produtos'));
        $rules->add($rules->existsIn(['endereco_id'], 'Enderecos'));
        $rules->add($rules->existsIn(['status_estoque_id'], 'StatusEstoques'));

        return $rules;
    }
}
