<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * FormacaoCargas Model
 *
 * @property \App\Model\Table\TransportadorasTable&\Cake\ORM\Association\BelongsTo $Transportadoras
 * @property \App\Model\Table\VeiculosTable&\Cake\ORM\Association\BelongsTo $Veiculos
 * @property \App\Model\Table\FormacaoCargaVeiculosTable&\Cake\ORM\Association\HasMany $FormacaoCargaVeiculos
 * @property \App\Model\Table\FormacaoCargaVolumeItensTable&\Cake\ORM\Association\HasMany $FormacaoCargaVolumeItens
 * @property \App\Model\Table\FormacaoCargaVolumesTable&\Cake\ORM\Association\HasMany $FormacaoCargaVolumes
 *
 * @method \App\Model\Entity\FormacaoCarga get($primaryKey, $options = [])
 * @method \App\Model\Entity\FormacaoCarga newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\FormacaoCarga[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\FormacaoCarga|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FormacaoCarga saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FormacaoCarga patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\FormacaoCarga[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\FormacaoCarga findOrCreate($search, callable $callback = null, $options = [])
 */
class FormacaoCargasTable extends Table
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
        

        $this->setTable('formacao_cargas');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('Transportadoras', [
            'foreignKey' => 'transportadora_id',
        ]);
        $this->belongsTo('Veiculos', [
            'foreignKey' => 'veiculo_id',
        ]);
        $this->belongsTo('FormacaoCargaSituacoes', [
            'foreignKey' => 'formacao_carga_situacao_id',
        ]);
        $this->belongsTo('FormacaoCargaEspecies', [
            'foreignKey' => 'formacao_carga_especie_id',
        ]);
        $this->hasMany('FormacaoCargaNfPedidos', [
            'foreignKey' => 'formacao_carga_id',
        ]);
        $this->hasMany('FormacaoCargaNfPedidosInner', [
            'className' => 'FormacaoCargaNfPedidos',
            'propertyName' => 'formacao_carga_nf_pedidos',
            'foreignKey' => 'formacao_carga_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('FormacaoCargaVeiculos', [
            'foreignKey' => 'formacao_carga_id',
        ]);
        $this->hasMany('FormacaoCargaNfPedidos', [
            'foreignKey' => 'formacao_carga_id',
            'dependent' => true,
            'cascadeCallbacks' => true
        ]); 
        $this->hasMany('FormacaoCargaVolumeItens', [
            'foreignKey' => 'formacao_carga_id',
        ]);
        $this->hasMany('FormacaoCargaVolumes', [
            'foreignKey' => 'formacao_carga_id',
            'dependent' => true,
            'cascadeCallbacks' => true
        ]);
        $this->hasMany('FormacaoCargaVolumesInner', [
            'foreignKey' => 'formacao_carga_id',
            'className' => 'FormacaoCargaVolumes',
            'propertyName' => 'formacao_carga_volumes',
            'joinType' => 'INNER',
            'dependent' => true,
            'cascadeCallbacks' => true
        ])->setConditions(['enviado_integracao' => 0]);
        $this->hasMany('FormacaoCargaNfPedidos', [
            'foreignKey' => 'formacao_carga_id',
            'dependent' => true,
            'cascadeCallbacks' => true
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
            ->integer('codigo')
            ->allowEmptyString('codigo');

        $validator
            ->integer('is_criado_resv')
            ->notEmptyString('is_criado_resv');

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
        $rules->add($rules->existsIn(['transportadora_id'], 'Transportadoras'));
        $rules->add($rules->existsIn(['veiculo_id'], 'Veiculos'));

        return $rules;
    }
}
