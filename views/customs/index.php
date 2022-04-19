<!-- https://github.com/dkrech07/291473-task-force-2/blob/master/views/tasks/add.php -->

<?php

use app\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\assets\AutoCompleteAsset;

AppAsset::register($this);
AutoCompleteAsset::register($this);
$apiKey = Yii::$app->params['geocoderApiKey'];
$this->registerJsFile("https://api-maps.yandex.ru/2.1/?apikey={$apiKey}&lang=ru_RU");
$this->registerJsFile('js/yandex-map.js');
// $this->registerJsFile('js/auto-complete.js');


// $this->registerJsFile('/js/custom.js');
$this->title = 'Where is my customs?';

// foreach ($customs as $custom) {
//     print_r($custom);
//     print('<br>');
//     print('<br>');
// }
?>


<?php $form = ActiveForm::begin([
    'id' => 'search-customs',
]); ?>

<?= $form->field($searchCustomsModel, 'ADRTAM')->textInput(['id' => 'autoComplete', 'style' => 'padding-left: 45px;', 'data-api-url' => Url::to(['/geoapi'])]) ?>

<?= $form->field($searchCustomsModel, 'latitude', ['template' => '{input}'])->hiddenInput(['id' => 'latitude']) ?>
<?= $form->field($searchCustomsModel, 'longitude', ['template' => '{input}'])->hiddenInput(['id' => 'longitude']) ?>

<?= Html::submitInput('Найти таможни', ['style' => 'margin-bottom: 25px;', 'class' => 'button button--blue']) ?>


<?php ActiveForm::end(); ?>

<div class="map">
    <div id="map" style="width: 925px; height: 346px" data-latitude="<?= $searchCustomsModel->latitude ?>" data-longitude="<?= $searchCustomsModel->longitude ?>"></div>
</div>
<!-- data-latitude="55.76" data-longitude="37.64" -->