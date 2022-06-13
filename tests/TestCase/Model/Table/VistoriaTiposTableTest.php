<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\VistoriaTiposTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\VistoriaTiposTable Test Case
 */
class VistoriaTiposTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\VistoriaTiposTable
     */
    public $VistoriaTipos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.VistoriaTipos',
        'app.GradeHorarios',
        'app.Vistorias',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('VistoriaTipos') ? [] : ['className' => VistoriaTiposTable::class];
        $this->VistoriaTipos = TableRegistry::getTableLocator()->get('VistoriaTipos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->VistoriaTipos);

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
