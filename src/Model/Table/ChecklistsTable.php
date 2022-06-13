<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Checklists Model
 *
 * @property \App\Model\Table\ChecklistTiposTable&\Cake\ORM\Association\BelongsTo $ChecklistTipos
 * @property \App\Model\Table\ChecklistPerguntasTable&\Cake\ORM\Association\HasMany $ChecklistPerguntas
 * @property \App\Model\Table\ChecklistResvsTable&\Cake\ORM\Association\HasMany $ChecklistResvs
 *
 * @method \App\Model\Entity\Checklist get($primaryKey, $options = [])
 * @method \App\Model\Entity\Checklist newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Checklist[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Checklist|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Checklist saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Checklist patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Checklist[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Checklist findOrCreate($search, callable $callback = null, $options = [])
 */
class ChecklistsTable extends Table
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
        

        $this->setTable('checklists');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('ChecklistTipos', [
            'foreignKey' => 'checklist_tipo_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('ChecklistPerguntas', [
            'foreignKey' => 'checklist_id',
        ]);
        $this->hasMany('ChecklistResvs', [
            'foreignKey' => 'checklist_id',
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

        $validator
            ->scalar('descricao_detalhada')
            ->maxLength('descricao_detalhada', 255)
            ->allowEmptyString('descricao_detalhada');

        $validator
            ->scalar('footer')
            ->allowEmptyString('footer');

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
        $rules->add($rules->existsIn(['checklist_tipo_id'], 'ChecklistTipos'));

        return $rules;
    }
}
