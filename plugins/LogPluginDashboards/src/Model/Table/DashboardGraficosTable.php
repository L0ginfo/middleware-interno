<?php
namespace LogPluginDashboards\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DashboardGraficos Model
 *
 * @property \LogPluginDashboards\Model\Table\ConsultasTable&\Cake\ORM\Association\BelongsTo $Consultas
 * @property \LogPluginDashboards\Model\Table\DashboardsTable&\Cake\ORM\Association\BelongsTo $Dashboards
 * @property \LogPluginDashboards\Model\Table\DashboardGraficoTiposTable&\Cake\ORM\Association\BelongsTo $DashboardGraficoTipos
 *
 * @method \LogPluginDashboards\Model\Entity\DashboardGrafico get($primaryKey, $options = [])
 * @method \LogPluginDashboards\Model\Entity\DashboardGrafico newEntity($data = null, array $options = [])
 * @method \LogPluginDashboards\Model\Entity\DashboardGrafico[] newEntities(array $data, array $options = [])
 * @method \LogPluginDashboards\Model\Entity\DashboardGrafico|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \LogPluginDashboards\Model\Entity\DashboardGrafico saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \LogPluginDashboards\Model\Entity\DashboardGrafico patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \LogPluginDashboards\Model\Entity\DashboardGrafico[] patchEntities($entities, array $data, array $options = [])
 * @method \LogPluginDashboards\Model\Entity\DashboardGrafico findOrCreate($search, callable $callback = null, $options = [])
 */
class DashboardGraficosTable extends Table
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
        

        $this->setTable('dashboard_graficos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('Consultas', [
            'foreignKey' => 'consulta_id',
            'className' => 'LogPluginDashboards.Consultas',
        ]);
        $this->belongsTo('Dashboards', [
            'foreignKey' => 'dashboard_id',
            'joinType' => 'INNER',
            'className' => 'LogPluginDashboards.Dashboards',
        ]);
        $this->belongsTo('DashboardGraficoTipos', [
            'foreignKey' => 'dashboard_grafico_tipo_id',
            'joinType' => 'INNER',
            'className' => 'LogPluginDashboards.DashboardGraficoTipos',
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
            ->integer('ordem')
            ->allowEmptyString('ordem');

        $validator
            ->scalar('responsive_options')
            ->maxLength('responsive_options', 999999)
            ->allowEmptyString('responsive_options');

        $validator
            ->scalar('titulo')
            ->maxLength('titulo', 255)
            ->notEmpty('titulo');

        $validator
            ->scalar('descricao')
            ->maxLength('descricao', 255)
            ->notEmpty('descricao');

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
        $rules->add($rules->existsIn(['consulta_id'], 'Consultas'));
        $rules->add($rules->existsIn(['dashboard_id'], 'Dashboards'));
        $rules->add($rules->existsIn(['dashboard_grafico_tipo_id'], 'DashboardGraficoTipos'));

        return $rules;
    }
}
