<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ResvContainerLacres Model
 *
 * @property \App\Model\Table\LacreTiposTable&\Cake\ORM\Association\BelongsTo $LacreTipos
 * @property \App\Model\Table\ResvsContainersTable&\Cake\ORM\Association\BelongsTo $ResvsContainers
 *
 * @method \App\Model\Entity\ResvContainerLacre get($primaryKey, $options = [])
 * @method \App\Model\Entity\ResvContainerLacre newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ResvContainerLacre[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ResvContainerLacre|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ResvContainerLacre saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ResvContainerLacre patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ResvContainerLacre[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ResvContainerLacre findOrCreate($search, callable $callback = null, $options = [])
 */
class ResvContainerLacresTable extends Table
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
        

        $this->setTable('resv_container_lacres');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('LacreTipos', [
            'foreignKey' => 'lacre_tipo_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('ResvsContainers', [
            'foreignKey' => 'resv_container_id',
            'joinType' => 'INNER',
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
            ->scalar('lacre_numero')
            ->maxLength('lacre_numero', 45)
            ->requirePresence('lacre_numero', 'create')
            ->notEmptyString('lacre_numero');

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
        $rules->add($rules->existsIn(['lacre_tipo_id'], 'LacreTipos'));
        $rules->add($rules->existsIn(['resv_container_id'], 'ResvsContainers'));

        return $rules;
    }
}
