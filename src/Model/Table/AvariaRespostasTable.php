<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AvariaRespostas Model
 *
 * @property \App\Model\Table\AvariasTable&\Cake\ORM\Association\BelongsTo $Avarias
 * @property \App\Model\Table\VistoriaAvariaRespostasTable&\Cake\ORM\Association\HasMany $VistoriaAvariaRespostas
 *
 * @method \App\Model\Entity\AvariaResposta get($primaryKey, $options = [])
 * @method \App\Model\Entity\AvariaResposta newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\AvariaResposta[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AvariaResposta|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AvariaResposta saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AvariaResposta patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\AvariaResposta[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\AvariaResposta findOrCreate($search, callable $callback = null, $options = [])
 */
class AvariaRespostasTable extends Table
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
        

        $this->setTable('avaria_respostas');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('Avarias', [
            'foreignKey' => 'avaria_id',
        ]);
        $this->hasMany('VistoriaAvariaRespostas', [
            'foreignKey' => 'avaria_resposta_id',
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
            ->allowEmptyString('descricao');

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
        $rules->add($rules->existsIn(['avaria_id'], 'Avarias'));

        return $rules;
    }
}
