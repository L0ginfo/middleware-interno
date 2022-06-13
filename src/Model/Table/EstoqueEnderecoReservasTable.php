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
 * EstoqueEnderecoReservas Model
 *
 * @property \App\Model\Table\UnidadeMedidasTable&\Cake\ORM\Association\BelongsTo $UnidadeMedidas
 * @property \App\Model\Table\EnderecosTable&\Cake\ORM\Association\BelongsTo $Enderecos
 * @property \App\Model\Table\EstoquesTable&\Cake\ORM\Association\BelongsTo $Estoques
 * @property \App\Model\Table\EmpresasTable&\Cake\ORM\Association\BelongsTo $Empresas
 * @property \App\Model\Table\ProdutosTable&\Cake\ORM\Association\BelongsTo $Produtos
 * @property \App\Model\Table\OrdemServicosTable&\Cake\ORM\Association\BelongsTo $OrdemServicos
 * @property \App\Model\Table\EstoqueEnderecosTable&\Cake\ORM\Association\BelongsTo $EstoqueEnderecos
 *
 * @method \App\Model\Entity\EstoqueEnderecoReserva get($primaryKey, $options = [])
 * @method \App\Model\Entity\EstoqueEnderecoReserva newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\EstoqueEnderecoReserva[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EstoqueEnderecoReserva|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EstoqueEnderecoReserva saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EstoqueEnderecoReserva patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\EstoqueEnderecoReserva[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\EstoqueEnderecoReserva findOrCreate($search, callable $callback = null, $options = [])
 */
class EstoqueEnderecoReservasTable extends Table
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
        

        $this->setTable('estoque_endereco_reservas');
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
        $this->belongsTo('EstoqueEnderecos', [
            'foreignKey' => 'estoque_endereco_id',
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
        $rules->add($rules->existsIn(['unidade_medida_id'], 'UnidadeMedidas'));
        $rules->add($rules->existsIn(['endereco_id'], 'Enderecos'));
        $rules->add($rules->existsIn(['estoque_id'], 'Estoques'));
        $rules->add($rules->existsIn(['empresa_id'], 'Empresas'));
        $rules->add($rules->existsIn(['produto_id'], 'Produtos'));
        $rules->add($rules->existsIn(['ordem_servico_id'], 'OrdemServicos'));
        $rules->add($rules->existsIn(['estoque_endereco_id'], 'EstoqueEnderecos'));

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
