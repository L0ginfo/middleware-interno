<?php
namespace LogPluginDashboards\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Dashboards Model
 *
 * @property \LogPluginDashboards\Model\Table\PerfisTable&\Cake\ORM\Association\BelongsTo $Perfis
 * @property \LogPluginDashboards\Model\Table\UsuariosTable&\Cake\ORM\Association\BelongsTo $Usuarios
 * @property \LogPluginDashboards\Model\Table\DashboardCardsTable&\Cake\ORM\Association\HasMany $DashboardCards
 * @property \LogPluginDashboards\Model\Table\DashboardGraficosTable&\Cake\ORM\Association\HasMany $DashboardGraficos
 *
 * @method \LogPluginDashboards\Model\Entity\Dashboard get($primaryKey, $options = [])
 * @method \LogPluginDashboards\Model\Entity\Dashboard newEntity($data = null, array $options = [])
 * @method \LogPluginDashboards\Model\Entity\Dashboard[] newEntities(array $data, array $options = [])
 * @method \LogPluginDashboards\Model\Entity\Dashboard|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \LogPluginDashboards\Model\Entity\Dashboard saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \LogPluginDashboards\Model\Entity\Dashboard patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \LogPluginDashboards\Model\Entity\Dashboard[] patchEntities($entities, array $data, array $options = [])
 * @method \LogPluginDashboards\Model\Entity\Dashboard findOrCreate($search, callable $callback = null, $options = [])
 */
class DashboardsTable extends Table
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
        

        $this->setTable('dashboards');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('Perfis', [
            'foreignKey' => 'perfil_id',
            'className' => 'LogPluginDashboards.Perfis',
        ]);
        $this->belongsTo('Usuarios', [
            'foreignKey' => 'usuario_id',
            'className' => 'LogPluginDashboards.Usuarios',
        ]);
        $this->hasMany('DashboardCards', [
            'foreignKey' => 'dashboard_id',
            'className' => 'LogPluginDashboards.DashboardCards',
        ]);
        $this->hasMany('DashboardGraficos', [
            'foreignKey' => 'dashboard_id',
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
            ->scalar('titulo')
            ->maxLength('titulo', 255)
            ->requirePresence('titulo', 'create')
            ->notEmptyString('titulo');

        $validator
            ->integer('ordem')
            ->allowEmptyString('ordem');

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
        $rules->add($rules->existsIn(['perfil_id'], 'Perfis'));
        $rules->add($rules->existsIn(['usuario_id'], 'Usuarios'));

        return $rules;
    }
}
