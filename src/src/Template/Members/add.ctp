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
<?= $this->Flash->render() ?>
<h2>仮登録画面</h2>
<p>登録するメールアドレスを入力してください</p>
    <?= $this->Form->create($member) ?>
<table class="table">
    <tr>
    <th>メールアドレス</th><td><?= $this->Form->input('email', ['label' => false]) ?></td>
    </tr>
    <tr>
    <th>メールアドレス(確認)</th><td><?= $this->Form->input('email_confirm', ['label' => false]) ?></td>
    </tr>
</table>
    <?= $this->Form->button(__('送信')) ?>
    <?= $this->Form->end() ?>
</main>
