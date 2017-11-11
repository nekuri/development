<?php
/**
 * @var \App\View\AppView $this
 */
?>
<nav class="col-sm-3 col-md-2 d-none d-sm-block bg-light sidebar">
    <ul class="nav nav-pills flex-column">
        <li class="nav-item"><?= $this->Html->link(__('アニメ一覧'), ['controller' => 'Animes', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
    </ul>
</nav>
<main role="main" class="col-sm-9 ml-sm-auto col-md-10 pt-3">
<?= $this->Flash->render(); ?>
    <?= $this->Form->create($member, ['novalidate' => true]) ?>
    <h2>本登録画面</h2>
    <table class="table">
    <tr>
        <th>名前</th><td><?= $this->Form->input('name', ['type' => 'text', 'label' => false]) ?></td>
    </tr>
    <tr>
        <th>パスワード</th><td><?= $this->Form->input('password', ['type' => 'password', 'label' => false]) ?></td>
    </tr>
    <tr>
        <th>パスワード（確認）</th><td><?= $this->Form->input('password_confirm', ['type' => 'password', 'label' => false]) ?></td>
    </tr>
    <tr>
        <th>秘密の質問</th><td><?= $this->Form->input('secret_kind', ['type' => 'select', 'label' => false, 'options' => [0 => '飼っていたペットの名前', 1 => '好きな食べ物', 2 => 'おばあちゃんの名前']]) ?>
        <br><?= $this->Form->input('secret_question', ['type' => 'text', 'label' => false]) ?></td>
    </tr>
    </table>
    <?= $this->Form->button(__('確認')) ?>
    <?= $this->Form->end() ?>
</main>
