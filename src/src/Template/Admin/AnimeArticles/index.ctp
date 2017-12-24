<?php
/**
 * @var \App\View\AppView $this
 */
?>
<nav class="col-sm-3 col-md-2 d-none d-sm-block bg-light sidebar">
    <ul class="nav nav-pills flex-column">
        <li class="nav-item"><?= $this->Html->link(__('アカウント管理'), ['controller' => 'users', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
        <li class="nav-item"><?= $this->Html->link(__('ログアウト'), ['controller' => 'users', 'action' => 'logout'], ['class' => 'nav-link']) ?></li>
    </ul>
</nav>
<main role="main" class="col-sm-9 ml-sm-auto col-md-10 pt-3">
    <h3><?= __('アニメ一覧 画像設定') ?></h3>
    <div class="card">
        <h4 class="card-header">アニメを探す</h4>
        <div class="card-body">
            <?= $this->Form->create(null, ['type' => 'get', 'novalidate' => true]) ?>
        <table>
        <tr>
        <th>タイトル</th><td><?= $this->Form->input('title', ['type' => 'text', 'label' => false]) ?></td>
        </tr>
        </table>
            <?= $this->Form->button('検索', ['type' => 'submit', 'class' => 'btn btn-primary']) ?>
            <?= $this->Form->end(); ?>
        </div>
    </div>
<?php if (empty($animes)) : ?>
<div class="alert alert-warning mt-3" role="alert">
アニメが見つかりませんでした。
</div>
<?php else : ?>
<table class="table table-striped">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('タイトル') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($animes as $anime): ?>
            <tr>
                <td><?= $this->Html->link($anime->title, ['action' => 'image', $anime->api_id]) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<<') ?>
            <?= $this->Paginator->prev('<') ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next('>') ?>
            <?= $this->Paginator->last('>>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
<?php endif; ?>
</main>
