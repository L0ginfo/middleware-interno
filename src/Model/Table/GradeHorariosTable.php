<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * GradeHorarios Model
 *
 * @property \App\Model\Table\GradeHorariosTable&\Cake\ORM\Association\BelongsTo $GradeHorarioMasters
 * @property \App\Model\Table\OperacoesTable&\Cake\ORM\Association\BelongsTo $Operacoes
 * @property \App\Model\Table\RegimesAduaneirosTable&\Cake\ORM\Association\BelongsTo $RegimesAduaneiros
 * @property \App\Model\Table\ProdutosTable&\Cake\ORM\Association\BelongsTo $Produtos
 * @property \App\Model\Table\DriveEspacoTiposTable&\Cake\ORM\Association\BelongsTo $DriveEspacoTipos
 * @property \App\Model\Table\DriveEspacoClassificacoesTable&\Cake\ORM\Association\BelongsTo $DriveEspacoClassificacoes
 *
 * @method \App\Model\Entity\GradeHorario get($primaryKey, $options = [])
 * @method \App\Model\Entity\GradeHorario newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\GradeHorario[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\GradeHorario|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\GradeHorario saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\GradeHorario patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\GradeHorario[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\GradeHorario findOrCreate($search, callable $callback = null, $options = [])
 */
class GradeHorariosTable extends Table
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
        

        $this->setTable('grade_horarios');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('GradeHorarioMasters', [
            'className' => 'GradeHorarios',
            'foreignKey' => 'id',
            'bindingKey' => 'GradeHorarioMasters.grade_horario_master_id',
            'joinType' => 'INNER',
        ]);

        $this->hasMany('GradeHorarioLiberados', [
            'className' => 'GradeHorarios',
            'foreignKey' => 'grade_horario_master_id',
            'conditions' => ['GradeHorarioLiberados.tipo_grade' => 1]
        ]);

        $this->hasMany('GradeHorarioBloqueadosInicio', [
            'className' => 'GradeHorarios',
            'foreignKey' => 'grade_horario_master_id',
            'conditions' => ['GradeHorarioBloqueadosInicio.tipo_grade' => 2],
            'joinType' => 'LEFT',
        ]);

        $this->hasOne('GradeHorarioBloqueadosFim', [
            'className' => 'GradeHorarios',
            'foreignKey' => 'grade_horario_master_id',
            'conditions' => ['GradeHorarioBloqueadosFim.tipo_grade' => 2],
            'joinType' => 'INNER',
        ]);


        $this->hasMany('ProgracoesAgendadas', [
            'className' => 'Programacoes',
            'foreignKey' => 'grade_horario_id',
            'joinType' => 'LEFT',
        ]);

        $this->hasMany('GradeHorarioLiberacaoTransportadoras', [
            'foreignKey' => 'grade_horario_id',
            'joinType' => 'LEFT',
        ]);

        $this->hasMany('GradeHorarioBloqueioPerfis', [
            'foreignKey' => 'grade_horario_id',
            'joinType' => 'LEFT',
        ]);
        
        $this->belongsTo('Operacoes', [
            'foreignKey' => 'operacao_id',
        ]);
        $this->belongsTo('RegimesAduaneiros', [
            'foreignKey' => 'regime_aduaneiro_id',
        ]);
        $this->belongsTo('Produtos', [
            'foreignKey' => 'produto_id',
        ]);
        $this->belongsTo('DriveEspacoTipos', [
            'foreignKey' => 'drive_espaco_tipo_id',
        ]);
        $this->belongsTo('DriveEspacoClassificacoes', [
            'foreignKey' => 'drive_espaco_classificacao_id',
        ]);
        $this->belongsTo('VistoriaTipos', [
            'foreignKey' => 'vistoria_tipo_id',
        ]);
        $this->belongsTo('OrdemServicoTipos', [
            'foreignKey' => 'ordem_servico_tipo_id',
        ]);
        $this->belongsTo('Servicos', [
            'foreignKey' => 'servico_id',
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
            ->integer('tipo_grade')
            ->requirePresence('tipo_grade', 'create')
            ->notEmptyString('tipo_grade');

        $validator
            ->integer('ativo')
            ->notEmptyString('ativo');

        $validator
            ->date('data_inicio')
            ->requirePresence('data_inicio', 'create')
            ->notEmptyDate('data_inicio');

        $validator
            ->time('hora_inicio')
            ->requirePresence('hora_inicio', 'create')
            ->notEmptyTime('hora_inicio');

        $validator
            ->date('data_fim')
            ->requirePresence('data_fim', 'create')
            ->notEmptyDate('data_fim');

        $validator
            ->time('hora_fim')
            ->requirePresence('hora_fim', 'create')
            ->notEmptyTime('hora_fim');

        $validator
            ->integer('exec_minuto')
            ->allowEmptyString('exec_minuto');

        $validator
            ->integer('exec_hora')
            ->allowEmptyString('exec_hora');

        $validator
            ->allowEmptyString('exec_dia_do_mes');

        $validator
            ->allowEmptyString('exec_mes');

        $validator
            ->allowEmptyString('exec_dia_da_semana');

        $validator
            ->integer('exec_ano_limite')
            ->allowEmptyString('exec_ano_limite');

        $validator
            ->integer('ordem')
            ->requirePresence('ordem', 'create')
            ->notEmptyString('ordem');

        $validator
            ->integer('qtde_veiculos_intervalo')
            ->notEmptyString('qtde_veiculos_intervalo');

        $validator
            ->integer('limite_minutos_antecedencia')
            ->notEmptyString('limite_minutos_antecedencia');

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
        //$rules->add($rules->existsIn(['grade_horario_master_id'], 'GradeHorarios'));
        $rules->add($rules->existsIn(['operacao_id'], 'Operacoes'));
        $rules->add($rules->existsIn(['regime_aduaneiro_id'], 'RegimesAduaneiros'));
        $rules->add($rules->existsIn(['produto_id'], 'Produtos'));
        $rules->add($rules->existsIn(['drive_espaco_tipo_id'], 'DriveEspacoTipos'));
        $rules->add($rules->existsIn(['drive_espaco_classificacao_id'], 'DriveEspacoClassificacoes'));

        return $rules;
    }
}
