<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RegimesAduaneirosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RegimesAduaneirosTable Test Case
 */
class RegimesAduaneirosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\RegimesAduaneirosTable
     */
    public $RegimesAduaneiros;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.RegimesAduaneiros',
        'app.DocumentosMercadorias'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('RegimesAduaneiros') ? [] : ['className' => RegimesAduaneirosTable::class];
        $this->RegimesAduaneiros = TableRegistry::getTableLocator()->get('RegimesAduaneiros', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->RegimesAduaneiros);

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
