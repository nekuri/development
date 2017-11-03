<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Review $review
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Review'), ['action' => 'edit', $review->anime_id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Review'), ['action' => 'delete', $review->anime_id], ['confirm' => __('Are you sure you want to delete # {0}?', $review->anime_id)]) ?> </li>
        <li><?= $this->Html->link(__('List Reviews'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Review'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Animes'), ['controller' => 'Animes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Anime'), ['controller' => 'Animes', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="reviews view large-9 medium-8 columns content">
    <h3><?= h($review->title) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Title') ?></th>
            <td><?= h($review->title) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Body') ?></th>
            <td><?= h($review->body) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Anime') ?></th>
            <td><?= $review->has('anime') ? $this->Html->link($review->anime->title, ['controller' => 'Animes', 'action' => 'view', $review->anime->api_id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($review->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Evalution') ?></th>
            <td><?= $this->Number->format($review->evalution) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($review->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($review->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Daleted') ?></th>
            <td><?= h($review->daleted) ?></td>
        </tr>
    </table>
</div>
