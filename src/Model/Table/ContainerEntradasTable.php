<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ContainerEntradas Model
 *
 * @property \App\Model\Table\DocumentosTransportesTable&\Cake\ORM\Association\BelongsTo $DocumentosTransportes
 * @property \App\Model\Table\ContainersTable&\Cake\ORM\Association\BelongsTo $Containers
 *
 * @method \App\Model\Entity\ContainerEntrada get($primaryKey, $options = [])
 * @method \App\Model\Entity\ContainerEntrada newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ContainerEntrada[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ContainerEntrada|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ContainerEntrada saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ContainerEntrada patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ContainerEntrada[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ContainerEntrada findOrCreate($search, callable $callback = null, $options = [])
 */
class ContainerEntradasTable extends Table
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
        

        $this->setTable('container_entradas');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('DocumentosTransportes', [
            'foreignKey' => 'documento_transporte_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Containers', [
            'foreignKey' => 'container_id',
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
            ->scalar('free_time_demurrage')
            ->maxLength('free_time_demurrage', 45)
            ->allowEmptyString('free_time_demurrage');

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
        $rules->add($rules->existsIn(['documento_transporte_id'], 'DocumentosTransportes'));
        $rules->add($rules->existsIn(['container_id'], 'Containers'));

        return $rules;
    }
}
