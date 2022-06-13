<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RegimeAduaneiroTipoFaturamentosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RegimeAduaneiroTipoFaturamentosTable Test Case
 */
class RegimeAduaneiroTipoFaturamentosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\RegimeAduaneiroTipoFaturamentosTable
     */
    public $RegimeAduaneiroTipoFaturamentos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.RegimeAduaneiroTipoFaturamentos',
        'app.RegimesAduaneiros',
        'app.TiposFaturamentos'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('RegimeAduaneiroTipoFaturamentos') ? [] : ['className' => RegimeAduaneiroTipoFaturamentosTable::class];
        $this->RegimeAduaneiroTipoFaturamentos = TableRegistry::getTableLocator()->get('RegimeAduaneiroTipoFaturamentos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->RegimeAduaneiroTipoFaturamentos);

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
