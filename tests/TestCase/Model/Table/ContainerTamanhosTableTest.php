<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ContainerTamanhosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ContainerTamanhosTable Test Case
 */
class ContainerTamanhosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ContainerTamanhosTable
     */
    public $ContainerTamanhos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ContainerTamanhos',
        'app.TipoIsos',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ContainerTamanhos') ? [] : ['className' => ContainerTamanhosTable::class];
        $this->ContainerTamanhos = TableRegistry::getTableLocator()->get('ContainerTamanhos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ContainerTamanhos);

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
