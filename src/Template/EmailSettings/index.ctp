<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EmailSetting $emailSetting
 */
?>

<div class="emailSettings form large-9 medium-8 columns content">
    <?= $this->Form->create($emailSetting) ?>
    <fieldset>
        <legend><?= __('Edit Email Setting') ?></legend>
        <?php
            echo $this->Form->control('email');
            echo $this->Form->control('password',['type' => 'text']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
