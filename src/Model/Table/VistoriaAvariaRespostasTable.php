<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * VistoriaAvariaRespostas Model
 *
 * @property \App\Model\Table\AvariasTable&\Cake\ORM\Association\BelongsTo $Avarias
 * @property \App\Model\Table\AvariaRespostasTable&\Cake\ORM\Association\BelongsTo $AvariaRespostas
 * @property \App\Model\Table\VistoriaAvariasTable&\Cake\ORM\Association\BelongsTo $VistoriaAvarias
 *
 * @method \App\Model\Entity\VistoriaAvariaResposta get($primaryKey, $options = [])
 * @method \App\Model\Entity\VistoriaAvariaResposta newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\VistoriaAvariaResposta[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\VistoriaAvariaResposta|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\VistoriaAvariaResposta saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\VistoriaAvariaResposta patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\VistoriaAvariaResposta[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\VistoriaAvariaResposta findOrCreate($search, callable $callback = null, $options = [])
 */
class VistoriaAvariaRespostasTable extends Table
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
        

        $this->setTable('vistoria_avaria_respostas');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('Avarias', [
            'foreignKey' => 'avaria_id',
        ]);
        $this->belongsTo('AvariaRespostas', [
            'foreignKey' => 'avaria_resposta_id',
        ]);
        $this->belongsTo('VistoriaAvarias', [
            'foreignKey' => 'vistoria_avaria_id',
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
            ->dateTime('created_at')
            ->notEmptyDateTime('created_at');

        $validator
            ->dateTime('updated_at')
            ->allowEmptyDateTime('updated_at');

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
        $rules->add($rules->existsIn(['avaria_resposta_id'], 'AvariaRespostas'));
        $rules->add($rules->existsIn(['vistoria_avaria_id'], 'VistoriaAvarias'));

        return $rules;
    }
}
