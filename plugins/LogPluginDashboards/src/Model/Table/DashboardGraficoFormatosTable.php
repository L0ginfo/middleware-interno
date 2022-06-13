<?php
namespace LogPluginDashboards\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DashboardGraficoFormatos Model
 *
 * @property \LogPluginDashboards\Model\Table\DashboardGraficoTiposTable&\Cake\ORM\Association\HasMany $DashboardGraficoTipos
 *
 * @method \LogPluginDashboards\Model\Entity\DashboardGraficoFormato get($primaryKey, $options = [])
 * @method \LogPluginDashboards\Model\Entity\DashboardGraficoFormato newEntity($data = null, array $options = [])
 * @method \LogPluginDashboards\Model\Entity\DashboardGraficoFormato[] newEntities(array $data, array $options = [])
 * @method \LogPluginDashboards\Model\Entity\DashboardGraficoFormato|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \LogPluginDashboards\Model\Entity\DashboardGraficoFormato saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \LogPluginDashboards\Model\Entity\DashboardGraficoFormato patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \LogPluginDashboards\Model\Entity\DashboardGraficoFormato[] patchEntities($entities, array $data, array $options = [])
 * @method \LogPluginDashboards\Model\Entity\DashboardGraficoFormato findOrCreate($search, callable $callback = null, $options = [])
 */
class DashboardGraficoFormatosTable extends Table
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
        

        $this->setTable('dashboard_grafico_formatos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->hasMany('DashboardGraficoTipos', [
            'foreignKey' => 'dashboard_grafico_formato_id',
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
            ->scalar('descricao')
            ->maxLength('descricao', 255)
            ->requirePresence('descricao', 'create')
            ->notEmptyString('descricao');

        return $validator;
    }
}
