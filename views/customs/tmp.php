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
// $this->registerJsFile('js/auto-complete.js');


// $this->registerJsFile('/js/custom.js');
$this->title = 'Where is my customs?';
?>


<?php $form = ActiveForm::begin([
    'id' => 'search-customs',
    'enableAjaxValidation' => true,
    'options' => [
        'autocomplete' => 'off',
        'class' => 'row form-horizontal',
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
        'class' => 'col-12 col-sm-12 col-md-8 col-lg-8 col-xl-8'
    ]
])->widget(
    AutoComplete::className(),
    [
        'clientOptions' => [
            'source' => new JsExpression('
            function (request, response) {
                $.ajax({
                    url: "/customs/autocomplete",
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
                                // dataset: [geo.lat, geo.lon] // geo.display_name 
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

                    // $("#latitude").val(ui.item.value["ui.item.value"]);
                    // $("#longitude").val(ui.item.value["ui.item.value"]);

                    $("#latitude").val(geo[0]);
                    $("#longitude").val(geo[1]);
                
                    event.preventDefault();
                }
            '),
        ],
        'options' => [
            'class' => 'form-control',
        ]
    ]
);
?>



<?= Html::submitInput('Найти таможни', ['class' => 'col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2 btn btn-primary']) ?>

<!-- btn btn-primary -->
<!-- 'style' => 'margin-bottom: 25px;',  -->


<?php ActiveForm::end(); ?>

<div class='row'>
    <div class="col-12 col-sm-12 col-md-10 col-lg-10 col-xl-10" id="map" style="width: 1280px; height: 568px" data-latitude="<?= $searchCustomsModel->latitude ?>" data-longitude="<?= $searchCustomsModel->longitude ?>"></div>
    <div class="col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2"></div>
</div>

<!-- <div class="map">
</div> -->
<!-- data-latitude="55.76" data-longitude="37.64" -->