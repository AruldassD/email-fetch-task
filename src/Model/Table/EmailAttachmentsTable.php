<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EmailAttachments Model
 *
 * @property \App\Model\Table\EmailInboxesTable&\Cake\ORM\Association\BelongsTo $EmailInboxes
 *
 * @method \App\Model\Entity\EmailAttachment get($primaryKey, $options = [])
 * @method \App\Model\Entity\EmailAttachment newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\EmailAttachment[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EmailAttachment|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EmailAttachment saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EmailAttachment patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\EmailAttachment[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\EmailAttachment findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class EmailAttachmentsTable extends Table
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

        $this->setTable('email_attachments');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('EmailInboxes', [
            'foreignKey' => 'email_inbox_id',
            'joinType' => 'INNER',
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
            ->scalar('attachment')
            ->maxLength('attachment', 255)
            ->requirePresence('attachment', 'create')
            ->notEmptyString('attachment');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['email_inbox_id'], 'EmailInboxes'));

        return $rules;
    }
}
