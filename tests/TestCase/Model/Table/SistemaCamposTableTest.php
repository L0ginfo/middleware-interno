<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SistemaCamposTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SistemaCamposTable Test Case
 */
class SistemaCamposTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\SistemaCamposTable
     */
    public $SistemaCampos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.SistemaCampos'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('SistemaCampos') ? [] : ['className' => SistemaCamposTable::class];
        $this->SistemaCampos = TableRegistry::getTableLocator()->get('SistemaCampos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->SistemaCampos);

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
