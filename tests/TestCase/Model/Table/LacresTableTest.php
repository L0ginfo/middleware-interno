<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LacresTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LacresTable Test Case
 */
class LacresTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\LacresTable
     */
    public $Lacres;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Lacres',
        'app.Resvs',
        'app.OrdemServicos',
        'app.Containers',
        'app.DocumentosTransportes',
        'app.LacreTipos',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Lacres') ? [] : ['className' => LacresTable::class];
        $this->Lacres = TableRegistry::getTableLocator()->get('Lacres', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Lacres);

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
