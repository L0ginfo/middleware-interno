<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * GradeHorarioLiberacaoTransportadorasFixture
 */
class GradeHorarioLiberacaoTransportadorasFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'grade_horario_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'transportadora_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'inicio' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'fim' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'cadastrado' => ['type' => 'float', 'length' => null, 'precision' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'realizado' => ['type' => 'float', 'length' => null, 'precision' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'estimado' => ['type' => 'float', 'length' => null, 'precision' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'saldo' => ['type' => 'float', 'length' => null, 'precision' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        '_indexes' => [
            'grade_horario_id' => ['type' => 'index', 'columns' => ['grade_horario_id'], 'length' => []],
            'transportadora_id' => ['type' => 'index', 'columns' => ['transportadora_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'grade_horario_liberacao_transportadoras_ibfk_1' => ['type' => 'foreign', 'columns' => ['grade_horario_id'], 'references' => ['grade_horarios', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'grade_horario_liberacao_transportadoras_ibfk_2' => ['type' => 'foreign', 'columns' => ['transportadora_id'], 'references' => ['transportadoras', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
                'grade_horario_id' => 1,
                'transportadora_id' => 1,
                'inicio' => '2021-08-12 10:33:06',
                'fim' => '2021-08-12 10:33:06',
                'cadastrado' => 1,
                'realizado' => 1,
                'estimado' => 1,
                'saldo' => 1,
            ],
        ];
        parent::init();
    }
}
