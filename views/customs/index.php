<!-- https://github.com/dkrech07/291473-task-force-2/blob/master/views/tasks/add.php -->

<?php

use app\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\assets\AutoCompleteAsset;
use yii\jui\AutoComplete;
use yii\web\JsExpression;

AppAsset::register($this);
AutoCompleteAsset::register($this);
$apiKey = Yii::$app->params['geocoderApiKey'];
$this->registerJsFile("https://api-maps.yandex.ru/2.1/?apikey={$apiKey}&lang=ru_RU");
$this->registerJsFile('js/yandex-map.js');
$this->registerJsFile('js/customs-filter.js');

// $this->registerJsFile('/js/custom.js');
$this->title = 'Where is my customs?';
?>


<?php $form = ActiveForm::begin([
    'id' => 'search-customs',
    'enableAjaxValidation' => true,
    'options' => [
        'autocomplete' => 'off',
        'class' => 'row', //form-horizontal
        'style' => 'margin-bottom: 10px;',
    ],
]); ?>

<?= $form->field($searchCustomsModel, 'latitude', ['template' => '{input}'])->hiddenInput(['id' => 'latitude']) ?>
<?= $form->field($searchCustomsModel, 'longitude', ['template' => '{input}'])->hiddenInput(['id' => 'longitude']) ?>
<?= $form->field($searchCustomsModel, 'nearest_lat', ['template' => '{input}'])->hiddenInput(['id' => 'nearest_lat']) ?>
<?= $form->field($searchCustomsModel, 'nearest_lon', ['template' => '{input}'])->hiddenInput(['id' => 'nearest_lon']) ?>
<?= $form->field($searchCustomsModel, 'distance', ['template' => '{input}'])->hiddenInput(['id' => 'distance']) ?>

<?= $form->field($searchCustomsModel, 'geo', [
    'template' => "{label}\n{input}",
    'options' => [
        // 'style' => 'padding-left: 0',
        'class' => 'col-12 col-sm-12 col-md-8 col-lg-8 col-xl-8'
    ]
])->widget(
    AutoComplete::className(),
    [
        'clientOptions' => [
            'source' => new JsExpression('
            function (request, response) {
                $.ajax({
                    url: "/autocomplete", // "/autocomplete" "http://localhost/wimc/web/autocomplete"
                    data: {
                        term: request.term
                    },
                    dataType: "json",
                    success: function(data) {
                        console.log(data);
                        response($.map(data, function (geo) {
                            return {
                                label: geo.display_name,
                                value: [geo.lat, geo.lon]
                            };
                        }));
                    },
                    error: function () {
                        response([]);
                    }
                });
            }
        '),
            'select' => new JsExpression('
                function (event, ui) {
                    this.value = ui.item.label;
                    let geo = ui.item.value;

                    $("#latitude").val(geo[0]);
                    $("#longitude").val(geo[1]);
                
                    event.preventDefault();
                }
            '),
        ],
        'options' => [
            'class' => 'form-control'
        ]
    ]
);
?>



<?= Html::submitInput('Найти таможни', [
    // 'style' => 'margin-top: 30px;',
    'class' => 'col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2 btn btn-primary'
]) ?>


<?php ActiveForm::end(); ?>

<!-- <input type="checkbox" class="btn-check btn-sm" id="btn-check-outlined" autocomplete="off">
    <label class="btn btn-outline-danger" for="btn-check-outlined">Головные таможни</label><br>

    <input type="checkbox" class="btn-check" id="btn-check-outlined" autocomplete="off">
    <label class="btn btn-outline-warning" for="btn-check-outlined">Посты акцизной таможни</label><br>

    <input type="checkbox" class="btn-check" id="btn-check-outlined" autocomplete="off">
    <label class="btn btn-outline-primary" for="btn-check-outlined">Прочие посты</label><br>

    <input type="checkbox" class="btn-check " id="btn-check-outlined" autocomplete="off">
    <label class="btn btn-outline-danger" for="btn-check-outlined">Подписи ко всем меткам</label><br> -->

<?php $form = ActiveForm::begin([
    'id' => 'tasks-form',
    'enableAjaxValidation' => true,
    'options' => [
        'autocomplete' => 'off',
        'class' => 'row', //form-horizontal
        'style' => 'margin-bottom: 10px;',
    ],
]); ?>

<?= $form->field($filterCustoms, 'head', [
    'template' => "{input} {label} {error}",
    'options' => [
        // 'style' => 'margin: 0; padding: 0',
        'class' => 'col-12 col-sm-12 col-md-6 col-lg-2 col-xl-2'
    ]
])->checkbox([
    'id' => 'head',
    'class' => 'btn-check customs-checkbox',
    //'name' => 'status'
], false)->label($filterCustoms->head, [
    'class' => 'btn btn-outline-danger',
    'for' => 'head',
]); ?>

<?= $form->field($filterCustoms, 'excise', [
    'template' => "{input} {label} {error}",
    'options' => [
        // 'style' => 'margin: 0; padding: 0',
        'class' => 'col-12 col-sm-12 col-md-6 col-lg-2 col-xl-2'
    ]
])->checkbox([
    'id' => 'excise',
    'class' => 'btn-check customs-checkbox',
    //'name' => 'status'
], false)->label($filterCustoms->head, [
    'class' => 'btn btn-outline-warning',
    //'for' => 'feed-status',
]); ?>

<?= $form->field($filterCustoms, 'others', [
    'template' => "{input} {label} {error}",
    'options' => [
        // 'style' => 'margin: 0; padding: 0',
        'class' => 'col-12 col-sm-12 col-md-6 col-lg-2 col-xl-2'
    ]
])->checkbox([
    'id' => 'others',
    'class' => 'btn-check customs-checkbox',
    //'name' => 'status'
], false)->label($filterCustoms->head, [
    'class' => 'btn btn-outline-primary',
    //'for' => 'feed-status',
]); ?>

<?= $form->field($filterCustoms, 'captions', [
    'template' => "{input} {label} {error}",
    'options' => [
        // 'style' => 'margin: 0; padding: 0',
        'class' => 'col-12 col-sm-12 col-md-6 col-lg-2 col-xl-2'
    ]
])->checkbox([
    'id' => 'captions',
    'class' => 'btn-check customs-checkbox',
    //'name' => 'status'
], false)->label($filterCustoms->head, [
    'class' => 'btn btn-outline-danger',
    //'for' => 'feed-status',
]); ?>

<?php ActiveForm::end(); ?>

<div class='row' style="margin-bottom: 20px;">
    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" id="map" style="width: 100%; min-height: 568px" data-latitude="<?= $searchCustomsModel->latitude ?>" data-longitude="<?= $searchCustomsModel->longitude ?>"></div>


    <!-- <div class="customs-count">
        <span>Найдено таможенных постов:</span>
        <b><span class="customs-number"></span></b>
    </div> -->
</div>

<!-- <div class="map">
    <div id="map" style="width: 1280px; height: 568px" data-latitude="<?= $searchCustomsModel->latitude ?>" data-longitude="<?= $searchCustomsModel->longitude ?>"></div>
</div> -->
<!-- data-latitude="55.76" data-longitude="37.64" -->