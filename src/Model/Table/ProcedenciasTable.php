<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Procedencias Model
 *
 * @property &\Cake\ORM\Association\BelongsTo $Paises
 * @property &\Cake\ORM\Association\BelongsTo $Modais
 *
 * @method \App\Model\Entity\Procedencia get($primaryKey, $options = [])
 * @method \App\Model\Entity\Procedencia newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Procedencia[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Procedencia|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Procedencia saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Procedencia patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Procedencia[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Procedencia findOrCreate($search, callable $callback = null, $options = [])
 */
class ProcedenciasTable extends Table
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

        $this->setTable('procedencias');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->addBehavior('LogsTabelas');

        $this->belongsTo('Paises', [
            'foreignKey' => 'pais_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Modais', [
            'foreignKey' => 'modal_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('LeftPaises', [
            'propertyName' => 'pais',
            'className'  => 'Paises',
            'foreignKey' => 'pais_id',
            'joinType' => 'LEFT'
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
            ->scalar('nome')
            ->maxLength('nome', 255)
            ->requirePresence('nome', 'create')
            ->notEmptyString('nome');

        $validator
            ->scalar('sigla')
            ->maxLength('sigla', 8)
            ->requirePresence('sigla', 'create')
            ->notEmptyString('sigla');

        $validator
            ->integer('is_internacional')
            ->requirePresence('is_internacional', 'create')
            ->notEmptyString('is_internacional');

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
        $rules->add($rules->existsIn(['pais_id'], 'Paises'));
        $rules->add($rules->existsIn(['modal_id'], 'Modais'));

        return $rules;
    }
}
