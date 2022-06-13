<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * GradeHorarioBloqueioPerfis Model
 *
 * @property \App\Model\Table\GradeHorariosTable&\Cake\ORM\Association\BelongsTo $GradeHorarios
 * @property \App\Model\Table\PerfisTable&\Cake\ORM\Association\BelongsTo $Perfis
 *
 * @method \App\Model\Entity\GradeHorarioBloqueioPerfi get($primaryKey, $options = [])
 * @method \App\Model\Entity\GradeHorarioBloqueioPerfi newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\GradeHorarioBloqueioPerfi[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\GradeHorarioBloqueioPerfi|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\GradeHorarioBloqueioPerfi saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\GradeHorarioBloqueioPerfi patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\GradeHorarioBloqueioPerfi[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\GradeHorarioBloqueioPerfi findOrCreate($search, callable $callback = null, $options = [])
 */
class GradeHorarioBloqueioPerfisTable extends Table
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
        

        $this->setTable('grade_horario_bloqueio_perfis');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('GradeHorarios', [
            'foreignKey' => 'grade_horario_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Perfis', [
            'foreignKey' => 'perfil_id',
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
        $rules->add($rules->existsIn(['grade_horario_id'], 'GradeHorarios'));
        $rules->add($rules->existsIn(['perfil_id'], 'Perfis'));

        return $rules;
    }
}
