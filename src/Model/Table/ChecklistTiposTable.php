<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ChecklistTipos Model
 *
 * @property \App\Model\Table\ChecklistsTable&\Cake\ORM\Association\HasMany $Checklists
 *
 * @method \App\Model\Entity\ChecklistTipo get($primaryKey, $options = [])
 * @method \App\Model\Entity\ChecklistTipo newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ChecklistTipo[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ChecklistTipo|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ChecklistTipo saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ChecklistTipo patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ChecklistTipo[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ChecklistTipo findOrCreate($search, callable $callback = null, $options = [])
 */
class ChecklistTiposTable extends Table
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
        

        $this->setTable('checklist_tipos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->hasMany('Checklists', [
            'foreignKey' => 'checklist_tipo_id',
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
