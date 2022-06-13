<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * DriveEspacosFixture
 */
class DriveEspacosFixture extends TestFixture
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
        'armador_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'conteiner_tamanho_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'tipo_iso_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'operacao_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'qtde_cnt_possivel' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'qtde_carga_geral_possivel' => ['type' => 'decimal', 'length' => 18, 'precision' => 8, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'drive_espaco_classificacao_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'drive_espaco_tipo_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'unidade_medida_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'armador_id' => ['type' => 'index', 'columns' => ['armador_id'], 'length' => []],
            'conteiner_tamanho_id' => ['type' => 'index', 'columns' => ['conteiner_tamanho_id'], 'length' => []],
            'tipo_iso_id' => ['type' => 'index', 'columns' => ['tipo_iso_id'], 'length' => []],
            'operacao_id' => ['type' => 'index', 'columns' => ['operacao_id'], 'length' => []],
            'drive_espaco_classificacao_id' => ['type' => 'index', 'columns' => ['drive_espaco_classificacao_id'], 'length' => []],
            'drive_espaco_tipo_id' => ['type' => 'index', 'columns' => ['drive_espaco_tipo_id'], 'length' => []],
            'unidade_medida_id' => ['type' => 'index', 'columns' => ['unidade_medida_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'drive_espacos_ibfk_1' => ['type' => 'foreign', 'columns' => ['armador_id'], 'references' => ['empresas', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'drive_espacos_ibfk_2' => ['type' => 'foreign', 'columns' => ['conteiner_tamanho_id'], 'references' => ['container_tamanhos', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'drive_espacos_ibfk_3' => ['type' => 'foreign', 'columns' => ['tipo_iso_id'], 'references' => ['tipo_isos', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'drive_espacos_ibfk_4' => ['type' => 'foreign', 'columns' => ['operacao_id'], 'references' => ['operacoes', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'drive_espacos_ibfk_5' => ['type' => 'foreign', 'columns' => ['drive_espaco_classificacao_id'], 'references' => ['drive_espaco_classificacoes', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'drive_espacos_ibfk_6' => ['type' => 'foreign', 'columns' => ['drive_espaco_tipo_id'], 'references' => ['drive_espaco_tipos', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'drive_espacos_ibfk_7' => ['type' => 'foreign', 'columns' => ['unidade_medida_id'], 'references' => ['unidade_medidas', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
                'armador_id' => 1,
                'conteiner_tamanho_id' => 1,
                'tipo_iso_id' => 1,
                'operacao_id' => 1,
                'qtde_cnt_possivel' => 1,
                'qtde_carga_geral_possivel' => 1.5,
                'drive_espaco_classificacao_id' => 1,
                'drive_espaco_tipo_id' => 1,
                'unidade_medida_id' => 1,
            ],
        ];
        parent::init();
    }
}
