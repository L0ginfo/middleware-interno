<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PlanoCargaPoraoCaracteristicas Model
 *
 * @property \App\Model\Table\PlanoCargasTable&\Cake\ORM\Association\BelongsTo $PlanoCargas
 * @property \App\Model\Table\PlanoCargaPoroesTable&\Cake\ORM\Association\BelongsTo $PlanoCargaPoroes
 * @property \App\Model\Table\TipoCaracteristicasTable&\Cake\ORM\Association\BelongsTo $TipoCaracteristicas
 * @property \App\Model\Table\PlanoCargaCaracteristicasTable&\Cake\ORM\Association\BelongsTo $PlanoCargaCaracteristicas
 *
 * @method \App\Model\Entity\PlanoCargaPoraoCaracteristica get($primaryKey, $options = [])
 * @method \App\Model\Entity\PlanoCargaPoraoCaracteristica newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PlanoCargaPoraoCaracteristica[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PlanoCargaPoraoCaracteristica|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PlanoCargaPoraoCaracteristica saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PlanoCargaPoraoCaracteristica patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PlanoCargaPoraoCaracteristica[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PlanoCargaPoraoCaracteristica findOrCreate($search, callable $callback = null, $options = [])
 */
class PlanoCargaPoraoCaracteristicasTable extends Table
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
        

        $this->setTable('plano_carga_porao_caracteristicas');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('PlanoCargas', [
            'foreignKey' => 'plano_carga_id',
        ]);
        $this->belongsTo('PlanoCargaPoroes', [
            'foreignKey' => 'plano_carga_porao_id',
        ]);
        $this->belongsTo('TipoCaracteristicas', [
            'foreignKey' => 'tipo_caracteristica_id',
        ]);
        $this->belongsTo('PlanoCargaCaracteristicas', [
            'foreignKey' => 'plano_carga_caracteristica_id',
        ]);

        $this->belongsTo('Caracteristicas', [
            'foreignKey' => 'caracteristica_id',
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
        $rules->add($rules->existsIn(['plano_carga_porao_id'], 'PlanoCargaPoroes'));
        $rules->add($rules->existsIn(['tipo_caracteristica_id'], 'TipoCaracteristicas'));
        $rules->add($rules->existsIn(['plano_carga_caracteristica_id'], 'PlanoCargaCaracteristicas'));

        return $rules;
    }
}
