<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ProgramacaoContainerLacres Model
 *
 * @property \App\Model\Table\LacreTiposTable&\Cake\ORM\Association\BelongsTo $LacreTipos
 * @property \App\Model\Table\ProgramacaoContainersTable&\Cake\ORM\Association\BelongsTo $ProgramacaoContainers
 *
 * @method \App\Model\Entity\ProgramacaoContainerLacre get($primaryKey, $options = [])
 * @method \App\Model\Entity\ProgramacaoContainerLacre newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ProgramacaoContainerLacre[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ProgramacaoContainerLacre|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ProgramacaoContainerLacre saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ProgramacaoContainerLacre patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ProgramacaoContainerLacre[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ProgramacaoContainerLacre findOrCreate($search, callable $callback = null, $options = [])
 */
class ProgramacaoContainerLacresTable extends Table
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
        

        $this->setTable('programacao_container_lacres');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('Lacres', [
            'foreignKey' => 'lacre_id',
            'joinType' => 'INNER',
        ]);

        $this->belongsTo('LacreTipos', [
            'foreignKey' => 'lacre_tipo_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('ProgramacaoContainers', [
            'foreignKey' => 'programacao_container_id',
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
        $rules->add($rules->existsIn(['programacao_container_id'], 'ProgramacaoContainers'));

        return $rules;
    }
}
