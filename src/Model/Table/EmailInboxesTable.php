<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EmailInboxes Model
 *
 * @property \App\Model\Table\EmailAttachmentsTable&\Cake\ORM\Association\HasMany $EmailAttachments
 *
 * @method \App\Model\Entity\EmailInbox get($primaryKey, $options = [])
 * @method \App\Model\Entity\EmailInbox newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\EmailInbox[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EmailInbox|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EmailInbox saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EmailInbox patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\EmailInbox[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\EmailInbox findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class EmailInboxesTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('email_inboxes');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('EmailAttachments', [
            'foreignKey' => 'email_inbox_id',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->integer('uid')
            ->requirePresence('uid', 'create')
            ->notEmptyString('uid');

        $validator
            ->scalar('email_from')
            ->maxLength('email_from', 255)
            ->requirePresence('email_from', 'create')
            ->notEmptyString('email_from');

        $validator
            ->scalar('email_subject')
            ->requirePresence('email_subject', 'create')
            ->notEmptyString('email_subject');

        $validator
            ->dateTime('date_recieved')
            ->requirePresence('date_recieved', 'create')
            ->notEmptyDateTime('date_recieved');

        $validator
            ->scalar('message_body')
            ->requirePresence('message_body', 'create')
            ->notEmptyString('message_body');

        return $validator;
    }
}
