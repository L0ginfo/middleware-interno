<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ChecklistResvRespostas Model
 *
 * @property \App\Model\Table\ChecklistResvsTable&\Cake\ORM\Association\BelongsTo $ChecklistResvs
 * @property \App\Model\Table\ChecklistPerguntaRespostasTable&\Cake\ORM\Association\BelongsTo $ChecklistPerguntaRespostas
 * @property \App\Model\Table\ChecklistResvPerguntasTable&\Cake\ORM\Association\BelongsTo $ChecklistResvPerguntas
 *
 * @method \App\Model\Entity\ChecklistResvResposta get($primaryKey, $options = [])
 * @method \App\Model\Entity\ChecklistResvResposta newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ChecklistResvResposta[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ChecklistResvResposta|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ChecklistResvResposta saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ChecklistResvResposta patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ChecklistResvResposta[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ChecklistResvResposta findOrCreate($search, callable $callback = null, $options = [])
 */
class ChecklistResvRespostasTable extends Table
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
        

        $this->setTable('checklist_resv_respostas');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('ChecklistResvs', [
            'foreignKey' => 'checklist_resv_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('ChecklistPerguntaRespostas', [
            'foreignKey' => 'checklist_pergunta_resposta_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('ChecklistResvPerguntas', [
            'foreignKey' => 'checklist_resv_pergunta_id',
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
        $rules->add($rules->existsIn(['checklist_pergunta_resposta_id'], 'ChecklistPerguntaRespostas'));
        $rules->add($rules->existsIn(['checklist_resv_pergunta_id'], 'ChecklistResvPerguntas'));

        return $rules;
    }
}
