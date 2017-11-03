<?php
/**
 * @var \App\View\AppView $this
 */
?>
<nav class="col-sm-3 col-md-2 d-none d-sm-block bg-light sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('アニメ一覧'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('アカウント管理'), ['controller' => 'users', 'action' => 'index']) ?></li>
    </ul>
</nav>
<main role="main" class="col-sm-9 ml-sm-auto col-md-10 pt-3">
<?= h($anime->title) ?>
    <?= $this->Form->create('Anime', ['type' => 'file']) ?>
    <fieldset>
        <legend><?= __('画像を追加') ?></legend>
        <?php if (isset($anime->photo)) : ?>
        <?= $this->Html->image('files' . '/' . $anime->api_id . '/' . $anime->photo, [
                'width' => '350',
                'height' => '350'
        ]) ?>
        <?php else : ?>
        <?= $this->Html->image('noimage.png', [
            'width' => '350',
            'height' => '350'
        ]) ?>
        <?php endif; ?>
        <?= $this->Form->input('photo', ['type' => 'file', 'label' => false]) ?>
        <?php if (isset($errors)) : ?>
            <?php foreach ($errors as $error) : ?>
                <?= h($error) ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </fieldset>
    <?= $this->Form->button(__('送信'), ['class' => 'btn btn-primary']) ?>
    <?= $this->Form->end() ?>
</main>
