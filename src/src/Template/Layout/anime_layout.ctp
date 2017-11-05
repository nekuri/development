<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = 'CakePHP: the rapid development php framework';
?>

<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('bootstrap.css') ?>
    <?= $this->Html->css('dashboard.css') ?>
    <?= $this->Html->css('customBootstrap.css') ?>

    <?= $this->Html->script('jquery.js') ?>
    <?= $this->Html->script('bootstrap.js') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark" data-topbar role="navigation">
    <a href="" class="navbar-brand">あにここ！</a>
        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
            <?php if(isset($user)) : ?>
            <li class="nav-item"><?= $this->Html->link($user['username'] . 'でログイン中', ['controller' => 'users', 'action' => 'index'], ['class' => 'nav-link']); ?></li>
            <li class="nav-item"><?= $this->Html->link('ログアウト', ['controller' => 'users', 'action' => 'logout'], ['class' => 'nav-link']) ?></li>
            <?php else : ?>
            <li class="nav-item"><?= $this->Html->link('ログイン', ['controller' => 'members', 'action' => 'login'], ['class' => 'nav-link']); ?></li>
            <li class="nav-item"><?= $this->Html->link('会員登録(無料)', ['controller' => 'members', 'action' => 'add'], ['class' => 'nav-link']); ?></li>
            <?php endif; ?>
        </ul>
        <?php if ($this->request->action == 'index' && $this->request->controller == 'Animes') : ?>
            <?= $this->Form->create('Anime', ['valueSources' => 'query', 'class' => 'form-inline mt-2 mt-md-0']) ?>
            <?= $this->Form->input('title', ['label' => false, 'class' => 'form-control mr-sm-2']) ?>

            <?= $this->Form->button('アニメを探す', ['class' => 'btn btn-outline-success my-2 my-sm-0']) ?>
            <?= $this->Form->end(); ?>
        <?php endif; ?>
        </div>

    </nav>
    <?= $this->Flash->render() ?>
    <div class="container-fluid">
        <div class="row">
            <?= $this->fetch('content') ?>
        </div>
    </div>
    <footer>
    </footer>
</body>
</html>
