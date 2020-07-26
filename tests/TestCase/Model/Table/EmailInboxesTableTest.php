<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EmailInboxesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EmailInboxesTable Test Case
 */
class EmailInboxesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\EmailInboxesTable
     */
    public $EmailInboxes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.EmailInboxes',
        'app.EmailAttachments',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('EmailInboxes') ? [] : ['className' => EmailInboxesTable::class];
        $this->EmailInboxes = TableRegistry::getTableLocator()->get('EmailInboxes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->EmailInboxes);

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
