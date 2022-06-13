<?php
namespace App\Model\Table;

use ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Phinx\Db\Table\ForeignKey;

/**
 * EtiquetaProdutos Model
 *
 * @property \App\Model\Table\EnderecosTable&\Cake\ORM\Association\BelongsTo $Enderecos
 * @property \App\Model\Table\UnidadeMedidasTable&\Cake\ORM\Association\BelongsTo $UnidadeMedidas
 * @property \App\Model\Table\EmpresasTable&\Cake\ORM\Association\BelongsTo $Empresas
 * @property &\Cake\ORM\Association\BelongsTo $DocumentosMercadoriasItens
 *
 * @method \App\Model\Entity\EtiquetaProduto get($primaryKey, $options = [])
 * @method \App\Model\Entity\EtiquetaProduto newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\EtiquetaProduto[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EtiquetaProduto|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EtiquetaProduto saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EtiquetaProduto patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\EtiquetaProduto[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\EtiquetaProduto findOrCreate($search, callable $callback = null, $options = [])
 */
class EtiquetaProdutosTable extends Table
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

        $this->setTable('etiqueta_produtos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->addBehavior('LogsTabelas');

        $this->belongsTo('Enderecos', [
            'foreignKey' => 'endereco_id',
            'joinType' => 'INNER'
        ]);
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

        $this->belongsTo('OrdemServicoItensBelongs', [
            'className' => 'OrdemServicoItens',
            'propertyName' => 'ordem_servico_item',
            'foreignKey' => 'ordem_servico_item_id',
            'joinType' => 'LEFT'
        ]);

        $this->belongsTo('Containers', [
            'foreignKey' => 'container_id',
            'joinType' => 'LEFT'
        ]);

        $this->belongsTo('DocumentosMercadoriasItens', [
            'foreignKey' => 'documento_mercadoria_item_id'
        ]);

        $this->belongsTo('DocumentosMercadoriasItensLeft', [
            'foreignKey' => 'documento_mercadoria_item_id',
            'className' => 'DocumentosMercadoriasItens',
            'propertyName' => 'documentos_mercadorias_item',
            'joinType' => 'LEFT'
        ]);

        $this->hasMany('Estoques', [
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

        $this->hasOne('EstoquesMercadorias', [
            'className'=>'Estoques',
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


        $this->hasOne('HasOneOrdemServicoItens', [
            'className'=>'OrdemServicoItens',
            'propertyName' => 'ordem_servico_item',
            'foreignKey' => [
                'unidade_medida_id',
                'documento_mercadoria_item_id',
                'produto_id',
            ],
            'targetForeignKey' => [
                'unidade_medida_id',
                'documento_mercadoria_item_id',
                'produto_id',
            ],
            'bindingKey' => [
                'unidade_medida_id',
                'documento_mercadoria_item_id',
                'produto_id',
            ],
        ]);
        
        $this->hasOne('OrdemServicoItensByID', [
            'className'=>'OrdemServicoItens',
            'propertyName' => 'ordem_servico_item',
            'foreignKey' => 'id',
            'targetForeignKey' => 'ordem_servico_item_id',
            'bindingKey' => 'ordem_servico_item_id',
        ]);

        $this->hasMany('OrdemServicoItens', [
            'foreignKey' => [
                'unidade_medida_id',
                'documento_mercadoria_item_id',
            ],
            'targetForeignKey' => [
                'unidade_medida_id',
                'documento_mercadoria_item_id',
            ],
            'bindingKey' => [
                'unidade_medida_id',
                'documento_mercadoria_item_id',
            ],
        ]);

        

        $this->hasMany('OrdemServicoEtiquetaCarregamentos');

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

        $this->hasOne('OrdemServicoDocumentoRegimeEspecialItens', [
            'foreignKey' => [
                'lote_codigo',
                'lote_item',
                'unidade_medida_id',
                'endereco_id',
            ],
            'bindingKey' => [
                'lote_codigo',
                'lote_item',
                'unidade_medida_id',
                'endereco_id',
            ]
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
            ->scalar('lote_item')
            ->maxLength('lote_item', 15)
            ->allowEmptyString('lote_item');

        $validator
            ->integer('sequencia')
            ->requirePresence('sequencia', 'create')
            ->notEmptyString('sequencia');

        $validator
            ->scalar('codigo_barras')
            ->maxLength('codigo_barras', 15)
            ->requirePresence('codigo_barras', 'create')
            ->notEmptyString('codigo_barras');

        $validator
            ->decimal('qtde')
            ->requirePresence('qtde', 'create')
            ->notEmptyString('qtde');

        $validator
            ->decimal('peso')
            ->requirePresence('peso', 'create')
            ->notEmptyString('peso');

        $validator
            ->decimal('m2')
            ->requirePresence('m2', 'create')
            ->notEmptyString('m2');

        $validator
            ->decimal('m3')
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
        $rules->add($rules->existsIn(['endereco_id'], 'Enderecos'));
        $rules->add($rules->existsIn(['unidade_medida_id'], 'UnidadeMedidas'));
        $rules->add($rules->existsIn(['empresa_id'], 'Empresas'));
        $rules->add($rules->existsIn(['documento_mercadoria_item_id'], 'DocumentosMercadoriasItens'));

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
