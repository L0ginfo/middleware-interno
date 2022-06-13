<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EnderecoMedicaoDadosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EnderecoMedicaoDadosTable Test Case
 */
class EnderecoMedicaoDadosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\EnderecoMedicaoDadosTable
     */
    public $EnderecoMedicaoDados;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.EnderecoMedicaoDados',
        'app.EnderecoMedicoes',
        'app.Enderecos',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('EnderecoMedicaoDados') ? [] : ['className' => EnderecoMedicaoDadosTable::class];
        $this->EnderecoMedicaoDados = TableRegistry::getTableLocator()->get('EnderecoMedicaoDados', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->EnderecoMedicaoDados);

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

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
