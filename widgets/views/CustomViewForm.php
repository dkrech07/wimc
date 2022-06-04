<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<section class="custom-view modal modal-hide form-modal">

    <div class="form-header">
        <?= Html::tag('h3', 'Просмотр данных таможенного поста:') ?>
        <i class="close-btn bi bi-x-square"></i>
    </div>

    <?php $form = ActiveForm::begin(['id' => 'custom-view']); ?>

    <?= $form->field($formModel, 'ID')->textInput(['readonly' => true]) ?>
    <?= $form->field($formModel, 'CODE')->textInput(['readonly' => true]) ?>
    <?= $form->field($formModel, 'NAMT')->textInput(['readonly' => true]) ?>
    <?= $form->field($formModel, 'OKPO')->textInput(['readonly' => true]) ?>
    <?= $form->field($formModel, 'OGRN')->textInput(['readonly' => true]) ?>
    <?= $form->field($formModel, 'INN')->textInput(['readonly' => true]) ?>
    <?= $form->field($formModel, 'NAME_ALL')->textInput(['readonly' => true]) ?>
    <?= $form->field($formModel, 'ADRTAM')->textInput(['readonly' => true]) ?>
    <?= $form->field($formModel, 'PROSF')->textInput(['readonly' => true]) ?>
    <?= $form->field($formModel, 'TELEFON')->textInput(['readonly' => true]) ?>
    <?= $form->field($formModel, 'FAX')->textInput(['readonly' => true]) ?>
    <?= $form->field($formModel, 'EMAIL')->textInput(['readonly' => true]) ?>
    <?= $form->field($formModel, 'COORDS_LATITUDE')->textInput(['readonly' => true]) ?>
    <?= $form->field($formModel, 'COORDS_LONGITUDE')->textInput(['readonly' => true]) ?>

    <div class="submit-btn form-group">
        <button type="button" class="modal-button cancel-button">Закрыть</button>
    </div>

    <?php ActiveForm::end(); ?>

</section>