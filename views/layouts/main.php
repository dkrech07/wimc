<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body class="d-flex flex-column h-100">
    <?php $this->beginBody() ?>

    <header>
        <?php
        NavBar::begin([
            'brandLabel' => Yii::$app->name,
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar navbar-expand-md navbar-dark bg-dark fixed-top',
            ],
        ]);
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav'],
            'items' => [
                ['label' => 'Карта СВХ', 'url' => ['/whs']],
                ['label' => 'Справочник постов', 'url' => ['/customs_list']],
                ['label' => 'Как это работает', 'url' => ['/about']],
            ],
        ]);
        NavBar::end();
        ?>
    </header>

    <main role="main" class="flex-shrink-0">
        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </main>

    <footer class="footer mt-auto py-3 text-muted">
        <div class="container">
            <p class="float-left">&copy; MyCustoms <?= date('Y') ?></p>
            <p class="float-right">
                <a href="/contacts">Связаться с нами</a>
                <a href="/about">О проекте</a>
                <a href="/cookie">Куки</a>
            </p>
        </div>
    </footer>

    <div id="cookie_note">
        <p>Мы используем файлы cookies для улучшения работы сайта. Оставаясь на нашем сайте, вы соглашаетесь с условиями
            использования файлов cookies. Чтобы ознакомиться с нашими Положениями о конфиденциальности и об использовании
            файлов cookie, <a href="/cookie" target="_blank">нажмите здесь</a>.</p>
        <button class="button cookie_accept btn btn-primary btn-sm">Я согласен</button>
    </div>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>