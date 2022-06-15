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

$user = '';
if (isset(Yii::$app->user->identity->login)) {
    $user = Yii::$app->user->identity->login;
}
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
                'class' => 'navbar navbar-expand-md navbar-dark bg-dark', //fixed-top
            ],
        ]);
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav'],
            'items' => [
                // ['label' => 'Перейти на сайт', 'url' => ['/customs/index']],
                ['label' => 'Grandmaster', 'url' => ['/grandmaster/index']],
                ['label' => 'Выход', 'url' => ['/site/logout']],
                '<li class="user-item">Пользователь: ' . $user . '</li>',
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
        <div class="container-fluid container-wrapper">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= Alert::widget() ?>
            <div class="row">
                <ul class="wrapper left-menu col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                    <?php
                    $items = [
                        ['label' => 'Список постов', 'url' => ['/grandmaster/customs']],
                        ['label' => 'Cписок пользователей', 'url' => ['/grandmaster/users']],
                        // ['label' => 'Статистика', 'url' => ['/grandmaster/statistics?id=search']],
                        // ['label' => 'Статистика поиска (при клике на кнопку "Поиск")', 'url' => ['/grandmaster/statistics?id=search']],
                        // ['label' => 'Статистика геокодера (при вводе значеня в поле "Поиск")', 'url' => ['/grandmaster/statistics?id=geocoder']],

                        [
                            'label' => 'Статистика',
                            'url' => ['statistics'],
                            'options' => ['class' => 'pages-dropdown'],
                            'template' => '<a href="{url}" class="url-class">{label}</a>',
                            'items' => [
                                ['label' => 'Статистика поиска', 'url' => ['/grandmaster/statistics?id=search']],
                                ['label' => 'Статистика геокодера', 'url' => ['/grandmaster/statistics?id=geocoder']],
                                ['label' => 'Статистика посещаемости', 'url' => ['/grandmaster/statistics?id=ip']],
                            ]
                        ],

                        ['label' => 'Сообщения', 'url' => ['/grandmaster/messages']],
                        [
                            'label' => 'Редактирование страниц', 'url' => ['pages'],
                            'options' => ['class' => 'pages-dropdown'],
                            'template' => '<a href="{url}" class="url-class">{label}</a>',
                            'items' => [
                                ['label' => 'Карта СВХ', 'url' => ['/grandmaster/pages/?id=whs']],
                                ['label' => 'Справочник постов', 'url' => ['/grandmaster/pages/?id=customs_list']],
                                ['label' => 'Как это работает', 'url' => ['/grandmaster/pages/?id=about']],
                                ['label' => 'Связаться с нами', 'url' => ['/grandmaster/pages/?id=contacts']],
                                ['label' => 'Cookie', 'url' => ['/grandmaster/pages/?id=cookie']],

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
            <p class="float-left">&copy; MyCustoms Grandmaster <?= date('Y') ?></p>
            <p class="float-right"><?= Yii::powered() ?></p>
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>