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
        'class' => 'row form-horizontal',
        'style' => 'margin: 20px 0;',
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
        'style' => '',
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
    'style' => 'margin-top: 30px;',
    'class' => 'col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2 btn btn-primary'
]) ?>


<?php ActiveForm::end(); ?>

<div class='row' style="margin-bottom: 20px;">
    <div class="col-12 col-sm-12 col-md-10 col-lg-10 col-xl-10" id="map" style="width: 100%; min-height: 568px" data-latitude="<?= $searchCustomsModel->latitude ?>" data-longitude="<?= $searchCustomsModel->longitude ?>"></div>
    <div class="col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
        <?php $form = ActiveForm::begin([
            'id' => 'tasks-form',
            'fieldConfig' => [
                'template' => "{input}"
            ]
        ]); ?>

        <?= $form
            ->field($filterCustoms, 'head', [
                'template' => "{input}\n{label}",
                'options' => [
                    // 'style' => 'margin-bottom: 20px;',
                    'class' => 'customs-label'
                ]
            ])
            ->checkbox(['id' => 'head', 'class' => 'customs-checkbox'], false); ?>

        <?= $form
            ->field($filterCustoms, 'excise', [
                'template' => "{input}\n{label}",
                'options' => [
                    // 'style' => 'margin-bottom: 20px;',
                    'class' => 'customs-label'
                ]
            ])
            ->checkbox(['id' => 'excise', 'class' => 'customs-checkbox'], false); ?>

        <?= $form
            ->field($filterCustoms, 'others', [
                'template' => "{input}\n{label}",
                'options' => [
                    // 'style' => 'margin-bottom: 20px;',
                    'class' => 'customs-label'
                ]
            ])
            ->checkbox(['id' => 'others', 'class' => 'customs-checkbox'], false); ?>

        <?= $form
            ->field($filterCustoms, 'captions', [
                'template' => "{input}\n{label}",
                'options' => [
                    // 'style' => 'margin-bottom: 20px;',
                    'class' => 'customs-label'
                ]
            ])
            ->checkbox(['id' => 'captions', 'class' => 'customs-checkbox'], false); ?>
        <?php ActiveForm::end(); ?>
    </div>
</div>

<!-- <div class="map">
    <div id="map" style="width: 1280px; height: 568px" data-latitude="<?= $searchCustomsModel->latitude ?>" data-longitude="<?= $searchCustomsModel->longitude ?>"></div>
</div> -->
<!-- data-latitude="55.76" data-longitude="37.64" -->