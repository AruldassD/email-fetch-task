<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EmailInbox[]|\Cake\Collection\CollectionInterface $emailInboxes
 */
?>

<div class="emailInboxes index large-12 medium-12 columns content">
    <h3><?= __('Email Inboxes') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('email_from') ?></th>
                <th scope="col"><?= $this->Paginator->sort('email_subject') ?></th>
                <th scope="col"><?= $this->Paginator->sort('date_recieved') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($emailInboxes as $emailInbox): ?>
            <tr>
                <td><?= $this->Number->format($emailInbox->id) ?></td>
                <td><?= h($emailInbox->email_from) ?></td>
                <td><?= h($emailInbox->email_subject) ?></td>
                <td><?= h($emailInbox->date_recieved) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $emailInbox->id]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
