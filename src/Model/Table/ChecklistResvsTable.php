<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ChecklistResvs Model
 *
 * @property \App\Model\Table\ResvsTable&\Cake\ORM\Association\BelongsTo $Resvs
 * @property \App\Model\Table\ChecklistsTable&\Cake\ORM\Association\BelongsTo $Checklists
 * @property \App\Model\Table\ChecklistPerguntaFotosTable&\Cake\ORM\Association\HasMany $ChecklistPerguntaFotos
 * @property \App\Model\Table\ChecklistResvPerguntasTable&\Cake\ORM\Association\HasMany $ChecklistResvPerguntas
 * @property \App\Model\Table\ChecklistResvRespostasTable&\Cake\ORM\Association\HasMany $ChecklistResvRespostas
 *
 * @method \App\Model\Entity\ChecklistResv get($primaryKey, $options = [])
 * @method \App\Model\Entity\ChecklistResv newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ChecklistResv[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ChecklistResv|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ChecklistResv saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ChecklistResv patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ChecklistResv[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ChecklistResv findOrCreate($search, callable $callback = null, $options = [])
 */
class ChecklistResvsTable extends Table
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
        

        $this->setTable('checklist_resvs');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('Resvs', [
            'foreignKey' => 'resv_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Checklists', [
            'foreignKey' => 'checklist_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('ChecklistPerguntaFotos', [
            'foreignKey' => 'checklist_resv_id',
        ]);
        $this->hasMany('ChecklistResvPerguntas', [
            'foreignKey' => 'checklist_resv_id',
        ]);
        $this->hasMany('ChecklistResvRespostas', [
            'foreignKey' => 'checklist_resv_id',
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
            ->dateTime('data_inicio')
            ->allowEmptyDateTime('data_inicio');

        $validator
            ->dateTime('data_fim')
            ->allowEmptyDateTime('data_fim');

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
        $rules->add($rules->existsIn(['resv_id'], 'Resvs'));
        $rules->add($rules->existsIn(['checklist_id'], 'Checklists'));

        return $rules;
    }
}
