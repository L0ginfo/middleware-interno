<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DirecaoControladorasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DirecaoControladorasTable Test Case
 */
class DirecaoControladorasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DirecaoControladorasTable
     */
    public $DirecaoControladoras;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.DirecaoControladoras',
        'app.ControleAcessoControladoras',
        'app.ControleAcessoLogs',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('DirecaoControladoras') ? [] : ['className' => DirecaoControladorasTable::class];
        $this->DirecaoControladoras = TableRegistry::getTableLocator()->get('DirecaoControladoras', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DirecaoControladoras);

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
