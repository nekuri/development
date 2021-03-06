<?php
/**
 * @var \App\View\AppView $this
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Animes'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Reviews'), ['controller' => 'Reviews', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Review'), ['controller' => 'Reviews', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="animes form large-9 medium-8 columns content">
    <?= $this->Form->create('Anime') ?>
    <fieldset>
        <legend><?= __('Add Anime') ?></legend>
        <?php
            echo $this->Form->control('id');
            echo $this->Form->control('title');
            echo $this->Form->control('title_short');
            echo $this->Form->control('url');
            echo $this->Form->control('api_id', ['type' => 'text']);
            echo $this->Form->control('year');
            echo $this->Form->control('cool');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
