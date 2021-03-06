<?php
// テンプレートを変更します
$this->Paginator->setTemplates([
    'nextActive' => '<li class="page-item"><a rel="next" href="{{url}}#review" class="page-link">{{text}}</a></li>',
    'nextDisabled' => '',
    'prevActive' => '<li class="page-item"><a rel="prev" href="{{url}}#review" class="page-link">{{text}}</a></li>',
    'prevDisabled' => '',
    'number' => '<li class="page-item"><a href="{{url}}#review" class="page-link">{{text}}</a></li>',
    'current' => '<li class="page-item disabled"><a href="" class="page-link">{{text}}</a></li>',
    'first' => '<li class="first page-item"><a href="{{url}}#review" class="page-link">{{text}}</a></li>',
    'last' => '<li class="last page-item"><a href="{{url}}#review" class="page-link">{{text}}</a></li>',
]);
?>


<nav class="col-sm-3 col-md-2 d-none d-sm-block bg-light sidebar">
<ul class="nav nav-pills flex-column">
<li class="nav-item"><?= $this->Html->link(__('一覧に戻る'), ['action' => 'index'], ['class' => 'nav-link']) ?></li>
<li class="nav-item"><?= $this->Html->link('レビューを書く', ['controller' => 'reviews', 'action' => 'add', $anime->api_id], ['class' => 'nav-link']) ?></li>
</nav>
<main role="main" class="col-sm-9 ml-sm-auto col-md-10 mb-5 pt-3">
<?= $this->Flash->render() ?>
    <h2><?= h($anime->title) ?></h2>
    <div class="float-left ml-5">
        <?php if (isset($anime->photo)) : ?>
        <?= $this->Html->image('files' . '/' . $anime->api_id . '/' . $anime->photo, [
                    'width' => '500',
                    'height' => '500',
                ]) ?>
        <?php else : ?>
            <?= $this->Html->image('noimage.png', [
                'alt' => 'noimage',
                'width' => '500',
                'height' => '500',
            ]) ?>
        <?php endif; ?>
    </div>
    <div class="float-left ml-5" style="margin-top:150px;">
        <p class="large-text">評価平均値
        <?php if (isset($avg_evalution)): ?>
        <?php for($i = 0; $i < $avg_evalution; $i++) : ?>
        ★
        <?php endfor; ?>
        <?php endif; ?>
        </p>
        <p class="large-text"><a href="<?= h($anime->url) ?>" target="_blank">公式サイト</a></p>
        <p class="large-text"><?= h($anime->year) ?>年<?= h($anime_season[$anime->cool]) ?></p>
    </div>
    <div class="float-none">
        <?= $this->Html->link('この作品のレビューを書く', ['controller' => 'reviews', 'action' => 'add', $anime->api_id], ['class' => 'btn btn-primary font-weight-bold w-50 mt-2 mb-2 ml-7']) ?>
        <h4 id="review" class="dash"><?= __('ユーザーレビュー') ?></h4>
        <?php if (!empty($reviews)): ?>
            <?php foreach ($reviews as $review): ?>
            <div class="review border border-info w-75 p-3 mb-3 ml-25p">
                <div class="float-left">
                <?= $this->Html->image('noimage.png', [
                    'alt' => 'noimage',
                    'width' => '100',
                    'height' => '100',
               ]) ?>
                </div>

                <div class="float-left mt-3 ml-5">匿名さんのレビュー
                <br>
                <b><?= h($review->title) ?></b>
                </div>

                <div class="float-left mt-3 ml-5">
                評価 <?php for ($i = 0; $i < $review->evalution; $i++) : ?>
                ★
                <?php endfor; ?>
                </div>
                <div class="float-none review-area border-dot p-2">
                <?= h($review->body) ?>
                </div>
            </div>
            <?php endforeach; ?>
        <ul class="pagination">
            <?= $this->Paginator->first('<<') ?>
            <?= $this->Paginator->prev('<') ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next('>') ?>
            <?= $this->Paginator->last('>>') ?>
        </ul>
    <p class="counter"><?= $this->Paginator->counter(['format' => __('{{count}} 件中 {{start}} 〜 {{end}} を表示')]) ?></p>
        <?php else : ?>
        <p>このアニメのレビューはありません。レビューを書いてみませんか？</p>
        <?php endif; ?>
    </div>
</main>
