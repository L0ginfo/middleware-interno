<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OrdemServicoLacresTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OrdemServicoLacresTable Test Case
 */
class OrdemServicoLacresTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\OrdemServicoLacresTable
     */
    public $OrdemServicoLacres;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.OrdemServicoLacres',
        'app.OrdemServicos',
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
        $config = TableRegistry::getTableLocator()->exists('OrdemServicoLacres') ? [] : ['className' => OrdemServicoLacresTable::class];
        $this->OrdemServicoLacres = TableRegistry::getTableLocator()->get('OrdemServicoLacres', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->OrdemServicoLacres);

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
