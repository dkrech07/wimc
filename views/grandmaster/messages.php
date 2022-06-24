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
$this->title = 'Grandmaster - Admin';
?>



<div class="content-block col-10 col-sm-10 col-md-10 col-lg-10 col-xl-10">
    <h3 class="grandmaster-title">Сообщения</h3>
    <p>Сообщения из формы со страницы "Связаться с нами" <a target="_blank" href="/contacts">https://mycustoms.site/contacts</a></p>


    <table class="customs-table">
        <thead class="customs-head">
            <td class="search-param">ID</td>
            <td class="search-param">Дата и время отправки формы</td>
            <td class="search-param">Имя отправителя</td>
            <td class="search-param">Email отправителя</td>
            <td class="search-param">Текст сообщения</td>
            <td class="search-param">Список отправленных файлов</td>
        </thead>

        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => '_messages_item',
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