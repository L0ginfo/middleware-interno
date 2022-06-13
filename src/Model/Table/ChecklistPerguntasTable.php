<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ChecklistPerguntas Model
 *
 * @property \App\Model\Table\ChecklistsTable&\Cake\ORM\Association\BelongsTo $Checklists
 * @property \App\Model\Table\ChecklistPerguntaRespostasTable&\Cake\ORM\Association\HasMany $ChecklistPerguntaRespostas
 * @property \App\Model\Table\ChecklistResvPerguntasTable&\Cake\ORM\Association\HasMany $ChecklistResvPerguntas
 *
 * @method \App\Model\Entity\ChecklistPergunta get($primaryKey, $options = [])
 * @method \App\Model\Entity\ChecklistPergunta newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ChecklistPergunta[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ChecklistPergunta|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ChecklistPergunta saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ChecklistPergunta patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ChecklistPergunta[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ChecklistPergunta findOrCreate($search, callable $callback = null, $options = [])
 */
class ChecklistPerguntasTable extends Table
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
        

        $this->setTable('checklist_perguntas');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('Checklists', [
            'foreignKey' => 'checklist_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('ChecklistPerguntaRespostas', [
            'foreignKey' => 'checklist_pergunta_id',
        ]);
        $this->hasMany('ChecklistResvPerguntas', [
            'foreignKey' => 'checklist_pergunta_id',
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
            ->integer('ordem')
            ->requirePresence('ordem', 'create')
            ->notEmptyString('ordem');

        $validator
            ->scalar('observacao')
            ->allowEmptyString('observacao');

        $validator
            ->integer('permite_multiplas')
            ->allowEmptyString('permite_multiplas');

        $validator
            ->integer('obrigatorio')
            ->allowEmptyString('obrigatorio');

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
        $rules->add($rules->existsIn(['checklist_id'], 'Checklists'));

        return $rules;
    }
}
