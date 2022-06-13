<?php

use app\assets\GrandmasterAsset;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;
// use yii\helpers\Url;
// use yii\helpers\ArrayHelper;
// use yii\jui\AutoComplete;
// use yii\web\JsExpression;

GrandmasterAsset::register($this);
$this->title = 'Grandmaster - Statistics';
?>



<div class="wrapper content-block col-8 col-sm-8 col-md-8 col-lg-8 col-xl-8">
    <p>Статистика поиска</p>

    <table class="customs-table">
        <thead class="customs-head">
            <td class="custom-param id">ID</td>
            <td class="custom-param code">Дата/время запроса</td>
            <td class="custom-param namt">Текст запроса</td>
            <td class="custom-param okpo">Широта найденной точки</td>
            <td class="custom-param ogrn">Долгота найденной точки</td>
            <td class="custom-param inn">Широта ближайшей таможи</td>
            <td class="custom-param name_all">Долгота ближайшей таможи</td>
            <td class="custom-param adrtam">Код ближайшей таможи</td>
            <td class="custom-param prosf">Расстояние до ближайшей таможни</td>
            <td class="custom-param telefon">Параметры фильтра (все/гол/акц/проч/метки)</td>
        </thead>

        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => '_statistics_item',
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