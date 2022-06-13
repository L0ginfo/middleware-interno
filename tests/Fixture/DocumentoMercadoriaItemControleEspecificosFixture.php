<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * DocumentoMercadoriaItemControleEspecificosFixture
 */
class DocumentoMercadoriaItemControleEspecificosFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'controle_especifico_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'documento_mercadoria_item_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'controle_especifico_id' => ['type' => 'index', 'columns' => ['controle_especifico_id'], 'length' => []],
            'documento_mercadoria_item_id' => ['type' => 'index', 'columns' => ['documento_mercadoria_item_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'documento_mercadoria_item_controle_especificos_ibfk_1' => ['type' => 'foreign', 'columns' => ['controle_especifico_id'], 'references' => ['controle_especificos', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'documento_mercadoria_item_controle_especificos_ibfk_2' => ['type' => 'foreign', 'columns' => ['documento_mercadoria_item_id'], 'references' => ['documentos_mercadorias_itens', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
                'controle_especifico_id' => 1,
                'documento_mercadoria_item_id' => 1,
            ],
        ];
        parent::init();
    }
}
