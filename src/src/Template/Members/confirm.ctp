<?php
$action = $this->request->action;
?>
<nav class="col-sm-3 col-md-2 d-none d-sm-block bg-light sidebar">
    <ul class="nav nav-pills flex-column">
        <li class="nav-item">&nbsp;</li>
    </ul>
</nav>
<main role="main" class="col-sm-9 ml-sm-auto col-md-10 pt-3">
    <?= $this->Form->create($member) ?>
    <h2>確認画面</h2>
    <table class="table table-striped">
    <tr>
        <th>名前</th><td><?= h($member->name) ?></td>
    </tr>
    <tr>
        <th>メールアドレス</th><td><?= h($member->email) ?></td>
    </tr>
    <tr>
        <th>秘密の質問</th><td><?= h($member->secret_question) ?></td>
    </tr>
    </table>
    <?= $this->Form->button(__('登録'), ['class' => 'btn btn-primary']) ?>
    <?= $this->Html->link('戻る', ['action' => 'formal'], ['class' => 'btn btn-outline-info']) ?>
    <?= $this->Form->end() ?>
</main>
