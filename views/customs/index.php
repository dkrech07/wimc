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
    'options' => ['autocomplete' => 'off'],
]); ?>

<?= $form->field($searchCustomsModel, 'latitude', ['template' => '{input}'])->hiddenInput(['id' => 'latitude']) ?>
<?= $form->field($searchCustomsModel, 'longitude', ['template' => '{input}'])->hiddenInput(['id' => 'longitude']) ?>

<?= $form->field($searchCustomsModel, 'nearest_lat', ['template' => '{input}'])->hiddenInput(['id' => 'latitude']) ?>
<?= $form->field($searchCustomsModel, 'nearest_lon', ['template' => '{input}'])->hiddenInput(['id' => 'longitude']) ?>

<?= $form->field($searchCustomsModel, 'geo')->widget(
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
            'class' => 'form-control'
        ]
    ]

    // [
    //     'clientOptions' => [
    //         // 'source' => Url::to(['autocomplete']),
    //         // 'source' => Url::to(['autocomplete']),
    //         // 'minLength' => '2',

    //         // 'source' => new JsExpression("function (request, response) {

    //         //     $.getJSON('http://localhost/wimc/web/customs/autocomplete', {
    //         //         term: request.term
    //         //     }, response).done(function(json){

    //         //         array = [];
    //         //         json.forEach(item => {
    //         //             array.push(item['display_name']);
    //         //         });



    //         //         console.log('Массив:');
    //         //         console.log(json);
    //         //         // return array;
    //         //     });

    //         //     console.log('Запрос:');
    //         //     console.log(request);
    //         // }"),

    //         'source' => new JsExpression("function(request, response) {
    //             $.getJSON('http://localhost/wimc/web/customs/autocomplete', {
    //                 term: request.term
    //             }, response);
    //         }"),

    //         'minLength' => '2',
    //     ],
    //     'options' => [
    //         'class' => 'form-control'
    //     ]
    // ]
);
?>



<?= Html::submitInput('Найти таможни', ['style' => 'margin-bottom: 25px;', 'class' => 'button button--blue']) ?>


<?php ActiveForm::end(); ?>



<div class="map">
    <div id="map" style="width: 1280px; height: 568px" data-latitude="<?= $searchCustomsModel->latitude ?>" data-longitude="<?= $searchCustomsModel->longitude ?>"></div>
</div>
<!-- data-latitude="55.76" data-longitude="37.64" -->