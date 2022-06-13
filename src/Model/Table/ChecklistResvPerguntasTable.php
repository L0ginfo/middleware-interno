<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ChecklistResvPerguntas Model
 *
 * @property \App\Model\Table\ChecklistResvsTable&\Cake\ORM\Association\BelongsTo $ChecklistResvs
 * @property \App\Model\Table\ChecklistPerguntasTable&\Cake\ORM\Association\BelongsTo $ChecklistPerguntas
 * @property \App\Model\Table\ChecklistResvRespostasTable&\Cake\ORM\Association\HasMany $ChecklistResvRespostas
 *
 * @method \App\Model\Entity\ChecklistResvPergunta get($primaryKey, $options = [])
 * @method \App\Model\Entity\ChecklistResvPergunta newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ChecklistResvPergunta[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ChecklistResvPergunta|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ChecklistResvPergunta saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ChecklistResvPergunta patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ChecklistResvPergunta[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ChecklistResvPergunta findOrCreate($search, callable $callback = null, $options = [])
 */
class ChecklistResvPerguntasTable extends Table
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
        

        $this->setTable('checklist_resv_perguntas');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('ChecklistResvs', [
            'foreignKey' => 'checklist_resv_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('ChecklistPerguntas', [
            'foreignKey' => 'checklist_pergunta_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('ChecklistResvRespostas', [
            'foreignKey' => 'checklist_resv_pergunta_id',
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
            ->scalar('observacoes')
            ->allowEmptyString('observacoes');

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
        $rules->add($rules->existsIn(['checklist_resv_id'], 'ChecklistResvs'));
        $rules->add($rules->existsIn(['checklist_pergunta_id'], 'ChecklistPerguntas'));

        return $rules;
    }
}
