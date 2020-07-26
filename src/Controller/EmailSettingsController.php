<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * EmailSettings Controller
 *
 * @property \App\Model\Table\EmailSettingsTable $EmailSettings
 *
 * @method \App\Model\Entity\EmailSetting[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EmailSettingsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $emailSetting = $this->EmailSettings->get(1, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $emailSetting = $this->EmailSettings->patchEntity($emailSetting, $this->request->getData());
            if ($this->EmailSettings->save($emailSetting)) {
                $this->Flash->success(__('The email setting has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The email setting could not be saved. Please, try again.'));
        }
        $this->set(compact('emailSetting'));
    }



}
