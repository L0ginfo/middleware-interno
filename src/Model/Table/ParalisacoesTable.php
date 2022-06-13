<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Paralisacoes Model
 *
 * @property \App\Model\Table\ParalisacaoMotivosTable&\Cake\ORM\Association\BelongsTo $ParalisacaoMotivos
 * @property \App\Model\Table\PlanejamentoMaritimosTable&\Cake\ORM\Association\BelongsTo $PlanejamentoMaritimos
 * @property \App\Model\Table\PlanoCargasTable&\Cake\ORM\Association\BelongsTo $PlanoCargas
 * @property \App\Model\Table\PlanoCargaPoroesTable&\Cake\ORM\Association\BelongsTo $PlanoCargaPoroes
 * @property \App\Model\Table\PoroesTable&\Cake\ORM\Association\BelongsTo $Poroes
 * @property \App\Model\Table\PlanoCargaTipoMercadoriasTable&\Cake\ORM\Association\BelongsTo $PlanoCargaTipoMercadorias
 *
 * @method \App\Model\Entity\Paralisacao get($primaryKey, $options = [])
 * @method \App\Model\Entity\Paralisacao newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Paralisacao[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Paralisacao|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Paralisacao saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Paralisacao patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Paralisacao[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Paralisacao findOrCreate($search, callable $callback = null, $options = [])
 */
class ParalisacoesTable extends Table
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
        

        $this->setTable('paralisacoes');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('ParalisacaoMotivos', [
            'foreignKey' => 'paralisacao_motivo_id',
            'joinType' => 'INNER',
        ]);

        $this->belongsTo('ParalisacaoResponsaveis', [
            'foreignKey' => 'responsavel_id',
        ]);

        $this->belongsTo('PlanejamentoMaritimos', [
            'foreignKey' => 'planejamento_maritimo_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('PlanoCargas', [
            'foreignKey' => 'plano_carga_id',
        ]);
        $this->belongsTo('PlanoCargaPoroes', [
            'foreignKey' => 'plano_carga_porao_id',
        ]);
        $this->belongsTo('Poroes', [
            'foreignKey' => 'porao_id',
        ]);
        $this->belongsTo('PlanoCargaTipoMercadorias', [
            'foreignKey' => 'plano_carga_tipo_mercadoria_id',
        ]);
        
        $this->belongsTo('Usuarios', [
            'foreignKey' => 'created_by',
        ]);
        $this->belongsTo('Ternos', [
            'foreignKey' => 'terno_id',
        ]);
        $this->belongsTo('PortoTrabalhoPeriodos', [
            'foreignKey' => 'periodo_id',
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
            ->scalar('descricao')
            ->allowEmptyString('descricao');

        $validator
            ->dateTime('data_hora_inicio')
            ->requirePresence('data_hora_inicio', 'create')
            ->notEmptyDateTime('data_hora_inicio');

        $validator
            ->dateTime('data_hora_fim')
            ->allowEmptyDateTime('data_hora_fim');

        $validator
            ->integer('detectada_automaticamente')
            ->notEmptyString('detectada_automaticamente');

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
        $rules->add($rules->existsIn(['paralisacao_motivo_id'], 'ParalisacaoMotivos'));
        $rules->add($rules->existsIn(['planejamento_maritimo_id'], 'PlanejamentoMaritimos'));
        $rules->add($rules->existsIn(['plano_carga_id'], 'PlanoCargas'));
        $rules->add($rules->existsIn(['plano_carga_porao_id'], 'PlanoCargaPoroes'));
        $rules->add($rules->existsIn(['porao_id'], 'Poroes'));
        $rules->add($rules->existsIn(['plano_carga_tipo_mercadoria_id'], 'PlanoCargaTipoMercadorias'));

        return $rules;
    }
}
