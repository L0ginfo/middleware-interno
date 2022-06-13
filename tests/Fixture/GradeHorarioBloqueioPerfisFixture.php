<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * GradeHorarioBloqueioPerfisFixture
 */
class GradeHorarioBloqueioPerfisFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 10, 'autoIncrement' => true, 'null' => false, 'default' => null, 'precision' => null, 'comment' => null, 'unsigned' => null],
        'grade_horario_id' => ['type' => 'integer', 'length' => 10, 'null' => false, 'default' => null, 'precision' => null, 'comment' => null, 'unsigned' => null, 'autoIncrement' => null],
        'perfil_id' => ['type' => 'integer', 'length' => 10, 'null' => false, 'default' => null, 'precision' => null, 'comment' => null, 'unsigned' => null, 'autoIncrement' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'grade_horario_bloqueio_perfis_grade_horario_id' => ['type' => 'foreign', 'columns' => ['grade_horario_id'], 'references' => ['grade_horarios', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'grade_horario_bloqueio_perfis_perfil_id' => ['type' => 'foreign', 'columns' => ['perfil_id'], 'references' => ['perfis', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'perfil_id' => 1,
            ],
        ];
        parent::init();
    }
}
