<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * GradeHorarioLiberacaoTransportadoras Model
 *
 * @property &\Cake\ORM\Association\BelongsTo $GradeHorarios
 * @property \App\Model\Table\TransportadorasTable&\Cake\ORM\Association\BelongsTo $Transportadoras
 *
 * @method \App\Model\Entity\GradeHorarioLiberacaoTransportadora get($primaryKey, $options = [])
 * @method \App\Model\Entity\GradeHorarioLiberacaoTransportadora newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\GradeHorarioLiberacaoTransportadora[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\GradeHorarioLiberacaoTransportadora|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\GradeHorarioLiberacaoTransportadora saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\GradeHorarioLiberacaoTransportadora patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\GradeHorarioLiberacaoTransportadora[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\GradeHorarioLiberacaoTransportadora findOrCreate($search, callable $callback = null, $options = [])
 */
class GradeHorarioLiberacaoTransportadorasTable extends Table
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
        

        $this->setTable('grade_horario_liberacao_transportadoras');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('GradeHorarios', [
            'foreignKey' => 'grade_horario_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Transportadoras', [
            'foreignKey' => 'transportadora_id',
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

        $validator
            ->dateTime('inicio')
            ->requirePresence('inicio', 'create')
            ->notEmptyDateTime('inicio');

        $validator
            ->dateTime('fim')
            ->requirePresence('fim', 'create')
            ->notEmptyDateTime('fim');

        $validator
            ->numeric('cadastrado')
            ->allowEmptyString('cadastrado');

        $validator
            ->numeric('realizado')
            ->allowEmptyString('realizado');

        $validator
            ->numeric('estimado')
            ->allowEmptyString('estimado');

        $validator
            ->numeric('saldo')
            ->allowEmptyString('saldo');

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
        $rules->add($rules->existsIn(['grade_horario_id'], 'GradeHorarios'));
        $rules->add($rules->existsIn(['transportadora_id'], 'Transportadoras'));

        return $rules;
    }
}
