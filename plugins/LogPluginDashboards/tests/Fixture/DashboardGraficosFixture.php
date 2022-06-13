<?php
namespace LogPluginDashboards\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * DashboardGraficosFixture
 */
class DashboardGraficosFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'ordem' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'responsive_options' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'consulta_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'dashboard_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'dashboard_grafico_tipo_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'consulta_id' => ['type' => 'index', 'columns' => ['consulta_id'], 'length' => []],
            'dashboard_id' => ['type' => 'index', 'columns' => ['dashboard_id'], 'length' => []],
            'dashboard_grafico_tipo_id' => ['type' => 'index', 'columns' => ['dashboard_grafico_tipo_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'dashboard_graficos_ibfk_1' => ['type' => 'foreign', 'columns' => ['consulta_id'], 'references' => ['consultas', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'dashboard_graficos_ibfk_2' => ['type' => 'foreign', 'columns' => ['dashboard_id'], 'references' => ['dashboards', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'dashboard_graficos_ibfk_3' => ['type' => 'foreign', 'columns' => ['dashboard_grafico_tipo_id'], 'references' => ['dashboard_grafico_tipos', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
                'ordem' => 1,
                'responsive_options' => 'Lorem ipsum dolor sit amet',
                'consulta_id' => 1,
                'dashboard_id' => 1,
                'dashboard_grafico_tipo_id' => 1,
            ],
        ];
        parent::init();
    }
}
