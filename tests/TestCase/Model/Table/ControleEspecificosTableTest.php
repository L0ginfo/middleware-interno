<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ControleEspecificosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ControleEspecificosTable Test Case
 */
class ControleEspecificosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ControleEspecificosTable
     */
    public $ControleEspecificos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ControleEspecificos',
        'app.DocumentoMercadoriaItemControleEspecificos',
        'app.OrdemServicoCarregamentos',
        'app.OrdemServicoItens',
        'app.ProdutoControleEspecificos',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ControleEspecificos') ? [] : ['className' => ControleEspecificosTable::class];
        $this->ControleEspecificos = TableRegistry::getTableLocator()->get('ControleEspecificos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ControleEspecificos);

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
