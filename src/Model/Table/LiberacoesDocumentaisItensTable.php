<?php
namespace App\Model\Table;

use App\Model\Entity\EntradaSaidaContainer;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LiberacoesDocumentaisItens Model
 *
 * @property \App\Model\Table\LiberacoesDocumentaisTable&\Cake\ORM\Association\BelongsTo $LiberacoesDocumentais
 * @property \App\Model\Table\RegimesAduaneirosTable&\Cake\ORM\Association\BelongsTo $RegimesAduaneiros
 * @property \App\Model\Table\EstoquesTable&\Cake\ORM\Association\BelongsTo $Estoques
 * @property \App\Model\Table\TabelasPrecosTable&\Cake\ORM\Association\BelongsTo $TabelasPrecos
 * @property &\Cake\ORM\Association\BelongsTo $UnidadeMedidas
 * @property &\Cake\ORM\Association\BelongsTo $Enderecos
 * @property &\Cake\ORM\Association\BelongsTo $Empresas
 * @property &\Cake\ORM\Association\BelongsTo $Produtos
 * @property &\Cake\ORM\Association\BelongsTo $OrdemServicos
 *
 * @method \App\Model\Entity\LiberacoesDocumentaisItem get($primaryKey, $options = [])
 * @method \App\Model\Entity\LiberacoesDocumentaisItem newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\LiberacoesDocumentaisItem[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\LiberacoesDocumentaisItem|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LiberacoesDocumentaisItem saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LiberacoesDocumentaisItem patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\LiberacoesDocumentaisItem[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\LiberacoesDocumentaisItem findOrCreate($search, callable $callback = null, $options = [])
 */
class LiberacoesDocumentaisItensTable extends Table
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
        

        $this->setTable('liberacoes_documentais_itens');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('LiberacoesDocumentais', [
            'foreignKey' => 'liberacao_documental_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('RegimesAduaneiros', [
            'foreignKey' => 'regime_aduaneiro_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Estoques', [
            'foreignKey' => 'estoque_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('EstoquesLeft', [
            'foreignKey' => 'estoque_id',
            'joinType' => 'LEFT',
            'propertyName' => 'estoque',
            'className' => 'Estoques',
        ]);
        $this->belongsTo('TabelasPrecos', [
            'foreignKey' => 'tabela_preco_id',
        ]);
        $this->belongsTo('UnidadeMedidas', [
            'foreignKey' => 'unidade_medida_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Enderecos', [
            'foreignKey' => 'endereco_id',
        ]);
        $this->belongsTo('Empresas', [
            'foreignKey' => 'empresa_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Produtos', [
            'foreignKey' => 'produto_id',
            'joinType' => 'LEFT'
        ]);
        $this->belongsTo('OrdemServicos', [
            'foreignKey' => 'ordem_servico_id',
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
        $this->belongsTo('EstoquesInnerByLote', [
            'className'=>'Estoques',
            'joinType' => 'INNER',
            'propertyName' => 'estoque',
            'foreignKey' => 'unidade_medida_id',
            'bindingKey' => 'unidade_medida_id',
        ])
        ->setConditions([
            //lote_codigo
            '((EstoquesInnerByLote.lote_codigo IS NULL AND LiberacoesDocumentaisItens.lote_codigo IS NULL) 
                OR 
              (EstoquesInnerByLote.lote_codigo = LiberacoesDocumentaisItens.lote_codigo))',
            //lote_item
            '((EstoquesInnerByLote.lote_item IS NULL AND LiberacoesDocumentaisItens.lote_item IS NULL) 
                OR 
              (EstoquesInnerByLote.lote_item = LiberacoesDocumentaisItens.lote_item))',
            //produto_id
            '((EstoquesInnerByLote.produto_id IS NULL AND LiberacoesDocumentaisItens.produto_id IS NULL) 
                OR 
              (EstoquesInnerByLote.produto_id = LiberacoesDocumentaisItens.produto_id))',
            //unidade_medida_id
            '((EstoquesInnerByLote.unidade_medida_id IS NULL AND LiberacoesDocumentaisItens.unidade_medida_id IS NULL) 
              OR 
              (EstoquesInnerByLote.unidade_medida_id = LiberacoesDocumentaisItens.unidade_medida_id))',
            //container_id
            '((EstoquesInnerByLote.container_id IS NULL AND LiberacoesDocumentaisItens.container_id IS NULL) 
              OR 
              (EstoquesInnerByLote.container_id = LiberacoesDocumentaisItens.container_id))',
            //lote
            '((EstoquesInnerByLote.lote IS NULL AND LiberacoesDocumentaisItens.lote IS NULL) 
              OR 
              (EstoquesInnerByLote.lote = LiberacoesDocumentaisItens.lote))',
            //serie
            '((EstoquesInnerByLote.serie IS NULL AND LiberacoesDocumentaisItens.serie IS NULL) 
              OR 
              (EstoquesInnerByLote.serie = LiberacoesDocumentaisItens.serie))',
            //validade
            '((EstoquesInnerByLote.validade IS NULL AND LiberacoesDocumentaisItens.validade IS NULL) 
              OR 
              (EstoquesInnerByLote.validade = LiberacoesDocumentaisItens.validade))',
        ]);
        $this->belongsTo('EstoqueEnderecosLeftByLote', [
            'className'=>'EstoqueEnderecos',
            'joinType' => 'LEFT',
            'propertyName' => 'estoque_endereco',
            'foreignKey' => 'unidade_medida_id',
            'bindingKey' => 'unidade_medida_id',
        ])
        ->setConditions([
            //lote_codigo
            '((EstoqueEnderecosLeftByLote.lote_codigo IS NULL AND LiberacoesDocumentaisItensLeft.lote_codigo IS NULL) 
                OR 
              (EstoqueEnderecosLeftByLote.lote_codigo = LiberacoesDocumentaisItensLeft.lote_codigo))',
            //lote_item
            '((EstoqueEnderecosLeftByLote.lote_item IS NULL AND LiberacoesDocumentaisItensLeft.lote_item IS NULL) 
                OR 
              (EstoqueEnderecosLeftByLote.lote_item = LiberacoesDocumentaisItensLeft.lote_item))',
            //produto_id
            '((EstoqueEnderecosLeftByLote.produto_id IS NULL AND LiberacoesDocumentaisItensLeft.produto_id IS NULL) 
                OR 
              (EstoqueEnderecosLeftByLote.produto_id = LiberacoesDocumentaisItensLeft.produto_id))',
            //unidade_medida_id
            '((EstoqueEnderecosLeftByLote.unidade_medida_id IS NULL AND LiberacoesDocumentaisItensLeft.unidade_medida_id IS NULL) 
              OR 
              (EstoqueEnderecosLeftByLote.unidade_medida_id = LiberacoesDocumentaisItensLeft.unidade_medida_id))',
            //container_id
            '((EstoqueEnderecosLeftByLote.container_id IS NULL AND LiberacoesDocumentaisItensLeft.container_id IS NULL) 
              OR 
              (EstoqueEnderecosLeftByLote.container_id = LiberacoesDocumentaisItensLeft.container_id))',
            //lote
            '((EstoqueEnderecosLeftByLote.lote IS NULL AND LiberacoesDocumentaisItensLeft.lote IS NULL) 
              OR 
              (EstoqueEnderecosLeftByLote.lote = LiberacoesDocumentaisItensLeft.lote))',
            //serie
            '((EstoqueEnderecosLeftByLote.serie IS NULL AND LiberacoesDocumentaisItensLeft.serie IS NULL) 
              OR 
              (EstoqueEnderecosLeftByLote.serie = LiberacoesDocumentaisItensLeft.serie))',
            //validade
            '((EstoqueEnderecosLeftByLote.validade IS NULL AND LiberacoesDocumentaisItensLeft.validade IS NULL) 
              OR 
              (EstoqueEnderecosLeftByLote.validade = LiberacoesDocumentaisItensLeft.validade))',
        ]);
        $this->belongsTo('Containers', [
            'foreignKey' => 'container_id',
            'joinType' => 'LEFT'
        ]);

        $this->hasMany('LiberacaoDocumentalTransportadoraItens',[
            'foreignKey' => 'liberacao_documental_item_id',
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
            ->integer('adicao_numero')
            ->requirePresence('adicao_numero', 'create')
            ->notEmptyString('adicao_numero');

        $validator
            ->decimal('quantidade_liberada')
            ->requirePresence('quantidade_liberada', 'create')
            ->notEmptyString('quantidade_liberada');

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
            ->allowEmptyString('peso_saldo');

        $validator
            ->decimal('m2_saldo')
            ->allowEmptyString('m2_saldo');

        $validator
            ->decimal('m3_saldo')
            ->allowEmptyString('m3_saldo');

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
        $rules->add($rules->existsIn(['liberacao_documental_id'], 'LiberacoesDocumentais'));
        $rules->add($rules->existsIn(['regime_aduaneiro_id'], 'RegimesAduaneiros'));
        $rules->add($rules->existsIn(['tabela_preco_id'], 'TabelasPrecos'));
        $rules->add($rules->existsIn(['unidade_medida_id'], 'UnidadeMedidas'));
        $rules->add($rules->existsIn(['endereco_id'], 'Enderecos'));
        $rules->add($rules->existsIn(['empresa_id'], 'Empresas'));
        $rules->add($rules->existsIn(['produto_id'], 'Produtos'));
        $rules->add($rules->existsIn(['ordem_servico_id'], 'OrdemServicos'));

        return $rules;
    }

    public function beforeSave($event, $entity, $options)
    {
        if ($entity->container_id) {
            $oEntradaSaidaContainers = EntradaSaidaContainer::getLastByContainerId($entity->container_id);
            $entity->entrada_saida_container_id = @$oEntradaSaidaContainers->id;
        }
    }
}
