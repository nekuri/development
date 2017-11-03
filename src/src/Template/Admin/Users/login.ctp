<div class="users form">
<?= $this->Flash->render() ?>
<?= $this->Form->create(null, ['class' => 'form-signin']) ?>
    <fieldset>
        <legend><?= __('IDとパスワードを入力してください') ?></legend>
        <?= $this->Form->control('username') ?>
        <?= $this->Form->control('password') ?>
    </fieldset>
<?= $this->Form->button(__('ログイン')); ?>
<?= $this->Form->end() ?>
</div>