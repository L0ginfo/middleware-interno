<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ModaisTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ModaisTable Test Case
 */
class ModaisTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ModaisTable
     */
    public $Modais;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Modais',
        'app.DocumentosMercadorias',
        'app.DocumentosTransportes',
        'app.Portarias',
        'app.Resvs'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Modais') ? [] : ['className' => ModaisTable::class];
        $this->Modais = TableRegistry::getTableLocator()->get('Modais', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Modais);

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
