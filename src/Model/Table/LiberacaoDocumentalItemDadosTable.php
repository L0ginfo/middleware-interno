<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LiberacaoDocumentalItemDados Model
 *
 * @property \App\Model\Table\LiberacaoDocumentaisTable&\Cake\ORM\Association\BelongsTo $LiberacaoDocumentais
 * @property \App\Model\Table\RegimeAduaneirosTable&\Cake\ORM\Association\BelongsTo $RegimeAduaneiros
 * @property \App\Model\Table\EstoquesTable&\Cake\ORM\Association\BelongsTo $Estoques
 * @property \App\Model\Table\TabelaPrecosTable&\Cake\ORM\Association\BelongsTo $TabelaPrecos
 * @property \App\Model\Table\UnidadeMedidasTable&\Cake\ORM\Association\BelongsTo $UnidadeMedidas
 * @property \App\Model\Table\EnderecosTable&\Cake\ORM\Association\BelongsTo $Enderecos
 * @property \App\Model\Table\EmpresasTable&\Cake\ORM\Association\BelongsTo $Empresas
 * @property \App\Model\Table\ProdutosTable&\Cake\ORM\Association\BelongsTo $Produtos
 * @property \App\Model\Table\ContainersTable&\Cake\ORM\Association\BelongsTo $Containers
 * @property \App\Model\Table\EntradaSaidaContainersTable&\Cake\ORM\Association\BelongsTo $EntradaSaidaContainers
 * @property \App\Model\Table\ProcedenciasTable&\Cake\ORM\Association\BelongsTo $Procedencias
 *
 * @method \App\Model\Entity\LiberacaoDocumentalItemDado get($primaryKey, $options = [])
 * @method \App\Model\Entity\LiberacaoDocumentalItemDado newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\LiberacaoDocumentalItemDado[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\LiberacaoDocumentalItemDado|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LiberacaoDocumentalItemDado saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LiberacaoDocumentalItemDado patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\LiberacaoDocumentalItemDado[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\LiberacaoDocumentalItemDado findOrCreate($search, callable $callback = null, $options = [])
 */
class LiberacaoDocumentalItemDadosTable extends Table
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
        

        $this->setTable('liberacao_documental_item_dados');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('LiberacoesDocumentais', [
            'foreignKey' => 'liberacao_documental_id',
            'joinType' => 'INNER',
        ]);
        // $this->belongsTo('RegimeAduaneiros', [
        //     'foreignKey' => 'regime_aduaneiro_id',
        // ]);
        $this->belongsTo('Estoques', [
            'foreignKey' => 'estoque_id',
            'joinType' => 'INNER',
        ]);
        // $this->belongsTo('TabelaPrecos', [
        //     'foreignKey' => 'tabela_preco_id',
        // ]);
        $this->belongsTo('UnidadeMedidas', [
            'foreignKey' => 'unidade_medida_id',
        ]);
        $this->belongsTo('Enderecos', [
            'foreignKey' => 'endereco_id',
        ]);
        $this->belongsTo('Empresas', [
            'foreignKey' => 'empresa_id',
        ]);
        $this->belongsTo('Produtos', [
            'foreignKey' => 'produto_id',
        ]);
        $this->belongsTo('Containers', [
            'foreignKey' => 'container_id',
        ]);
        $this->belongsTo('EntradaSaidaContainers', [
            'foreignKey' => 'entrada_saida_container_id',
        ]);
        $this->belongsTo('Procedencias', [
            'foreignKey' => 'porto_destino_id',
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
    // public function validationDefault(Validator $validator)
    // {
        // $validator
        //     ->integer('id')
        //     ->allowEmptyString('id', null, 'create');

        // $validator
        //     ->integer('adicao_numero')
        //     ->requirePresence('adicao_numero', 'create')
        //     ->notEmptyString('adicao_numero');

        // $validator
        //     ->decimal('quantidade_liberada')
        //     ->requirePresence('quantidade_liberada', 'create')
        //     ->notEmptyString('quantidade_liberada');

        // $validator
        //     ->scalar('lote_codigo')
        //     ->maxLength('lote_codigo', 15)
        //     ->allowEmptyString('lote_codigo');

        // $validator
        //     ->scalar('lote_item')
        //     ->maxLength('lote_item', 15)
        //     ->allowEmptyString('lote_item');

        // $validator
        //     ->decimal('qtde_saldo')
        //     ->allowEmptyString('qtde_saldo');

        // $validator
        //     ->decimal('peso_saldo')
        //     ->allowEmptyString('peso_saldo');

        // $validator
        //     ->decimal('m2_saldo')
        //     ->allowEmptyString('m2_saldo');

        // $validator
        //     ->decimal('m3_saldo')
        //     ->allowEmptyString('m3_saldo');

        // $validator
        //     ->scalar('lote')
        //     ->maxLength('lote', 255)
        //     ->allowEmptyString('lote');

        // $validator
        //     ->scalar('serie')
        //     ->maxLength('serie', 255)
        //     ->allowEmptyString('serie');

        // $validator
        //     ->dateTime('validade')
        //     ->allowEmptyDateTime('validade');

        // $validator
        //     ->integer('liberacao_por_produto')
        //     ->allowEmptyString('liberacao_por_produto');

        // $validator
        //     ->dateTime('created_at')
        //     ->notEmptyDateTime('created_at');

        // $validator
        //     ->dateTime('updated_at')
        //     ->allowEmptyDateTime('updated_at');

        // $validator
        //     ->scalar('dado_lote')
        //     ->maxLength('dado_lote', 255)
        //     ->allowEmptyString('dado_lote');

        // return $validator;
    // }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    // public function buildRules(RulesChecker $rules)
    // {
        // $rules->add($rules->existsIn(['liberacao_documental_id'], 'LiberacaoDocumentais'));
        // $rules->add($rules->existsIn(['regime_aduaneiro_id'], 'RegimeAduaneiros'));
        // $rules->add($rules->existsIn(['estoque_id'], 'Estoques'));
        // $rules->add($rules->existsIn(['tabela_preco_id'], 'TabelaPrecos'));
        // $rules->add($rules->existsIn(['unidade_medida_id'], 'UnidadeMedidas'));
        // $rules->add($rules->existsIn(['endereco_id'], 'Enderecos'));
        // $rules->add($rules->existsIn(['empresa_id'], 'Empresas'));
        // $rules->add($rules->existsIn(['produto_id'], 'Produtos'));
        // $rules->add($rules->existsIn(['container_id'], 'Containers'));
        // $rules->add($rules->existsIn(['entrada_saida_container_id'], 'EntradaSaidaContainers'));
        // $rules->add($rules->existsIn(['porto_destino_id'], 'Procedencias'));

        // return $rules;
    // }
}
