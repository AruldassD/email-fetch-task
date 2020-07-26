<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EmailAttachmentsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EmailAttachmentsTable Test Case
 */
class EmailAttachmentsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\EmailAttachmentsTable
     */
    public $EmailAttachments;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.EmailAttachments',
        'app.EmailInboxes',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('EmailAttachments') ? [] : ['className' => EmailAttachmentsTable::class];
        $this->EmailAttachments = TableRegistry::getTableLocator()->get('EmailAttachments', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->EmailAttachments);

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
