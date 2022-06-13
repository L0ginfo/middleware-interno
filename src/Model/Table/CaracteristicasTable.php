<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Caracteristicas Model
 *
 * @property \App\Model\Table\TipoCaracteristicasTable&\Cake\ORM\Association\BelongsTo $TipoCaracteristicas
 * @property \App\Model\Table\PlanoCargaCaracteristicasTable&\Cake\ORM\Association\HasMany $PlanoCargaCaracteristicas
 *
 * @method \App\Model\Entity\Caracteristica get($primaryKey, $options = [])
 * @method \App\Model\Entity\Caracteristica newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Caracteristica[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Caracteristica|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Caracteristica saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Caracteristica patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Caracteristica[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Caracteristica findOrCreate($search, callable $callback = null, $options = [])
 */
class CaracteristicasTable extends Table
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
        

        $this->setTable('caracteristicas');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('TipoCaracteristicas', [
            'foreignKey' => 'tipo_caracteristica_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('PlanoCargaCaracteristicas', [
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

        $validator
            ->scalar('descricao')
            ->maxLength('descricao', 255)
            ->requirePresence('descricao', 'create')
            ->notEmptyString('descricao');

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
        $rules->add($rules->existsIn(['tipo_caracteristica_id'], 'TipoCaracteristicas'));

        return $rules;
    }
}
