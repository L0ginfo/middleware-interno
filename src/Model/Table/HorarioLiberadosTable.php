<?php
namespace App\Model\Table;

use App\Model\Entity\HorarioLiberado;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Event\Event;

/**
 * HorarioLiberados Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Horarios
 */
class HorarioLiberadosTable extends Table
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

        $this->table('horario_liberados');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('LogsTabelas');

        $this->belongsTo('Horarios', [
            'foreignKey' => 'horario_id',
            'joinType' => 'INNER'
        ]);
        
         $this->hasMany('Agendamentos', [
            'foreignKey' => 'horario_liberado_id',
             'conditions' =>'Agendamentos.situacao_agendamento_id > 0'
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
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id', 'create');

        $validator
            ->add('hora', 'valid', ['rule' => ['date', 'dmy']])
            ->requirePresence('hora', 'create')
            ->notEmpty('hora');

        $validator
            ->add('data', 'valid', ['rule' => 'time'])
            ->requirePresence('data', 'create')
            ->notEmpty('data');

        $validator
            ->allowEmpty('cnpj');

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
        $rules->add($rules->existsIn(['horario_id'], 'Horarios'));
        return $rules;
    }
    
    function beforeFind(Event $event, Query $query, $options, $primary) {


        if ($_SESSION['Auth']['User']['perfil_id'] == PERFIL_ADMIN) {
            //administrador
            return;
        }

        if ($_SESSION['Auth']['User']['perfil_id'] == PERFIL_TRANSPORTADORA) {
            $list = '-1';
            foreach ($_SESSION['empresasDoUsuarios'] as $e) {
                $list .= ",'" . $e['empresa']['cnpj'] . "'";
            }

            $conditions = $query->where('( cnpj is null or cnpj  in (' . $list . '))');
            return;
        }

        $list = '-1';
        foreach ($_SESSION['empresasDoUsuarios'] as $e) {
            $list .= ",'" . $e['empresa']['cnpj'] . "'";
        }

         $conditions = $query->where(' ( cnpj is null or   cnpj in (' . $list . ' ) )  ');
        //debug($conditions)  ;die();
        return;

      
    }

}
