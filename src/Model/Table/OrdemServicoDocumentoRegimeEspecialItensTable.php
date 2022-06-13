<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OrdemServicoDocumentoRegimeEspecialItens Model
 *
 * @property \App\Model\Table\OrdemServicosTable&\Cake\ORM\Association\BelongsTo $OrdemServicos
 * @property \App\Model\Table\DocumentoRegimeEspecialAdicaoItensTable&\Cake\ORM\Association\BelongsTo $DocumentoRegimeEspecialAdicaoItens
 * @property \App\Model\Table\UnidadeMedidasTable&\Cake\ORM\Association\BelongsTo $UnidadeMedidas
 * @property \App\Model\Table\EmbalagensTable&\Cake\ORM\Association\BelongsTo $Embalagens
 * @property \App\Model\Table\ProdutosTable&\Cake\ORM\Association\BelongsTo $Produtos
 * @property \App\Model\Table\EnderecosTable&\Cake\ORM\Association\BelongsTo $Enderecos
 * @property \App\Model\Table\StatusEstoquesTable&\Cake\ORM\Association\BelongsTo $StatusEstoques
 * @property \App\Model\Table\ContainersTable&\Cake\ORM\Association\BelongsTo $Containers
 * @property \App\Model\Table\EntradaSaidaContainersTable&\Cake\ORM\Association\BelongsTo $EntradaSaidaContainers
 * @property \App\Model\Table\ControleEspecificosTable&\Cake\ORM\Association\BelongsTo $ControleEspecificos
 *
 * @method \App\Model\Entity\OrdemServicoDocumentoRegimeEspecialItem get($primaryKey, $options = [])
 * @method \App\Model\Entity\OrdemServicoDocumentoRegimeEspecialItem newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\OrdemServicoDocumentoRegimeEspecialItem[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\OrdemServicoDocumentoRegimeEspecialItem|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OrdemServicoDocumentoRegimeEspecialItem saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OrdemServicoDocumentoRegimeEspecialItem patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\OrdemServicoDocumentoRegimeEspecialItem[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\OrdemServicoDocumentoRegimeEspecialItem findOrCreate($search, callable $callback = null, $options = [])
 */
class OrdemServicoDocumentoRegimeEspecialItensTable extends Table
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
        

        $this->setTable('ordem_servico_documento_regime_especial_itens');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('OrdemServicos', [
            'foreignKey' => 'ordem_servico_id',
            'joinType' => 'INNER',
        ]);

        $this->belongsTo('OrdemServicoDocumentoRegimeEspeciais', [
            'foreignKey' => 'ordem_servico_documento_regime_especial_id',
        ]);

        $this->belongsTo('DocumentoRegimeEspecialAdicaoItens', [
            'foreignKey' => 'documento_regime_especial_adicao_item_id',
        ]);
        $this->belongsTo('UnidadeMedidas', [
            'foreignKey' => 'unidade_medida_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Embalagens', [
            'foreignKey' => 'embalagem_id',
        ]);
        $this->belongsTo('Produtos', [
            'foreignKey' => 'produto_id',
        ]);
        $this->belongsTo('Enderecos', [
            'foreignKey' => 'endereco_id',
            'joinType' => 'LEFT',
        ]);
        $this->belongsTo('StatusEstoques', [
            'foreignKey' => 'status_estoque_id',
        ]);
        $this->belongsTo('Containers', [
            'foreignKey' => 'container_id',
        ]);
        $this->belongsTo('EntradaSaidaContainers', [
            'foreignKey' => 'entrada_saida_container_id',
        ]);
        $this->belongsTo('ControleEspecificos', [
            'foreignKey' => 'controle_especifico_id',
        ]);

        $this->belongsTo('LeftOrdemServicos', [
            'className' => 'OrdemServicos',
            'propertyName' => 'ordem_servico',
            'foreignKey' => 'ordem_servico_id',
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
            ->requirePresence('sequencia_item', 'create')
            ->notEmptyString('sequencia_item');

        $validator
            ->decimal('quantidade')
            ->requirePresence('quantidade', 'create')
            ->notEmptyString('quantidade');

        $validator
            ->decimal('peso')
            ->requirePresence('peso', 'create')
            ->notEmptyString('peso');

        $validator
            ->decimal('temperatura')
            ->allowEmptyString('temperatura');

        $validator
            ->decimal('m2')
            ->requirePresence('m2', 'create')
            ->notEmptyString('m2');

        $validator
            ->decimal('m3')
            ->requirePresence('m3', 'create')
            ->notEmptyString('m3');

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
        $rules->add($rules->existsIn(['ordem_servico_id'], 'OrdemServicos'));
        $rules->add($rules->existsIn(['ordem_servico_documento_regime_especial_id'], 'OrdemServicoDocumentoRegimeEspeciais'));
        $rules->add($rules->existsIn(['documento_regime_especial_adicao_item_id'], 'DocumentoRegimeEspecialAdicaoItens'));
        $rules->add($rules->existsIn(['unidade_medida_id'], 'UnidadeMedidas'));
        $rules->add($rules->existsIn(['embalagem_id'], 'Embalagens'));
        $rules->add($rules->existsIn(['produto_id'], 'Produtos'));
        $rules->add($rules->existsIn(['endereco_id'], 'Enderecos'));
        $rules->add($rules->existsIn(['status_estoque_id'], 'StatusEstoques'));
        $rules->add($rules->existsIn(['container_id'], 'Containers'));
        $rules->add($rules->existsIn(['entrada_saida_container_id'], 'EntradaSaidaContainers'));
        $rules->add($rules->existsIn(['controle_especifico_id'], 'ControleEspecificos'));

        return $rules;
    }
}
