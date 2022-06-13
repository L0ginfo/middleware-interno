<?php
namespace App\Model\Table;

use ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EstoqueEnderecos Model
 *
 * @property \App\Model\Table\UnidadeMedidasTable&\Cake\ORM\Association\BelongsTo $UnidadeMedidas
 * @property \App\Model\Table\EnderecosTable&\Cake\ORM\Association\BelongsTo $Enderecos
 * @property \App\Model\Table\EstoquesTable&\Cake\ORM\Association\BelongsTo $Estoques
 * @property \App\Model\Table\EmpresasTable&\Cake\ORM\Association\BelongsTo $Empresas
 *
 * @method \App\Model\Entity\EstoqueEndereco get($primaryKey, $options = [])
 * @method \App\Model\Entity\EstoqueEndereco newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\EstoqueEndereco[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EstoqueEndereco|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EstoqueEndereco saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EstoqueEndereco patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\EstoqueEndereco[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\EstoqueEndereco findOrCreate($search, callable $callback = null, $options = [])
 */
class EstoqueEnderecosTable extends Table
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

        $this->setTable('estoque_enderecos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey(['id']);

        $this->addBehavior('LogsTabelas');

        $this->belongsTo('UnidadeMedidas', [
            'foreignKey' => 'unidade_medida_id',
            'joinType' => 'INNER'
        ]);

        $this->belongsTo('StatusEstoques', [
            'foreignKey' => 'status_estoque_id',
            'joinType' => 'LEFT'
        ]);

        $this->belongsTo('Produtos', [
            'foreignKey' => 'produto_id',
            'joinType' => 'LEFT'
        ]);
        $this->belongsTo('Enderecos', [
            'foreignKey' => 'endereco_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Estoques', [
            'foreignKey' => 'estoque_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Empresas', [
            'foreignKey' => 'empresa_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Containers', [
            'foreignKey' => 'container_id',
            'joinType' => 'LEFT'
        ]);

        $this->hasMany('EstoqueEnderecoReservas', [
            'foreignKey' => 'estoque_endereco_id',
            'joinType' => 'LEFT'
        ]);
        
        $this->belongsTo('LiberacoesDocumentaisItens', [
            'foreignKey' => [
                'lote_codigo',
                'lote_item',
            ],
            'bindingKey' => [
                'lote_codigo',
                'lote_item',
            ],
            'joinType' => 'LEFT'
        ]);

        $this->belongsTo('LiberacoesDocumentaisItensInner', [
            'className' => 'LiberacoesDocumentaisItens',
            'foreignKey' => [
                'lote_codigo',
                'lote_item',
                'produto_id',
            ],
            'bindingKey' => [
                'lote_codigo',
                'lote_item',
                'produto_id',
            ],
            'joinType' => 'INNER'
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

        $this->hasMany('OrdemServicoUnitizacoesLeft', [
            'className'=>'OrdemServicoUnitizacoes',
            'foreignKey' => 'lote_codigo',
            'bindingKey' => 'lote_codigo',
            'joinType' => 'LEFT'
        ])
        ->setConditions([
            'OrdemServicoUnitizacoesLeft.lote_codigo = lote_codigo',
            'OrdemServicoUnitizacoesLeft.lote_item = lote_item',
            'OrdemServicoUnitizacoesLeft.produto_id = produto_id',
            'OrdemServicoUnitizacoesLeft.container_id = container_id'
        ]);

        $this->belongsTo('PlanejamentoRetiradas', [
            'foreignKey' => [
                'lote_codigo',
                'lote_item',
                'produto_id',
                'endereco_id',
                'unidade_medida_id',
                'status_estoque_id',
            ],
            'bindingKey' => [
                'lote_codigo',
                'lote_item',
                'produto_id',
                'endereco_id',
                'unidade_medida_id',
                'status_estoque_id',
            ],
            'joinType' => 'LEFT'
        ]);

        $this->hasMany('EtiquetaProdutos', [
            'foreignKey' => [
                'lote_item',
                'lote_codigo',
                'unidade_medida_id',
                'endereco_id',
                'empresa_id'
            ],
            'targetForeignKey' => [
                'lote_item',
                'lote_codigo',
                'unidade_medida_id',
                'endereco_id',
                'empresa_id'
            ],
            'bindingKey' => [
                'lote_item',
                'lote_codigo',
                'unidade_medida_id',
                'endereco_id',
                'empresa_id'
            ],
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
            ->scalar('produto_codigo')
            ->maxLength('produto_codigo', 15)
            ->allowEmptyString('produto_codigo');

        $validator
            ->scalar('lote_codigo')
            ->maxLength('lote_codigo', 15)
            ->allowEmptyString('lote_codigo');

        $validator
            ->integer('lote_item')
            ->maxLength('lote_item', 15)
            ->allowEmptyString('lote_item');

        $validator
            ->requirePresence('qtde_saldo', 'create')
            ->notEmptyString('qtde_saldo');

        $validator
            ->requirePresence('peso_saldo', 'create')
            ->notEmptyString('peso_saldo');

        $validator
            ->requirePresence('m2_saldo', 'create')
            ->notEmptyString('m2_saldo');

        $validator
            ->requirePresence('m3_saldo', 'create')
            ->notEmptyString('m3_saldo');

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
        $rules->add($rules->existsIn(['unidade_medida_id'], 'UnidadeMedidas'));
        $rules->add($rules->existsIn(['endereco_id'], 'Enderecos'));
        $rules->add($rules->existsIn(['estoque_id'], 'Estoques'));
        $rules->add($rules->existsIn(['empresa_id'], 'Empresas'));

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
    }
}
