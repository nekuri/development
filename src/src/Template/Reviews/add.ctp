<?php
/**
 * @var \App\View\AppView $this
 */
?>
<nav class="col-sm-3 col-md-2 d-none d-sm-block bg-light sidebar">
    <ul class="nav nav-pills flex-column">
        <li class="nav-item"><?= $this->Html->link(__('アニメの詳細に戻る'), ['controller' => 'animes', 'action' => 'view', $id], ['class' => 'nav-link']) ?></li>
        <li class="nav-item"><?= $this->Html->link(__('アニメ一覧'), ['controller' => 'Animes', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
    </ul>
</nav>
<main role="main" class="col-sm-9 ml-sm-auto col-md-10 pt-3">
<?= $this->Flash->render() ?>
    <?= $this->Form->create($review, ['novalidate' => true]) ?>
    <fieldset>
        <legend><?= __('レビューを書く') ?></legend>
        <b>タイトル</b>
        <?= $this->Form->input('title', ['label' => false]) ?>
        <b>内容</b>
        <?= $this->Form->input('body', ['type' => 'textarea', 'label' => false]) ?>
        <b>評価</b>
        <?= $this->Form->input('evalution', ['type' => 'select', 'options' => $stars, 'label' => false]) ?>
    </fieldset>
    <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']) ?>
    <?= $this->Form->end() ?>
</main>
