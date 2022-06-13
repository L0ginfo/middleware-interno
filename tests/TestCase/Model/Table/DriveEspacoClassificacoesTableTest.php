<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DriveEspacoClassificacoesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DriveEspacoClassificacoesTable Test Case
 */
class DriveEspacoClassificacoesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DriveEspacoClassificacoesTable
     */
    public $DriveEspacoClassificacoes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.DriveEspacoClassificacoes',
        'app.DriveEspacos',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('DriveEspacoClassificacoes') ? [] : ['className' => DriveEspacoClassificacoesTable::class];
        $this->DriveEspacoClassificacoes = TableRegistry::getTableLocator()->get('DriveEspacoClassificacoes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DriveEspacoClassificacoes);

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
