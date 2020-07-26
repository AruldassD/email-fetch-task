<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * EmailInboxes Controller
 *
 * @property \App\Model\Table\EmailInboxesTable $EmailInboxes
 *
 * @method \App\Model\Entity\EmailInbox[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EmailInboxesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $emailInboxes = $this->paginate($this->EmailInboxes);

        $this->set(compact('emailInboxes'));
    }

    /**
     * View method
     *
     * @param string|null $id Email Inbox id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $emailInbox = $this->EmailInboxes->get($id, [
            'contain' => ['EmailAttachments'],
        ]);

        $this->set('emailInbox', $emailInbox);
    }

 

}
