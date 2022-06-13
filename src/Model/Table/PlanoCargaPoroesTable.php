<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PlanoCargaPoroes Model
 *
 * @property \App\Model\Table\PlanoCargasTable&\Cake\ORM\Association\BelongsTo $PlanoCargas
 * @property \App\Model\Table\PoroesTable&\Cake\ORM\Association\BelongsTo $Poroes
 * @property \App\Model\Table\DocumentosMercadoriasItensTable&\Cake\ORM\Association\BelongsTo $DocumentosMercadoriasItens
 *
 * @method \App\Model\Entity\PlanoCargaPorao get($primaryKey, $options = [])
 * @method \App\Model\Entity\PlanoCargaPorao newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PlanoCargaPorao[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PlanoCargaPorao|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PlanoCargaPorao saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PlanoCargaPorao patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PlanoCargaPorao[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PlanoCargaPorao findOrCreate($search, callable $callback = null, $options = [])
 */
class PlanoCargaPoroesTable extends Table
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

        $this->setTable('plano_carga_poroes');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('PlanoCargas', [
            'foreignKey' => 'plano_carga_id',
        ]);

        $this->belongsTo('Produtos', [
            'foreignKey' => 'produto_id',
        ]);

        $this->belongsTo('Empresas', [
            'foreignKey' => 'cliente_id'
        ]);

        $this->belongsTo('OperadorPortuarios', [
            'className' => 'Empresas',
            'foreignKey' => 'operador_id'
        ]);

        $this->belongsTo('PlanoCargaPoraoCondicoes', [
            'foreignKey' => 'plano_carga_id',
            'bindingKey' => 'plano_carga_id',
            'conditions' => [
                'PlanoCargaPoroes.plano_carga_id = PlanoCargaPoraoCondicoes.plano_carga_id',
                'PlanoCargaPoroes.porao_id = PlanoCargaPoraoCondicoes.porao_id'
            ]
        ]);
        
        $this->belongsTo('Poroes', [
            'foreignKey' => 'porao_id',
        ]);
        $this->belongsTo('DocumentosMercadoriasItens', [
            'foreignKey' => 'documento_mercadoria_item_id',
        ]);

        $this->belongsTo('PlanoCargaPackingLists', [
            'foreignKey' => 'plano_carga_packing_list_id',
        ]);

        $this->belongsTo('Ternos', [
            'foreignKey' => 'terno_id',
        ]);

        $this->belongsTo('PortoDestinos', [
            'className' => 'Procedencias',
            'foreignKey' => 'porto_destino_id',
        ]);

        $this->hasMany('OrdemServicoItemLingadas', [
            'foreignKey' => 'plano_carga_porao_id',
        ]);

        $this->hasMany('PlanoCargaPoraoCaracteristicas', [
            'foreignKey' => 'plano_carga_porao_id',
        ]);

        $this->hasMany('LingadaRemocoes', [
            'foreignKey' => 'plano_carga_porao_id',
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
            ->scalar('qtde_prevista')
            ->maxLength('qtde_prevista', 45)
            ->allowEmptyString('qtde_prevista');

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
        $rules->add($rules->existsIn(['plano_carga_id'], 'PlanoCargas'));
        $rules->add($rules->existsIn(['porao_id'], 'Poroes'));
        $rules->add($rules->existsIn(['documento_mercadoria_item_id'], 'DocumentosMercadoriasItens'));
        $rules->add($rules->existsIn(['plano_carga_packing_list_id'], 'PlanoCargaPackingLists'));
        $rules->add($rules->existsIn(['terno_id'], 'Ternos'));

        return $rules;
    }
}
