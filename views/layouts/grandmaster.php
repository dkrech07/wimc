<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\GrandmasterAsset;
use app\widgets\Alert;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\widgets\Menu;

GrandmasterAsset::register($this);
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
            // 'brandLabel' => Yii::$app->name,
            // 'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar navbar-expand-md navbar-dark bg-dark fixed-top',
            ],
        ]);
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav'],
            'items' => [
                // ['label' => 'Перейти на сайт', 'url' => ['/customs/index']],
                ['label' => 'Grandmaster', 'url' => ['/grandmaster/index']],
                ['label' => 'Выход', 'url' => ['/site/logout']]

                // ['label' => 'About', 'url' => ['/site/about']],
                // ['label' => 'Contact', 'url' => ['/site/contact']],
                // Yii::$app->user->isGuest ? (['label' => 'Login', 'url' => ['/site/login']]
                // ) : ('<li>'
                //     . Html::beginForm(['/site/logout'], 'post', ['class' => 'form-inline'])
                //     . Html::submitButton(
                //         'Logout (' . Yii::$app->user->identity->username . ')',
                //         ['class' => 'btn btn-link logout']
                //     )
                //     . Html::endForm()
                //     . '</li>'
                // )
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
            <div class="row">
                <ul class="wrapper left-menu col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
                    <?php
                    $items = [
                        ['label' => 'Список постов', 'url' => ['/grandmaster/customs']],
                        ['label' => 'Cписок пользователей', 'url' => ['/grandmaster/users']],
                        ['label' => 'Статистика', 'url' => ['/grandmaster/statistics']],
                        ['label' => 'Сообщения', 'url' => ['/grandmaster/messages']],
                        [
                            'label' => 'Редактирование страниц',
                            'url' => ['pages'],
                            'options' => ['class' => 'dropdown'],
                            'template' => '<a href="{url}" class="url-class">{label}</a>',
                            'items' => [
                                ['label' => 'Карта СВХ', 'url' => ['/pages/svh-map']],
                                ['label' => 'Справочник постов', 'url' => ['/pages/customs-directory']],
                                ['label' => 'Как это работает', 'url' => ['']],
                                ['label' => 'О проекте', 'url' => ['']],
                                ['label' => 'Связаться с нами', 'url' => ['']],
                                ['label' => 'Cookie', 'url' => ['']],

                            ]
                        ],
                    ];
                    ?>

                    <?= Menu::widget([
                        'items' => $items,
                        'activeCssClass' => 'list-item--active',
                        'itemOptions' => ['class' => 'list-item'],
                        'labelTemplate' => '<a class="link link--nav">{label}</a>',
                        'linkTemplate' => '<a href="{url}" class="link link--nav">{label}</a>',
                        'options' => ['class' => 'nav-list']
                    ]);
                    ?>
                </ul>
                <?= $content ?>
            </div>
        </div>
    </main>

    <footer class="footer mt-auto py-3 text-muted">
        <div class="container">
            <p class="float-left">&copy; My Company <?= date('Y') ?></p>
            <p class="float-right"><?= Yii::powered() ?></p>
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>