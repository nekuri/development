<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Anime[]|\Cake\Collection\CollectionInterface $animes
 */
?>
    <nav class="col-sm-3 col-md-2 d-none d-sm-block bg-light sidebar">
    <?= $this->Form->create('Anime', ['class' => 'p-3']) ?>
    <?= $this->Form->select('year',
        [
            2014 => '2014年',
            2015 => '2015年',
            2016 => '2016年',
            2017 => '2017年'
        ],
        [
            'default' => $year,
            'class' => 'form-control form-control-sm',
        ]
    )
    ?>

    <?= $this->Form->select('cool',
        [
            1 => '冬アニメ',
            2 => '春アニメ',
            3 => '夏アニメ',
            4 => '秋アニメ'
        ],
        [
            'default' => $cool,
            'class' => 'form-control form-control-sm mt-2',
        ]
    )
    ?>

    <?= $this->Form->button('絞り込む', ['class' => 'btn btn-primary mt-2']) ?>
    <?= $this->Form->end(); ?>

    <ul class="nav nav-pills flex-column">
    </ul>
    </nav>
<main role="main" class="col-sm-9 ml-sm-auto col-md-10 pt-3">
    <?php if (isset($title)) : ?>
    <h1>検索用語:<?= h($title) ?></h1>
    <?php else : ?>
    <h1><?= $year ?>年<?= $anime_season[$cool] ?>一覧</h1>
    <?php endif; ?>
    <?php if(isset($animes)) : ?>
    <sction class="row text-center placeholders pl-3">
        <?php foreach ($animes as $anime): ?>
        <div class="card m-2 hover" style="width: 15rem;">
        <?php if (isset($anime->photo)) : ?>
            <?= $this->Html->image('files' . '/' . $anime->api_id . '/' . $anime->photo, [
                'width' => '235',
                'height' => '200',
                'url' => ['action' => 'view', $anime->api_id],
                'class' => 'rounded'
        ]) ?>
        <?php else : ?>
            <?= $this->Html->image('noimage.png', [
            'alt' => 'noimage',
            'width' => '235',
            'height' => '200',
            'url' => ['action' => 'view', $anime->api_id],
            'class' => 'rounded'
        ]) ?>
        <?php endif; ?>
            <div class="card-body">
            <h5 class="card-title"><?= h($anime->title) ?></h5>
            <br><a href="<?= h($anime->url) ?>" target="_blank">公式サイト</a>
            </div>
            <ul class="list-group list-group-flush">
            <li class="list-group-item text-primary">レビュー数:<?= count($anime->reviews); ?></li>
            <li class="list-group-item text-warning">平均値:<?= $this->Animes->getReviewAverage($anime->reviews) ?></li>
            </ul>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
    </sction>
    <nav area-label="Page navigation example">
    <?php if(isset($animes)) : ?>
    <ul class="pagination">
        <?= $this->Paginator->first('<<') ?>
        <?= $this->Paginator->prev('<') ?>
        <?= $this->Paginator->numbers() ?>
        <?= $this->Paginator->next('>') ?>
        <?= $this->Paginator->last('>>') ?>
    </ul>
    <p class="counter"><?= $this->Paginator->counter(['format' => __('{{count}} 件中 {{start}} 〜 {{end}} を表示')]) ?></p>
    <?php endif; ?>
    </div>
</main>
