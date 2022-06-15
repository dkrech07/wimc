<?php

use app\assets\GrandmasterAsset;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;
// use yii\helpers\Url;
// use yii\helpers\ArrayHelper;
// use yii\jui\AutoComplete;
// use yii\web\JsExpression;
use app\widgets\Alert;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\widgets\Menu;

GrandmasterAsset::register($this);
$this->title = 'Grandmaster - Statistics';
?>



<div class="content-block col-10 col-sm-10 col-md-10 col-lg-10 col-xl-10">
    <table class="customs-table">
        <?php if ($statisticsItem == '_search_item') : ?>
            <h2>Статистика поиска</h2>
            <p>Записывается при клике на кнопку "Поиск"</p>

            <thead class="customs-head">
                <td class="search-param">ID</td>
                <td class="search-param">Дата/время запроса</td>
                <td class="search-param">Текст запроса</td>
                <td class="search-param">Широта найденной точки</td>
                <td class="search-param">Долгота найденной точки</td>
                <td class="search-param">Широта ближайшей таможи</td>
                <td class="search-param">Долгота ближайшей таможи</td>
                <td class="search-param">Код ближайшей таможи</td>
                <td class="search-param">Расстояние до ближайшей таможни</td>
                <td class="search-param">Параметры фильтра (все/гол/акц/проч/метки)</td>
            </thead>

        <?php elseif ($statisticsItem == '_geocoder_item') : ?>
            <h2>Статистика геокодера</h2>
            <p>Записывается при вводе запроса в строке поиска</p>
            <thead class="customs-head">
                <td class="search-param">ID</td>
                <td class="search-param">Дата/Время открытия Главной страницы</td>
                <td class="search-param">IP-адрес пользователя</td>
            </thead>

        <?php else : ?>



        <?php endif; ?>

        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => $statisticsItem,
            'options' => [ // настройка атрибутов для внешнего контейнера списка
                'class' => 'title-list statistics-menu', // класс блока div
            ],
            'pager' => [
                'prevPageLabel' => '',
                'nextPageLabel' => '',
                'pageCssClass' => 'pagination-item',
                'prevPageCssClass' => 'pagination-item mark',
                'nextPageCssClass' => 'pagination-item mark',
                'activePageCssClass' => 'pagination-item--active',
                'options' => ['class' => 'pagination-list'],
                // 'linkOptions' => ['class' => 'link link--page'],
                // 'options' => [
                //     'class' => 'pagination-list',
                // ],
            ],
        ]) ?>
    </table>
</div>