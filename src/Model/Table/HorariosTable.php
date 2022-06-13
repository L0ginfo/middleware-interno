<?php

namespace App\Model\Table;

use App\Model\Entity\Horario;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Horarios Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Operacoes
 */
class HorariosTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->table('horarios');
        $this->displayField('nome');
        $this->primaryKey('id');

        $this->addBehavior('LogsTabelas');

        $this->belongsTo('Operacoes', [
            'foreignKey' => 'operacao_id',
            'joinType' => 'INNER'
        ]);
        
              $this->hasMany('HorarioLiberados', [
           // 'foreignKey' => 'horario_id',
            'joinType' => 'INNER'
        ]);
    }

    public function _Lista_horarios() {
        $intervalo = 30;

        for ($h = 0; $h < 24; $h++) {
            for ($m = 0; $m < 60 / $intervalo; $m++) {
                $minuto = $m * $intervalo;
                $horas[str_pad($h, 2, "0", STR_PAD_LEFT) . ':' . str_pad($minuto, 2, "0", STR_PAD_LEFT)] = str_pad($h, 2, "0", STR_PAD_LEFT) . ':' . str_pad($minuto, 2, "0", STR_PAD_LEFT);
            }
        }
        return $horas;
    }

    public static function _Lista_horarios_faixa($hora_inicio, $hora_fim) {
        $intervalo = 30;

        $hora_inicial = explode(':', $hora_inicio);
        $hora_fim = explode(':', $hora_fim);

        for ($h = $hora_inicial[0]; $h <= $hora_fim[0]; $h++) {
            for ($m = 0; $m < 60 / $intervalo; $m++) {
                $minuto = $m * $intervalo;
                $hora_temp = str_pad($h, 2, "0", STR_PAD_LEFT) . ':' . str_pad($minuto, 2, "0", STR_PAD_LEFT);

                if ($h >= $hora_inicial[0] && $h <= $hora_fim[0]) {
                    if ($h == $hora_inicial[0]) {
                        if ($minuto >= $hora_inicial[1])
                            $horas[$hora_temp] = $hora_temp;
                    } else {
                        if ($h == $hora_fim[0]) {
                            if ($minuto <= $hora_fim[1])
                                $horas[$hora_temp] = $hora_temp;
                        } else {
                            $horas[$hora_temp] = $hora_temp;
                        }
                    }
                }
            }
        }
        // die();
        return $horas;
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator) {
        $validator
                ->add('id', 'valid', ['rule' => 'numeric'])
                ->allowEmpty('id', 'create');

        $validator
                ->allowEmpty('Nome');

        $validator
                ->add('quantidade_maxima', 'valid', ['rule' => 'numeric'])
                ->allowEmpty('quantidade_maxima');

        $validator
                ->requirePresence('hora_inicio', 'create')
                ->notEmpty('hora_inicio');

        $validator
                ->requirePresence('hora_fim', 'create')
                ->notEmpty('hora_fim');

        $validator
                ->requirePresence('data_inicio', 'create')
                ->notEmpty('data_inicio');

        $validator
                ->requirePresence('data_fim', 'create')
                ->notEmpty('data_fim');

        $validator
                ->add('segunda', 'valid', ['rule' => 'boolean'])
                ->allowEmpty('segunda');

        $validator
                ->add('terca', 'valid', ['rule' => 'boolean'])
                ->allowEmpty('terca');

        $validator
                ->add('quarta', 'valid', ['rule' => 'boolean'])
                ->allowEmpty('quarta');

        $validator
                ->add('quinta', 'valid', ['rule' => 'boolean'])
                ->allowEmpty('quinta');

        $validator
                ->add('sexta', 'valid', ['rule' => 'boolean'])
                ->allowEmpty('sexta');

        $validator
                ->add('sabado', 'valid', ['rule' => 'boolean'])
                ->allowEmpty('sabado');

        $validator
                ->add('domingo', 'valid', ['rule' => 'boolean'])
                ->allowEmpty('domingo');

        return $validator;
    }

    public function beforeSave($event, $entity, $options) {
        $entity->hora_inicio = str_pad($entity->hora_inicio, 5, "0", STR_PAD_LEFT);
        $entity->hora_fim = str_pad($entity->hora_fim, 5, "0", STR_PAD_LEFT);
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules) {
        $rules->add($rules->existsIn(['operacao_id'], 'Operacoes'));
        return $rules;
    }

}
