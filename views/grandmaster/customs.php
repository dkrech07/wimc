<?php

use app\assets\GrandmasterAsset;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;
use app\widgets\ModalForm;

// use yii\helpers\Url;
// use yii\helpers\ArrayHelper;
// use yii\jui\AutoComplete;
// use yii\web\JsExpression;

GrandmasterAsset::register($this);
$this->title = 'Grandmaster - Customs';
?>



<div class="content-block col-10 col-sm-10 col-md-10 col-lg-10 col-xl-10">
    <h2 class="grandmaster-title">Список таможенных постов:</h2>
    <table class="customs-table">
        <thead class="customs-head">
            <td class="custom-param id">ID</td>
            <td class="custom-param code">CODE</td>
            <td class="custom-param namt">NAMT</td>
            <td class="custom-param okpo">OKPO</td>
            <td class="custom-param ogrn">OGRN</td>
            <td class="custom-param inn">INN</td>
            <td class="custom-param name_all">NAME_ALL</td>
            <td class="custom-param adrtam">ADRTAM</td>
            <td class="custom-param prosf">PROSF</td>
            <td class="custom-param telefon">TELEFON</td>
            <td class="custom-param fax">FAX</td>
            <td class="custom-param email">EMAIL</td>
            <td class="custom-param coords_latitude">LATITUDE</td>
            <td class="custom-param coords_longitude">LONGITUDE</td>
            <td class="custom-param edit">ACTION</td>

        </thead>

        <div class="pagination-wrapper">
            <?= ListView::widget([
                'dataProvider' => $dataProvider,
                'itemView' => '_custom_item',
                'pager' => [
                    'prevPageLabel' => '',
                    'nextPageLabel' => '',
                    'pageCssClass' => 'pagination-item',
                    'prevPageCssClass' => 'pagination-item mark',
                    'nextPageCssClass' => 'pagination-item mark',
                    'activePageCssClass' => 'pagination-item--active',
                    'options' => ['class' => 'pagination-list'],
                    'linkOptions' => ['class' => 'link link--page'],
                    'options' => [
                        'class' => 'pagination-list',
                    ],
                ],
            ]) ?>
        </div>
    </table>
</div>

<?= ModalForm::widget(['formType' => 'CustomEditForm', 'formModel' => $customEditFormModel]) ?>