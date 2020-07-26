<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * EmailInbox Entity
 *
 * @property int $id
 * @property int $uid
 * @property string $email_from
 * @property string $email_subject
 * @property \Cake\I18n\FrozenTime $date_recieved
 * @property string $message_body
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\EmailAttachment[] $email_attachments
 */
class EmailInbox extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'uid' => true,
        'email_from' => true,
        'email_subject' => true,
        'date_recieved' => true,
        'message_body' => true,
        'created' => true,
        'modified' => true,
        'email_attachments' => true,
    ];
}
