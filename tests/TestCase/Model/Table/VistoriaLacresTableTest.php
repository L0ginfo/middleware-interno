<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\VistoriaLacresTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\VistoriaLacresTable Test Case
 */
class VistoriaLacresTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\VistoriaLacresTable
     */
    public $VistoriaLacres;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.VistoriaLacres',
        'app.LacreTipos',
        'app.Vistorias',
        'app.VistoriaItens',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('VistoriaLacres') ? [] : ['className' => VistoriaLacresTable::class];
        $this->VistoriaLacres = TableRegistry::getTableLocator()->get('VistoriaLacres', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->VistoriaLacres);

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

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
