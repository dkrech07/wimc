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

// print_r($customSearchFormModel);

GrandmasterAsset::register($this);
$this->title = 'Grandmaster - Customs';
?>

<div class="content-block col-10 col-sm-10 col-md-10 col-lg-10 col-xl-10">

    <!-- <div class="stick_menu customs-edit-group">
  
    </div> -->

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


        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => '_custom_item',
            'options' => [ // настройка атрибутов для внешнего контейнера списка
                'class' => 'title-list customs-menu', // класс блока div
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

    <div class="edit-buttons">
        <a class="modal-button all-customs-button" href="/grandmaster/customs?ALL=all">Показать все посты</a>
        <a class="modal-button all-customs-button" href="#">Добавить новый поист</a>
    </div>


    <div class="custom-search">
        <?php $form = ActiveForm::begin([
            'id' => 'custom-search',
            'action' => 'customs',
            'method' => 'get',
            'enableClientValidation' => false,
            'enableAjaxValidation' => false
        ]); ?>

        <?= $form->field($customSearchFormModel, 'CODE')->textInput(['placeholder' => 'CODE', 'size' => 25, 'name' => 'CODE']) ?>
        <?= $form->field($customSearchFormModel, 'NAMT')->textInput(['placeholder' => 'NAMT', 'size' => 50, 'name' => 'NAMT']) ?>

        <div class="submit-btn form-group">
            <button type="submit" class="modal-button custom-search-button">Найти</button>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>

<?= ModalForm::widget(['formType' => 'CustomEditForm', 'formModel' => $customEditFormModel]) ?>
<?= ModalForm::widget(['formType' => 'CustomViewForm', 'formModel' => $customEditFormModel]) ?>

<div class="delete-window" style="display: none">
    <h3 class="delete-title">Вы действительно хотите удалить пост ID <span class="delete-post-id"></span> из системы?</h3>
    <div class="delete-buttons">
        <button class="custom-delete-no">Нет</button>
        <button class="custom-delete-yes">Да</button>
    </div>
</div>