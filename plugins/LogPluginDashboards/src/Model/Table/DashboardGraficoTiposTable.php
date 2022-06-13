<?php
namespace LogPluginDashboards\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DashboardGraficoTipos Model
 *
 * @property \LogPluginDashboards\Model\Table\DashboardGraficoFormatosTable&\Cake\ORM\Association\BelongsTo $DashboardGraficoFormatos
 * @property \LogPluginDashboards\Model\Table\DashboardGraficosTable&\Cake\ORM\Association\HasMany $DashboardGraficos
 *
 * @method \LogPluginDashboards\Model\Entity\DashboardGraficoTipo get($primaryKey, $options = [])
 * @method \LogPluginDashboards\Model\Entity\DashboardGraficoTipo newEntity($data = null, array $options = [])
 * @method \LogPluginDashboards\Model\Entity\DashboardGraficoTipo[] newEntities(array $data, array $options = [])
 * @method \LogPluginDashboards\Model\Entity\DashboardGraficoTipo|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \LogPluginDashboards\Model\Entity\DashboardGraficoTipo saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \LogPluginDashboards\Model\Entity\DashboardGraficoTipo patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \LogPluginDashboards\Model\Entity\DashboardGraficoTipo[] patchEntities($entities, array $data, array $options = [])
 * @method \LogPluginDashboards\Model\Entity\DashboardGraficoTipo findOrCreate($search, callable $callback = null, $options = [])
 */
class DashboardGraficoTiposTable extends Table
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
        

        $this->setTable('dashboard_grafico_tipos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('DashboardGraficoFormatos', [
            'foreignKey' => 'dashboard_grafico_formato_id',
            'joinType' => 'INNER',
            'className' => 'LogPluginDashboards.DashboardGraficoFormatos',
        ]);
        $this->hasMany('DashboardGraficos', [
            'foreignKey' => 'dashboard_grafico_tipo_id',
            'className' => 'LogPluginDashboards.DashboardGraficos',
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
            ->maxLength('descricao', 999999)
            ->requirePresence('descricao', 'create')
            ->notEmptyString('descricao');

        $validator
            ->scalar('grafico_params')
            ->maxLength('grafico_params', 999999)
            ->allowEmptyString('grafico_params');

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
        $rules->add($rules->existsIn(['dashboard_grafico_formato_id'], 'DashboardGraficoFormatos'));

        return $rules;
    }
}
