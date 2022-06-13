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
 * OrdemServicoItemSeparacoes Model
 *
 * @property \App\Model\Table\UnidadeMedidasTable&\Cake\ORM\Association\BelongsTo $UnidadeMedidas
 * @property \App\Model\Table\EnderecosTable&\Cake\ORM\Association\BelongsTo $Enderecos
 * @property \App\Model\Table\EnderecosTable&\Cake\ORM\Association\BelongsTo $Enderecos
 * @property \App\Model\Table\EstoquesTable&\Cake\ORM\Association\BelongsTo $Estoques
 * @property \App\Model\Table\EmpresasTable&\Cake\ORM\Association\BelongsTo $Empresas
 * @property \App\Model\Table\ProdutosTable&\Cake\ORM\Association\BelongsTo $Produtos
 * @property \App\Model\Table\OrdemServicosTable&\Cake\ORM\Association\BelongsTo $OrdemServicos
 * @property &\Cake\ORM\Association\BelongsTo $SeparacaoCargaItens
 * @property &\Cake\ORM\Association\HasMany $FormacaoCargaVolumeItens
 *
 * @method \App\Model\Entity\OrdemServicoItemSeparacao get($primaryKey, $options = [])
 * @method \App\Model\Entity\OrdemServicoItemSeparacao newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\OrdemServicoItemSeparacao[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\OrdemServicoItemSeparacao|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OrdemServicoItemSeparacao saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OrdemServicoItemSeparacao patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\OrdemServicoItemSeparacao[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\OrdemServicoItemSeparacao findOrCreate($search, callable $callback = null, $options = [])
 */
class OrdemServicoItemSeparacoesTable extends Table
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
        

        $this->setTable('ordem_servico_item_separacoes');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('UnidadeMedidas', [
            'foreignKey' => 'unidade_medida_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Enderecos', [
            'foreignKey' => 'endereco_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('EnderecoSeparacao', [
            'foreignKey' => 'endereco_separacao_id',
            'joinType' => 'LEFT',
            'className' => 'Enderecos'
        ]);
        $this->belongsTo('Estoques', [
            'foreignKey' => 'estoque_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Empresas', [
            'foreignKey' => 'empresa_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Produtos', [
            'foreignKey' => 'produto_id',
        ]);
        $this->belongsTo('OrdemServicos', [
            'foreignKey' => 'ordem_servico_id',
        ]);
        $this->belongsTo('SeparacaoCargaItens', [
            'foreignKey' => 'separacao_carga_item_id',
        ]);
        $this->hasMany('FormacaoCargaVolumeItens', [
            'foreignKey' => 'ordem_servico_item_separacao_id',
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
            ->scalar('endereco_composicao')
            ->maxLength('endereco_composicao', 255)
            ->requirePresence('endereco_composicao', 'create')
            ->notEmptyString('endereco_composicao');

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
        $rules->add($rules->existsIn(['unidade_medida_id'], 'UnidadeMedidas'));
        $rules->add($rules->existsIn(['endereco_id'], 'Enderecos'));
        $rules->add($rules->existsIn(['endereco_separacao_id'], 'Enderecos'));
        $rules->add($rules->existsIn(['estoque_id'], 'Estoques'));
        $rules->add($rules->existsIn(['empresa_id'], 'Empresas'));
        $rules->add($rules->existsIn(['produto_id'], 'Produtos'));
        $rules->add($rules->existsIn(['ordem_servico_id'], 'OrdemServicos'));
        $rules->add($rules->existsIn(['separacao_carga_item_id'], 'SeparacaoCargaItens'));

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
