<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EmbalagensTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EmbalagensTable Test Case
 */
class EmbalagensTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\EmbalagensTable
     */
    public $Embalagens;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Embalagens',
        'app.OrdemServicoItens'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Embalagens') ? [] : ['className' => EmbalagensTable::class];
        $this->Embalagens = TableRegistry::getTableLocator()->get('Embalagens', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Embalagens);

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
