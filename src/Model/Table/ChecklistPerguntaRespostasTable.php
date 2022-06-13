<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ChecklistPerguntaRespostas Model
 *
 * @property \App\Model\Table\ChecklistPerguntasTable&\Cake\ORM\Association\BelongsTo $ChecklistPerguntas
 * @property \App\Model\Table\ChecklistResvRespostasTable&\Cake\ORM\Association\HasMany $ChecklistResvRespostas
 *
 * @method \App\Model\Entity\ChecklistPerguntaResposta get($primaryKey, $options = [])
 * @method \App\Model\Entity\ChecklistPerguntaResposta newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ChecklistPerguntaResposta[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ChecklistPerguntaResposta|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ChecklistPerguntaResposta saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ChecklistPerguntaResposta patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ChecklistPerguntaResposta[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ChecklistPerguntaResposta findOrCreate($search, callable $callback = null, $options = [])
 */
class ChecklistPerguntaRespostasTable extends Table
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
        

        $this->setTable('checklist_pergunta_respostas');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('ChecklistPerguntas', [
            'foreignKey' => 'checklist_pergunta_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('ChecklistResvRespostas', [
            'foreignKey' => 'checklist_pergunta_resposta_id',
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
            ->integer('correta')
            ->notEmptyString('correta');

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
        $rules->add($rules->existsIn(['checklist_pergunta_id'], 'ChecklistPerguntas'));

        return $rules;
    }
}
