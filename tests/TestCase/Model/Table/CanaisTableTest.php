<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CanaisTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CanaisTable Test Case
 */
class CanaisTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CanaisTable
     */
    public $Canais;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Canais',
        'app.LiberacoesDocumentais'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Canais') ? [] : ['className' => CanaisTable::class];
        $this->Canais = TableRegistry::getTableLocator()->get('Canais', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Canais);

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
