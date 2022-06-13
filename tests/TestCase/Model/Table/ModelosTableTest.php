<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ModelosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ModelosTable Test Case
 */
class ModelosTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.modelos',
        'app.containers',
        'app.requerimentos',
        'app.iso_codes',
        'app.tamanhos',
        'app.embalagens',
        'app.carga_gerais',
        'app.codigo_onus'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Modelos') ? [] : ['className' => 'App\Model\Table\ModelosTable'];
        $this->Modelos = TableRegistry::get('Modelos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Modelos);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
