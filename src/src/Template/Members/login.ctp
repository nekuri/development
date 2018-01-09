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
    <?= $this->Form->create('Member', ['novalidate' => true]) ?>
    <h2>ログイン画面</h2>
    <table class="table">
    <tr>
        <th>メールアドレス</th><td><?= $this->Form->input('email', ['type' => 'text', 'label' => false]) ?></td>
    </tr>
    <tr>
        <th>パスワード</th><td><?= $this->Form->input('password', ['type' => 'password', 'label' => false]) ?></td>
    </tr>
    </table>
    <?= $this->Form->button(__('ログイン'), ['class' => 'btn btn-success']) ?>
    <?= $this->Form->end() ?>
</main>
