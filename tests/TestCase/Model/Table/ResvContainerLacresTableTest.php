<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ResvContainerLacresTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ResvContainerLacresTable Test Case
 */
class ResvContainerLacresTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ResvContainerLacresTable
     */
    public $ResvContainerLacres;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ResvContainerLacres',
        'app.LacreTipos',
        'app.ResvsContainers',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ResvContainerLacres') ? [] : ['className' => ResvContainerLacresTable::class];
        $this->ResvContainerLacres = TableRegistry::getTableLocator()->get('ResvContainerLacres', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ResvContainerLacres);

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
