<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * FilaIntegracaoFaturamentoBaixasFixture
 */
class FilaIntegracaoFaturamentoBaixasFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'faturamento_baixa_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'faturamento_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'faturamento_armazenagem_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'json_wms_enviado' => ['type' => 'text', 'length' => null, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'json_callback_recebido' => ['type' => 'text', 'length' => null, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'integracao_codigo' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'response_util_title' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'response_util_message' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'response_util_status' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'status_integracao_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'created_at' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => 'CURRENT_TIMESTAMP', 'comment' => '', 'precision' => null],
        'modified_at' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'status_integracao_id' => ['type' => 'index', 'columns' => ['status_integracao_id'], 'length' => []],
            'faturamento_baixa_id' => ['type' => 'index', 'columns' => ['faturamento_baixa_id'], 'length' => []],
            'faturamento_id' => ['type' => 'index', 'columns' => ['faturamento_id'], 'length' => []],
            'faturamento_armazenagem_id' => ['type' => 'index', 'columns' => ['faturamento_armazenagem_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fila_integracao_faturamento_baixas_ibfk_1' => ['type' => 'foreign', 'columns' => ['status_integracao_id'], 'references' => ['status_integracoes', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fila_integracao_faturamento_baixas_ibfk_2' => ['type' => 'foreign', 'columns' => ['faturamento_baixa_id'], 'references' => ['faturamento_baixas', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fila_integracao_faturamento_baixas_ibfk_3' => ['type' => 'foreign', 'columns' => ['faturamento_id'], 'references' => ['faturamentos', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fila_integracao_faturamento_baixas_ibfk_4' => ['type' => 'foreign', 'columns' => ['faturamento_armazenagem_id'], 'references' => ['faturamento_armazenagens', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'faturamento_baixa_id' => 1,
                'faturamento_id' => 1,
                'faturamento_armazenagem_id' => 1,
                'json_wms_enviado' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'json_callback_recebido' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'integracao_codigo' => 'Lorem ipsum dolor sit amet',
                'response_util_title' => 'Lorem ipsum dolor sit amet',
                'response_util_message' => 'Lorem ipsum dolor sit amet',
                'response_util_status' => 'Lorem ipsum dolor sit amet',
                'status_integracao_id' => 1,
                'created_at' => '2021-11-18 15:16:57',
                'modified_at' => '2021-11-18 15:16:57',
            ],
        ];
        parent::init();
    }
}
