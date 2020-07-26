<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EmailSettingsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EmailSettingsTable Test Case
 */
class EmailSettingsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\EmailSettingsTable
     */
    public $EmailSettings;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.EmailSettings',
        'app.Emails',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('EmailSettings') ? [] : ['className' => EmailSettingsTable::class];
        $this->EmailSettings = TableRegistry::getTableLocator()->get('EmailSettings', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->EmailSettings);

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
