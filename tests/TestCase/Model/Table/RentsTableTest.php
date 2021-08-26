<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RentsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RentsTable Test Case
 */
class RentsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\RentsTable
     */
    public $Rents;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Rents',
        'app.Users',
        'app.Books',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Rents') ? [] : ['className' => RentsTable::class];
        $this->Rents = TableRegistry::getTableLocator()->get('Rents', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Rents);

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
