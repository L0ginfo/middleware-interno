<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MotivoAcessosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MotivoAcessosTable Test Case
 */
class MotivoAcessosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MotivoAcessosTable
     */
    public $MotivoAcessos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.MotivoAcessos',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('MotivoAcessos') ? [] : ['className' => MotivoAcessosTable::class];
        $this->MotivoAcessos = TableRegistry::getTableLocator()->get('MotivoAcessos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MotivoAcessos);

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
