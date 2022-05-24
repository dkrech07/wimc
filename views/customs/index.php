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

$this->title = 'Where is my customs?';
?>

<!-- <form>
    <div class="ui-widget">
        <label for="autocomplete">Укажите адрес: </label>
        <input id="autocomplete" />
    </div>
</form> -->

<div class="wrapper">
    <?php $form = ActiveForm::begin([
        'id' => 'search-customs',
        'enableAjaxValidation' => true,
        'options' => [
            'autocomplete' => 'off',
            'class' => 'search-label row', //form-horizontal
            'style' => 'margin-bottom: 10px;',
        ],
    ]); ?>

    <?= $form->field($searchCustomsModel, 'latitude', ['template' => '{input}'])->hiddenInput(['id' => 'latitude']) ?>
    <?= $form->field($searchCustomsModel, 'longitude', ['template' => '{input}'])->hiddenInput(['id' => 'longitude']) ?>
    <?= $form->field($searchCustomsModel, 'nearest_lat', ['template' => '{input}'])->hiddenInput(['id' => 'nearest_lat']) ?>
    <?= $form->field($searchCustomsModel, 'nearest_lon', ['template' => '{input}'])->hiddenInput(['id' => 'nearest_lon']) ?>
    <?= $form->field($searchCustomsModel, 'distance', ['template' => '{input}'])->hiddenInput(['id' => 'distance']) ?>

    <?= $form->field($searchCustomsModel, 'autocomplete', [
        'template' => '{label}{input}',
        'options' => [
            'style' => 'margin-bottom: 10px;',
            'class' => 'col-12 col-sm-12 col-md-9 col-lg-9 col-xl-9',
        ]
    ])
        ->input([
            'class' => 'form-control',
            'required' => true,
            'id' => 'autocomplete'
        ])
    ?>

    <?= Html::submitInput('Найти таможни', [
        // 'style' => 'margin-top: 30px;',
        'class' => 'search-btn btn btn-outline-primary col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2' // btn btn-primary
    ]) ?>

    <?php ActiveForm::end(); ?>

    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p class="filter-label">
            Дополнительно показать:
        </p>
        <div class="btn-group-toggle" data-toggle="buttons">
            <label class="btn btn-outline-primary filter-btn head">
                <i class="bi bi-geo-alt-fill"></i>
                <input id="head" class="customs-checkbox" type="checkbox" autocomplete="off"> <span>Головные</span>
            </label>
            <label class="btn btn-outline-primary filter-btn excise">
                <i class="bi bi-geo-alt-fill"></i>
                <input id="excise" class="customs-checkbox" type="checkbox" autocomplete="off"> <span>Акцизные</span>
            </label>
            <label class="btn btn-outline-primary filter-btn others">
                <i class="bi bi-geo-alt-fill"></i>
                <input id="others" class="customs-checkbox" type="checkbox" autocomplete="off"> <span>Специальные</span>
            </label>
            <label class="btn btn-outline-primary filter-btn captions">
                <i class="bi bi-chat-left-text"></i>
                <input id="captions" class="customs-checkbox" type="checkbox" autocomplete="off"> <span>Подписи ко всем меткам</span>
            </label>
        </div>
    </div>
</div>