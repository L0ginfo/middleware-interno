<?php
namespace App\Model\Table;

use App\Model\Entity\EntradaSaidaContainer;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MovimentacoesEstoques Model
 *
 * @property \App\Model\Table\EstoquesTable&\Cake\ORM\Association\BelongsTo $Estoques
 * @property \App\Model\Table\EnderecosTable&\Cake\ORM\Association\BelongsTo $Enderecos
 * @property \App\Model\Table\EnderecosTable&\Cake\ORM\Association\BelongsTo $Enderecos
 * @property \App\Model\Table\TipoMovimentacoesTable&\Cake\ORM\Association\BelongsTo $TipoMovimentacoes
 *
 * @method \App\Model\Entity\MovimentacoesEstoque get($primaryKey, $options = [])
 * @method \App\Model\Entity\MovimentacoesEstoque newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\MovimentacoesEstoque[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MovimentacoesEstoque|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MovimentacoesEstoque saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MovimentacoesEstoque patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\MovimentacoesEstoque[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\MovimentacoesEstoque findOrCreate($search, callable $callback = null, $options = [])
 */
class MovimentacoesEstoquesTable extends Table
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

        $this->setTable('movimentacoes_estoques');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->addBehavior('LogsTabelas');

        // $this->belongsTo('Estoques', [
        //     'foreignKey' => 'estoque_id',
        //     'joinType' => 'INNER'
        // ]);
        
        $this->belongsTo('Produtos', [
            'className'=>'Produtos',
            'foreignKey' => 'produto_id',
            'joinType' => 'LEFT'
        ]);
        
        $this->belongsTo('Usuarios', [
            'className'=>'Usuarios',
            'foreignKey' => 'usuario_conectado_id',
            'joinType' => 'LEFT'
        ]);
        
        $this->belongsTo('StatusEstoques', [
            'className'=>'StatusEstoques',
            'foreignKey' => 'status_estoque_id',
            'joinType' => 'LEFT'
        ]);
        
        $this->belongsTo('StatusEstoquesAnterior', [
            'className'=>'StatusEstoques',
            'propertyName' => 'status_estoque_anterior',
            'foreignKey' => 'status_estoque_anterior_id',
            'joinType' => 'LEFT'
        ]);
        
        $this->belongsTo('UnidadeMedidaAnterior', [
            'className'=>'UnidadeMedidas',
            'foreignKey' => 'unidade_medida_anterior_id',
            'joinType' => 'LEFT'
        ]);
        $this->belongsTo('UnidadeMedidaNova', [
            'className'=>'UnidadeMedidas',
            'foreignKey' => 'unidade_medida_nova_id',
            'joinType' => 'LEFT'
        ]);

        
        $this->belongsTo('EnderecoOrigem', [
            'className'=>'Enderecos',
            'foreignKey' => 'endereco_origem_id',
            'joinType' => 'LEFT'
        ]);
        $this->belongsTo('EnderecoDestino', [
            'className'=>'Enderecos',
            'foreignKey' => 'endereco_destino_id',
            'joinType' => 'LEFT'
        ]);
        $this->belongsTo('TipoMovimentacoes', [
            'foreignKey' => 'tipo_movimentacao_id',
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
            ->dateTime('data_hora')
            ->requirePresence('data_hora', 'create')
            ->notEmptyDateTime('data_hora');

        $validator
            ->decimal('quantidade_movimentada')
            ->requirePresence('quantidade_movimentada', 'create')
            ->notEmptyString('quantidade_movimentada');

        $validator
            ->decimal('m2_movimentada')
            ->requirePresence('m2_movimentada', 'create')
            ->notEmptyString('m2_movimentada');

        $validator
            ->decimal('m3_movimentada')
            ->requirePresence('m3_movimentada', 'create')
            ->notEmptyString('m3_movimentada');

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
        //$rules->add($rules->existsIn(['estoque_id'], 'Estoques'));
        $rules->add($rules->existsIn(['endereco_origem_id'], 'EnderecoOrigem'));
        $rules->add($rules->existsIn(['endereco_destino_id'], 'EnderecoDestino'));
        $rules->add($rules->existsIn(['tipo_movimentacao_id'], 'TipoMovimentacoes'));
        return $rules;
    }

    public function beforeSave($event, $entity, $options)
    {
        if ($entity->container_id) {
            $oEntradaSaidaContainers = EntradaSaidaContainer::getLastByContainerId($entity->container_id, false, false, true);
            $entity->entrada_saida_container_id = @$oEntradaSaidaContainers->id;
        }
    }
}
