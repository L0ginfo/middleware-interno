<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\IsoCodesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\IsoCodesTable Test Case
 */
class IsoCodesTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.iso_codes',
        'app.containers',
        'app.entradas',
        'app.tamanhos',
        'app.modelos',
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
        $config = TableRegistry::exists('IsoCodes') ? [] : ['className' => 'App\Model\Table\IsoCodesTable'];
        $this->IsoCodes = TableRegistry::get('IsoCodes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->IsoCodes);

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
