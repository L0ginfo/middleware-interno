<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RecintoAduaneirosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RecintoAduaneirosTable Test Case
 */
class RecintoAduaneirosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\RecintoAduaneirosTable
     */
    public $RecintoAduaneiros;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.RecintoAduaneiros',
        'app.LiberacoesDocumentais',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('RecintoAduaneiros') ? [] : ['className' => RecintoAduaneirosTable::class];
        $this->RecintoAduaneiros = TableRegistry::getTableLocator()->get('RecintoAduaneiros', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->RecintoAduaneiros);

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
