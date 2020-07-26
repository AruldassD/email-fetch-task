<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EmailInbox $emailInbox
 */
?>

<div class="emailInboxes view large-12 medium-12 columns content">
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Email From') ?></th>
            <td><?= h($emailInbox->email_from) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($emailInbox->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Uid') ?></th>
            <td><?= $this->Number->format($emailInbox->uid) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Date Recieved') ?></th>
            <td><?= h($emailInbox->date_recieved) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Email Subject') ?></h4>
        <?= $this->Text->autoParagraph(h($emailInbox->email_subject)); ?>
    </div>
    <div class="row">
        <h4><?= __('Message Body') ?></h4>
        <?php echo $emailInbox->message_body; ?>

    </div>
    <div class="related">
        <h4><?= __('Related Email Attachments') ?></h4>
        <?php if (!empty($emailInbox->email_attachments)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Attachment') ?></th>
            </tr>
            <?php foreach ($emailInbox->email_attachments as $emailAttachments): ?>
            <tr>
                <td><?= h($emailAttachments->id) ?></td>
                <td><?= h($emailAttachments->attachment) ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
