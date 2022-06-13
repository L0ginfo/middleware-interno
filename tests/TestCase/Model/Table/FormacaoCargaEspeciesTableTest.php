<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FormacaoCargaEspeciesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FormacaoCargaEspeciesTable Test Case
 */
class FormacaoCargaEspeciesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\FormacaoCargaEspeciesTable
     */
    public $FormacaoCargaEspecies;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.FormacaoCargaEspecies',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('FormacaoCargaEspecies') ? [] : ['className' => FormacaoCargaEspeciesTable::class];
        $this->FormacaoCargaEspecies = TableRegistry::getTableLocator()->get('FormacaoCargaEspecies', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->FormacaoCargaEspecies);

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
