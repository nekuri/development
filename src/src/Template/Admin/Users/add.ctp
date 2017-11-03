<?php
/**
 * @var \App\View\AppView $this
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Users'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create($user, ['novalidate' => true]) ?>
    <fieldset>
        <legend><?= __('管理者 新規登録') ?></legend>
        <b>ユーザー名</b>
        <?= $this->Form->input('username', ['label' => false]); ?>
        <b>パスワード</b>
        <?= $this->Form->input('password', ['type' => 'password', 'label' => false]); ?>
        <b>権限</b>
        <?= $this->Form->input('role', [
                                    'type' => 'select',
                                    'options' => [
                                        'admin' => 'admin',
                                        'user' => 'user'
                                    ],
                                    'label' => false

                                ]
        );?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
