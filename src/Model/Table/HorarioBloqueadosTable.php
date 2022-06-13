<?php
namespace App\Model\Table;

use App\Model\Entity\HorarioBloqueado;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * HorarioBloqueados Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Operacoes
 */
class HorarioBloqueadosTable extends Table
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

        $this->table('horario_bloqueados');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('LogsTabelas');

        $this->belongsTo('Operacoes', [
            'foreignKey' => 'operacao_id',
            'joinType' => 'left'
        ]);
    }
    public function beforeSave($event, $entity, $options) {

        dd('ok');

        if (!$entity->operacao_id) {
            $entity->operacao_id = 0;
        }

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
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id', 'create');

        $validator
            ->allowEmpty('nome');

        $validator
            ->allowEmpty('hora_inicio');

        $validator
            ->allowEmpty('hora_fim');

        $validator
            ->add('data_inicio', 'valid', ['rule' => ['date', 'dmy']])
            ->requirePresence('data_inicio', 'create')
            ->notEmpty('data_inicio');

        $validator
            ->add('data_fim', 'valid', ['rule' => ['date', 'dmy']])
            ->requirePresence('data_fim', 'create')
            ->notEmpty('data_fim');

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
       // $rules->add($rules->existsIn(['operacao_id'], 'Operacoes'));
        return $rules;
    }
}
