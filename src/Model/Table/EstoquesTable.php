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
 * Estoques Model
 *
 * @property \App\Model\Table\UnidadeMedidasTable&\Cake\ORM\Association\BelongsTo $UnidadeMedidas
 * @property \App\Model\Table\EmpresasTable&\Cake\ORM\Association\BelongsTo $Empresas
 * @property \App\Model\Table\EstoqueEnderecosTable&\Cake\ORM\Association\HasMany $EstoqueEnderecos
 *
 * @method \App\Model\Entity\Estoque get($primaryKey, $options = [])
 * @method \App\Model\Entity\Estoque newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Estoque[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Estoque|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Estoque saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Estoque patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Estoque[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Estoque findOrCreate($search, callable $callback = null, $options = [])
 */
class EstoquesTable extends Table
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

        $this->setTable('estoques');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->addBehavior('LogsTabelas');

        $this->belongsTo('UnidadeMedidas', [
            'foreignKey' => 'unidade_medida_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Produtos', [
            'foreignKey' => 'produto_id',
            'joinType' => 'LEFT'
        ]);
        $this->belongsTo('Empresas', [
            'foreignKey' => 'empresa_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('LiberacoesDocumentaisItens', [
            'foreignKey' => 'id',
            'targetForeignKey' => 'estoque_id',
            'bindingKey' => 'estoque_id',
            'joinType' => 'INNER'
        ]);

        $this->hasMany('EntradaSaidaContainers', [
            'foreignKey' => 'container_id',
            'targetForeignKey' => 'container_id',
            'bindingKey' => 'container_id',
            'joinType' => 'LEFT'
        ]);

        $this->hasMany('EstoqueEnderecos', [
            'foreignKey' => 'estoque_id'
        ]);
        
        $this->hasMany('EtiquetaProdutos', [
            'foreignKey' => [
                'lote_item',
                'lote_codigo',
                'unidade_medida_id',
                'empresa_id'
            ],
            'targetForeignKey' => [
                'lote_item',
                'lote_codigo',
                'unidade_medida_id',
                'empresa_id'
            ],
            'bindingKey' => [
                'lote_item',
                'lote_codigo',
                'unidade_medida_id',
                'empresa_id'
            ],
        ]);

        $this->hasMany('MovimentacoesEstoques',[
            'foreignKey' => 'estoque_id',
            'bindingKey' => 'id',
        ]);

        $this->belongsTo('LiberacoesDocumentaisItensEspecial', [
            'className'=>'LiberacoesDocumentaisItens',
            'foreignKey' => 'id',
            'targetForeignKey' => 'estoque_id',
            'bindingKey' => 'estoque_id',
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

        $this->belongsTo('Containers', [
            'foreignKey' => 'container_id',
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
            
    }
}
