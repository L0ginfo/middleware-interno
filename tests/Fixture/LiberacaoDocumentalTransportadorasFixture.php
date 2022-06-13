<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * LiberacaoDocumentalTransportadorasFixture
 */
class LiberacaoDocumentalTransportadorasFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'transportadora_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'liberacao_documental_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'data_fim_retirada' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'data_inicio_retirada' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'tolerancia' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'numero_pedido' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'created_at' => ['type' => 'timestamp', 'length' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => '', 'precision' => null],
        'updated_at' => ['type' => 'timestamp', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'transportadora_id' => ['type' => 'index', 'columns' => ['transportadora_id'], 'length' => []],
            'liberacao_documental_id' => ['type' => 'index', 'columns' => ['liberacao_documental_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'liberacao_documental_transportadoras_ibfk_1' => ['type' => 'foreign', 'columns' => ['transportadora_id'], 'references' => ['transportadoras', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'liberacao_documental_transportadoras_ibfk_2' => ['type' => 'foreign', 'columns' => ['liberacao_documental_id'], 'references' => ['liberacoes_documentais', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
                'transportadora_id' => 1,
                'liberacao_documental_id' => 1,
                'data_fim_retirada' => '2020-12-24 16:08:20',
                'data_inicio_retirada' => '2020-12-24 16:08:20',
                'tolerancia' => 'Lorem ipsum dolor sit amet',
                'numero_pedido' => 'Lorem ipsum dolor sit amet',
                'created_at' => 1608836900,
                'updated_at' => 1608836900,
            ],
        ];
        parent::init();
    }
}
