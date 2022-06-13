<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AnexoTipoGruposTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AnexoTipoGruposTable Test Case
 */
class AnexoTipoGruposTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AnexoTipoGruposTable
     */
    public $AnexoTipoGrupos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.AnexoTipoGrupos',
        'app.AnexoSituacoes',
        'app.AnexoTipos',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('AnexoTipoGrupos') ? [] : ['className' => AnexoTipoGruposTable::class];
        $this->AnexoTipoGrupos = TableRegistry::getTableLocator()->get('AnexoTipoGrupos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->AnexoTipoGrupos);

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
