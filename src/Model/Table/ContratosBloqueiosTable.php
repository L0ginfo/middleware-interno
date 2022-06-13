<?php

namespace App\Model\Table;

use App\Model\Entity\ContratosBloqueio;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Datasource\ConnectionManager;
use PDO;
use PDOException;
use Cake\Event\Event;
use ArrayObject;

/**
 * ContratosBloqueios Model
 *
 * @property \Cake\ORM\Association\BelongsTo $InstituicoesFinanceiras
 * @property \Cake\ORM\Association\BelongsTo $UsuarioDesativacoes
 * @property \Cake\ORM\Association\HasMany $LotesDisBloqueados
 */
class ContratosBloqueiosTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->table('contratos_bloqueios');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('LogsTabelas');

        $this->belongsTo('InstituicoesFinanceiras', [
            'foreignKey' => 'instituicoes_financeira_id',
            'joinType' => 'INNER'
        ]);

        $this->belongsTo('cliente', [
            'className' => 'Empresas',
            'foreignKey' => 'cliente_id',
            'bindingKey' => 'codigo_sara',
            'joinType' => 'left'
        ]);

        $this->belongsTo('Usuarios', [
            'foreignKey' => 'usuario_desativacao_id',
            'joinType' => 'INNER'
        ]);

        $this->hasMany('LotesDisBloqueados', [
            'foreignKey' => 'contratos_bloqueio_id'
        ]);
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
                ->requirePresence('nr_contrato', 'create')
                ->notEmpty('nr_contrato');

        $validator
                ->requirePresence('dt_contrato', 'create')
                ->notEmpty('dt_contrato');

        $validator
                ->allowEmpty('email_aviso');

        $validator
                ->requirePresence('ativo', 'create')
                ->notEmpty('ativo');

        $validator
                ->allowEmpty('dt_desativacao');

        $validator
                ->allowEmpty('motivo_desativacao');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules) {
        $rules->add($rules->existsIn(['instituicoes_financeira_id'], 'InstituicoesFinanceiras'));

        //$rules->add($rules->existsIn(['usuario_desativacao_id'], 'UsuarioDesativacoes'));
        return $rules;
    }

}
