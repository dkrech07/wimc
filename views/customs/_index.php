<!-- https://github.com/dkrech07/291473-task-force-2/blob/master/views/tasks/add.php -->

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
$this->registerJsFile('js/yandex-map.js');

$this->title = 'Where is my customs?';
?>
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

    <?= $form->field($searchCustomsModel, 'geo', [
        'template' => "{label}\n{input}",
        'options' => [
            // 'style' => 'margin-bottom: 10px;',
            'class' => 'col-12 col-sm-12 col-md-9 col-lg-9 col-xl-9',
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

                        let p = document.createElement("p");

                        response($.map(data, function (geo) {
                            // console.log(label);

                            return {    
                            
                                label: "<b>" + "test" + "</b>",
                                value: [geo.lat, geo.lon]
                            };
                        }));

                        // var searchResultsContainer = document.querySelector(".ui-menu");
                        // var searchResulesElements = searchResultsContainer.querySelectorAll(".ui-menu-item > div");
                        
                        // searchResulesElements.forEach(item => {
                        //     console.log(item["innerText"]);

                        // });
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
            'attribute' => 'color',
            'options' => [
                // 'autoFill' => true, //autocomplete-input-bg-arrow
                'class' => 'form-control',
                'minLength' => '3',
                'maxlength' => '50',
                'placeholder' => 'Например, Смоленск, Лавочкина, 54',
            ],
            // 'options' =>
            // [
            //     'placeholder' => 'Floor',
            //     'class' => 'form-control autocomplete-input-bg-arrow ',

            //     'onclick' => "(function ( ) {
            //           $( '#customer-floor' ).autocomplete( 'search', '' );
            //                     })();",

            //     'onfocus' => "(function ( ) {
            //           $( '#customer-floor' ).autocomplete( 'search', '' );
            //                     })();",
            // ],
        ]
    );
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
<!-- <input type="checkbox" class="btn-check btn-sm" id="btn-check-outlined" autocomplete="off">
    <label class="btn btn-outline-danger" for="btn-check-outlined">Головные таможни</label><br>

    <input type="checkbox" class="btn-check" id="btn-check-outlined" autocomplete="off">
    <label class="btn btn-outline-warning" for="btn-check-outlined">Посты акцизной таможни</label><br>

    <input type="checkbox" class="btn-check" id="btn-check-outlined" autocomplete="off">
    <label class="btn btn-outline-primary" for="btn-check-outlined">Прочие посты</label><br>

    <input type="checkbox" class="btn-check " id="btn-check-outlined" autocomplete="off">
    <label class="btn btn-outline-danger" for="btn-check-outlined">Подписи ко всем меткам</label><br> -->



<div class="wrapper">
    <p class="map-label">
        Результат поиска на карте:
    </p>
    <div class='row' style="margin-bottom: 20px;">

        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" id="map" style="width: 100%;" data-latitude="<?= $searchCustomsModel->latitude ?>" data-longitude="<?= $searchCustomsModel->longitude ?>">
            <button type="button" class="zoom-out btn btn-light"><i class="bi bi-arrow-counterclockwise"></i></button>
        </div>


        <!-- <div class="customs-count">
        <span>Найдено таможенных постов:</span>
        <b><span class="customs-number"></span></b>
    </div> -->
    </div>
</div>
<!-- <div class="map">
    <div id="map" style="width: 1280px; height: 568px" data-latitude="<?= $searchCustomsModel->latitude ?>" data-longitude="<?= $searchCustomsModel->longitude ?>"></div>
</div> -->
<!-- data-latitude="55.76" data-longitude="37.64" -->