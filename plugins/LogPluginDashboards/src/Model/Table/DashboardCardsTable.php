<?php
namespace LogPluginDashboards\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DashboardCards Model
 *
 * @property \LogPluginDashboards\Model\Table\DashboardsTable&\Cake\ORM\Association\BelongsTo $Dashboards
 *
 * @method \LogPluginDashboards\Model\Entity\DashboardCard get($primaryKey, $options = [])
 * @method \LogPluginDashboards\Model\Entity\DashboardCard newEntity($data = null, array $options = [])
 * @method \LogPluginDashboards\Model\Entity\DashboardCard[] newEntities(array $data, array $options = [])
 * @method \LogPluginDashboards\Model\Entity\DashboardCard|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \LogPluginDashboards\Model\Entity\DashboardCard saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \LogPluginDashboards\Model\Entity\DashboardCard patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \LogPluginDashboards\Model\Entity\DashboardCard[] patchEntities($entities, array $data, array $options = [])
 * @method \LogPluginDashboards\Model\Entity\DashboardCard findOrCreate($search, callable $callback = null, $options = [])
 */
class DashboardCardsTable extends Table
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
        

        $this->setTable('dashboard_cards');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('Dashboards', [
            'foreignKey' => 'dashboard_id',
            'joinType' => 'INNER',
            'className' => 'LogPluginDashboards.Dashboards',
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

        $validator
            ->scalar('cor')
            ->maxLength('cor', 255)
            ->requirePresence('cor', 'create')
            ->notEmptyString('cor');

        $validator
            ->scalar('url')
            ->maxLength('url', 255)
            ->allowEmptyString('url');

        $validator
            ->scalar('controller')
            ->maxLength('controller', 255)
            ->allowEmptyString('controller');

        $validator
            ->scalar('action')
            ->maxLength('action', 255)
            ->allowEmptyString('action');

        $validator
            ->scalar('icone')
            ->maxLength('icone', 255)
            ->allowEmptyString('icone');

        $validator
            ->scalar('consulta_coluna_dado')
            ->maxLength('consulta_coluna_dado', 255)
            ->allowEmptyString('consulta_coluna_dado');

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
        $rules->add($rules->existsIn(['dashboard_id'], 'Dashboards'));

        return $rules;
    }
}
