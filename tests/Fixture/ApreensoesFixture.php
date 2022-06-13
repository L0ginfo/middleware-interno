<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ApreensoesFixture
 */
class ApreensoesFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'documento_mercadoria_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'empresa_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'fiscal_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'tipo_doc_apeend_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'numero_doc_apreend' => ['type' => 'string', 'length' => 45, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'data_apreensao' => ['type' => 'date', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'data_liberacao' => ['type' => 'date', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'observacao' => ['type' => 'binary', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'documento_mercadoria_id' => ['type' => 'index', 'columns' => ['documento_mercadoria_id'], 'length' => []],
            'empresa_id' => ['type' => 'index', 'columns' => ['empresa_id'], 'length' => []],
            'fiscal_id' => ['type' => 'index', 'columns' => ['fiscal_id'], 'length' => []],
            'tipo_doc_apeend_id' => ['type' => 'index', 'columns' => ['tipo_doc_apeend_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'apreensoes_ibfk_1' => ['type' => 'foreign', 'columns' => ['documento_mercadoria_id'], 'references' => ['documentos_mercadorias', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'apreensoes_ibfk_2' => ['type' => 'foreign', 'columns' => ['empresa_id'], 'references' => ['empresas', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'apreensoes_ibfk_3' => ['type' => 'foreign', 'columns' => ['fiscal_id'], 'references' => ['aftns', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'apreensoes_ibfk_4' => ['type' => 'foreign', 'columns' => ['tipo_doc_apeend_id'], 'references' => ['tipo_documentos', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'documento_mercadoria_id' => 1,
                'empresa_id' => 1,
                'fiscal_id' => 1,
                'tipo_doc_apeend_id' => 1,
                'numero_doc_apreend' => 'Lorem ipsum dolor sit amet',
                'data_apreensao' => '2019-11-12',
                'data_liberacao' => '2019-11-12',
                'observacao' => 'Lorem ipsum dolor sit amet'
            ],
        ];
        parent::init();
    }
}
