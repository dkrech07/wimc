<?php

use app\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\jui\AutoComplete;
use yii\web\JsExpression;

AppAsset::register($this);
$apiKey = Yii::$app->params['geocoderApiKey'];
$this->registerJsFile("https://api-maps.yandex.ru/2.1/?apikey={$apiKey}&lang=ru_RU");

$this->title = $page->page_name;
$this->registerMetaTag(['name' => 'description', 'content' => $page->page_meta_description]);
?>

<?php print($page->page_content) ?>

<div class="wrapper">
    <?php $form = ActiveForm::begin([
        'id' => 'search-customs',

        // 'encodeErrorSummary' => true,
        // 'errorSummaryCssClass' => 'help-block',

        'enableAjaxValidation' => true,
        'options' => [
            'autocomplete' => 'off',
            'class' => 'search-label row', //form-horizontal
            'style' => 'margin-bottom: 10px;',
        ],
    ]); ?>

    <?= $form->field($searchCustomsModel, 'latitude', ['template' => '{input}'])->hiddenInput(['id' => 'latitude']) ?>
    <?= $form->field($searchCustomsModel, 'longitude', ['template' => '{input}'])->hiddenInput(['id' => 'longitude']) ?>

    <?= $form->field($searchCustomsModel, 'autocomplete', [
        'template' => '{label}{input}',
        'options' => [
            // 'style' => 'margin-bottom: 10px;',
            'class' => 'col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12',
        ]
    ])
        ->textInput([
            'label' => '<i class="bi bi-search"></i>',
            'class' => 'form-control input-shadow',
            'required' => true,
            'id' => 'autocomplete',
            'placeholder' => "Например, Смоленск, Лавочника, 54",
        ])->label('<i class="bi bi-search"></i> ВВЕДИТЕ АДРЕС, И СЕРВИС НАЙДЕТ БЛИЖАЙШИЕ ТАМОЖЕННЫЕ ПОСТЫ:', []);
    ?>

    <i class="clear-btn bi bi-x-circle"></i>

    <button type="submit" class="search-btn btn btn-primary">
        <i class="bi bi-search"></i>
        <span class="search-btn-title">Поиск</span>
    </button>

    <?php ActiveForm::end(); ?>

    <div class="add-block col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p class="filter-label">
            Дополнительно показать:
        </p>
        <div class="btn-group-toggle" data-toggle="buttons">
            <label class="icon btn btn-outline-primary filter-btn head">
                <i class="bi bi-geo-alt-fill"></i>
                <input id="head" class="customs-checkbox" type="checkbox" autocomplete="off"> <span>Головные</span>
            </label>
            <label class="icon btn btn-outline-primary filter-btn excise">
                <i class="bi bi-geo-alt-fill"></i>
                <input id="excise" class="customs-checkbox" type="checkbox" autocomplete="off"> <span>Акцизные</span>
            </label>
            <label class="icon btn btn-outline-primary filter-btn others">
                <i class="bi bi-geo-alt-fill"></i>
                <input id="others" class="customs-checkbox" type="checkbox" autocomplete="off"> <span>Специальные</span>
            </label>
            <label class="icon btn btn-outline-primary filter-btn captions">
                <i class="bi bi-chat-left-text"></i>
                <input id="captions" class="customs-checkbox" type="checkbox" autocomplete="off"> <span>Подписи ко всем меткам</span>
            </label>
        </div>
    </div>
</div>

<div class="wrapper">
    <p class="map-label">
        <i class="bi bi-geo-alt"></i>
        Результат поиска на карте:
    </p>
    <div class='row' style="margin-bottom: 20px;">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" id="map" style="width: 100%;" data-latitude="<?= $searchCustomsModel->latitude ?>" data-longitude="<?= $searchCustomsModel->longitude ?>">
            <button type="button" class="zoom-out btn btn-light"><i class="bi bi-arrow-counterclockwise"></i></button>
        </div>
    </div>

    <div class='nearest-popup nearest-disabled roll-up'>
        <h3 class="nearest-header">Ближайшие точки</h3>
        <h4 class="nearest-title">Ближайший пост</h4>
        <ul class="nearest-list"></ul>
        <h4 class="nearest-title">Еще посты рядом</h4>
        <ul class="nearest-list nearest-others"></ul>
        <div class="roll-button">Свернуть </div>
        <!-- <i class="bi bi-caret-up-fill"></i> -->
    </div>
</div>