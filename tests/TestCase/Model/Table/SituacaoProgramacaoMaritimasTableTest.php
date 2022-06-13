<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SituacaoProgramacaoMaritimasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SituacaoProgramacaoMaritimasTable Test Case
 */
class SituacaoProgramacaoMaritimasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\SituacaoProgramacaoMaritimasTable
     */
    public $SituacaoProgramacaoMaritimas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.SituacaoProgramacaoMaritimas'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('SituacaoProgramacaoMaritimas') ? [] : ['className' => SituacaoProgramacaoMaritimasTable::class];
        $this->SituacaoProgramacaoMaritimas = TableRegistry::getTableLocator()->get('SituacaoProgramacaoMaritimas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->SituacaoProgramacaoMaritimas);

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
