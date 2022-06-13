<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OrdemServicoUnitizacoes Model
 *
 * @property \App\Model\Table\OrdemServicosTable&\Cake\ORM\Association\BelongsTo $OrdemServicos
 * @property \App\Model\Table\UnidadeMedidasTable&\Cake\ORM\Association\BelongsTo $UnidadeMedidas
 * @property \App\Model\Table\DocumentosMercadoriasItensTable&\Cake\ORM\Association\BelongsTo $DocumentosMercadoriasItens
 * @property \App\Model\Table\EmbalagensTable&\Cake\ORM\Association\BelongsTo $Embalagens
 * @property \App\Model\Table\ProdutosTable&\Cake\ORM\Association\BelongsTo $Produtos
 * @property \App\Model\Table\EnderecosTable&\Cake\ORM\Association\BelongsTo $Enderecos
 * @property \App\Model\Table\StatusEstoquesTable&\Cake\ORM\Association\BelongsTo $StatusEstoques
 * @property \App\Model\Table\ContainersTable&\Cake\ORM\Association\BelongsTo $Containers
 *
 * @method \App\Model\Entity\OrdemServicoUnitizacao get($primaryKey, $options = [])
 * @method \App\Model\Entity\OrdemServicoUnitizacao newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\OrdemServicoUnitizacao[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\OrdemServicoUnitizacao|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OrdemServicoUnitizacao saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OrdemServicoUnitizacao patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\OrdemServicoUnitizacao[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\OrdemServicoUnitizacao findOrCreate($search, callable $callback = null, $options = [])
 */
class OrdemServicoUnitizacoesTable extends Table
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
        

        $this->setTable('ordem_servico_unitizacoes');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

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
        $this->belongsTo('Containers', [
            'foreignKey' => 'container_id',
        ]);
        $this->belongsTo('EquipesTrabalhos', [
            'foreignKey' => 'equipe_trabalho_id',
        ]);
        $this->belongsTo('PortoTrabalhoPeriodos', [
            'foreignKey' => 'porto_trabalho_periodo_id',
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
            ->scalar('etiqueta')
            ->maxLength('etiqueta', 255)
            ->requirePresence('etiqueta', 'create')
            ->notEmptyString('etiqueta');

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
        $rules->add($rules->existsIn(['ordem_servico_id'], 'OrdemServicos'));
        $rules->add($rules->existsIn(['unidade_medida_id'], 'UnidadeMedidas'));
        $rules->add($rules->existsIn(['documento_mercadoria_item_id'], 'DocumentosMercadoriasItens'));
        $rules->add($rules->existsIn(['embalagem_id'], 'Embalagens'));
        $rules->add($rules->existsIn(['produto_id'], 'Produtos'));
        $rules->add($rules->existsIn(['endereco_id'], 'Enderecos'));
        $rules->add($rules->existsIn(['status_estoque_id'], 'StatusEstoques'));
        $rules->add($rules->existsIn(['container_id'], 'Containers'));
        $rules->add($rules->existsIn(['equipe_trabalho_id'], 'EquipesTrabalhos'));
        $rules->add($rules->existsIn(['porto_trabalho_periodo_id'], 'PortoTrabalhoPeriodos'));

        return $rules;
    }
}
