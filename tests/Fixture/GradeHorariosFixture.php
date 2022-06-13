<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * GradeHorariosFixture
 */
class GradeHorariosFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'descricao' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'tipo_grade' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '0 = Master, 1 = Liberação, 2 = Bloqueio', 'precision' => null, 'autoIncrement' => null],
        'ativo' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'data_inicio' => ['type' => 'date', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'hora_inicio' => ['type' => 'time', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'data_fim' => ['type' => 'date', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'hora_fim' => ['type' => 'time', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'exec_minuto' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'exec_hora' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'exec_dia_do_mes' => ['type' => 'json', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'exec_mes' => ['type' => 'json', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'exec_dia_da_semana' => ['type' => 'json', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'exec_ano_limite' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'ordem' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'qtde_veiculos_intervalo' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'limite_minutos_antecedencia' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'grade_horario_master_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'operacao_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'regime_aduaneiro_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'produto_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'drive_espaco_tipo_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => 'Tipo de Carga', 'precision' => null, 'autoIncrement' => null],
        'drive_espaco_classificacao_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => 'Classificação da Carga', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'operacao_id' => ['type' => 'index', 'columns' => ['operacao_id'], 'length' => []],
            'regime_aduaneiro_id' => ['type' => 'index', 'columns' => ['regime_aduaneiro_id'], 'length' => []],
            'produto_id' => ['type' => 'index', 'columns' => ['produto_id'], 'length' => []],
            'drive_espaco_tipo_id' => ['type' => 'index', 'columns' => ['drive_espaco_tipo_id'], 'length' => []],
            'drive_espaco_classificacao_id' => ['type' => 'index', 'columns' => ['drive_espaco_classificacao_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'grade_horarios_ibfk_1' => ['type' => 'foreign', 'columns' => ['operacao_id'], 'references' => ['operacoes', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'grade_horarios_ibfk_2' => ['type' => 'foreign', 'columns' => ['regime_aduaneiro_id'], 'references' => ['regimes_aduaneiros', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'grade_horarios_ibfk_3' => ['type' => 'foreign', 'columns' => ['produto_id'], 'references' => ['produtos', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'grade_horarios_ibfk_4' => ['type' => 'foreign', 'columns' => ['drive_espaco_tipo_id'], 'references' => ['drive_espaco_tipos', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'grade_horarios_ibfk_5' => ['type' => 'foreign', 'columns' => ['drive_espaco_classificacao_id'], 'references' => ['drive_espaco_classificacoes', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd
    /**
     * Init method
     *
     * @return void
     */
    public function init()
    {
        $this->records = [
            [
                'id' => 1,
                'descricao' => 'Lorem ipsum dolor sit amet',
                'tipo_grade' => 1,
                'ativo' => 1,
                'data_inicio' => '2021-02-05',
                'hora_inicio' => '18:05:30',
                'data_fim' => '2021-02-05',
                'hora_fim' => '18:05:30',
                'exec_minuto' => 1,
                'exec_hora' => 1,
                'exec_dia_do_mes' => '',
                'exec_mes' => '',
                'exec_dia_da_semana' => '',
                'exec_ano_limite' => 1,
                'ordem' => 1,
                'qtde_veiculos_intervalo' => 1,
                'limite_minutos_antecedencia' => 1,
                'grade_horario_master_id' => 1,
                'operacao_id' => 1,
                'regime_aduaneiro_id' => 1,
                'produto_id' => 1,
                'drive_espaco_tipo_id' => 1,
                'drive_espaco_classificacao_id' => 1,
            ],
        ];
        parent::init();
    }
}
