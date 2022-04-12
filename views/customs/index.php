<!-- https://github.com/dkrech07/291473-task-force-2/blob/master/views/tasks/add.php -->

<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\assets\AutoCompleteAsset;

// AutoCompleteAsset::register($this);
$apiKey = Yii::$app->params['geocoderApiKey'];
$this->registerJsFile("https://api-maps.yandex.ru/2.1/?apikey={$apiKey}&lang=ru_RU");
$this->registerJsFile('js/yandex-map.js');

// $this->registerJsFile('/js/custom.js');
$this->title = 'Where is my customs?';
?>


<?php $form = ActiveForm::begin([
    'id' => 'search-customs',
]); ?>

<?= $form->field($searchCustomsModel, 'ADRTAM')->textInput(['id' => 'autoComplete', 'style' => 'padding-left: 45px;', 'data-api-url' => Url::to(['/geoapi'])]) ?>

<?php ActiveForm::end(); ?>

<div class="map">
    <div id="map" style="width: 725px; height: 346px" data-latitude="55.76" data-longitude="37.64"></div>
</div>