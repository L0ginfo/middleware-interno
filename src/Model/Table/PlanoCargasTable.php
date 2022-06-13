<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PlanoCargas Model
 *
 * @property \App\Model\Table\PlanejamentoMaritimosTable&\Cake\ORM\Association\BelongsTo $PlanejamentoMaritimos
 * @property \App\Model\Table\UnidadeMedidasTable&\Cake\ORM\Association\BelongsTo $UnidadeMedidas
 * @property \App\Model\Table\SentidosTable&\Cake\ORM\Association\BelongsTo $Sentidos
 * @property \App\Model\Table\PlanoCargaTipoMercadoriasTable&\Cake\ORM\Association\BelongsTo $TipoMercadorias
 * @property \App\Model\Table\PlanoCargaDocumentosTable&\Cake\ORM\Association\HasMany $PlanoCargaDocumentos
 * @property \App\Model\Table\PlanoCargaPoroesTable&\Cake\ORM\Association\HasMany $PlanoCargaPoroes
 *
 * @method \App\Model\Entity\PlanoCarga get($primaryKey, $options = [])
 * @method \App\Model\Entity\PlanoCarga newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PlanoCarga[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PlanoCarga|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PlanoCarga saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PlanoCarga patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PlanoCarga[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PlanoCarga findOrCreate($search, callable $callback = null, $options = [])
 */
class PlanoCargasTable extends Table
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


        $this->setTable('plano_cargas');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('PlanejamentoMaritimos', [
            'foreignKey' => 'planejamento_maritimo_id',
        ]);
        $this->belongsTo('UnidadeMedidas', [
            'foreignKey' => 'unidade_medida_id',
        ]);
        $this->belongsTo('Sentidos', [
            'foreignKey' => 'sentido_id',
        ]);
        $this->belongsTo('PlanoCargaTipoMercadorias', [
            'foreignKey' => 'tipo_mercadoria_id',
        ]);
        $this->hasMany('PlanoCargaDocumentos', [
            'foreignKey' => 'plano_carga_id',
        ]);
        $this->hasMany('PlanoCargaPoroes', [
            'foreignKey' => 'plano_carga_id',
        ]);
        $this->hasMany('planoCargaPackingLists', [
            'foreignKey' => 'plano_carga_id',
        ]);

        $this->hasMany('AssociacaoTernos', [
            'foreignKey' => 'plano_carga_id',
        ]);

        $this->hasMany('PlanoCargaItemDestinos', [
            'foreignKey' => 'plano_carga_id',
        ]);

        $this->hasMany('PlanoCargaCaracteristicas', [
            'foreignKey' => 'plano_carga_id'
        ]);
        
        
        $this->hasMany('Cliente', [
            'className' => 'Empresas',
            'foreignKey' => 'cliente_id',
        ]);


        $this->belongsTo('Clientes', [
            'className' => 'Empresas',
            'foreignKey' => 'cliente_id',
        ]);

        $this->belongsToMany('Poroes', [
            'className'=> 'Poroes',
            'foreignKey' => 'plano_carga_id',
            'targetForeignKey' => 'porao_id',
            'through' => 'plano_carga_poroes'
        ]);  

        $this->hasMany('PlanoCargaPoraoCondicoes', [
            'foreignKey' => 'plano_carga_id',
        ]);

        $this->belongsTo('Produtos', [
            'foreignKey' => 'produto_principal_id',
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
            ->date('emissao')
            ->allowEmptyDate('emissao');

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
        $rules->add($rules->existsIn(['planejamento_maritimo_id'], 'PlanejamentoMaritimos'));
        $rules->add($rules->existsIn(['unidade_medida_id'], 'UnidadeMedidas'));
        $rules->add($rules->existsIn(['sentido_id'], 'Sentidos'));
        $rules->add($rules->existsIn(['tipo_mercadoria_id'], 'PlanoCargaTipoMercadorias'));

        return $rules;
    }
}
