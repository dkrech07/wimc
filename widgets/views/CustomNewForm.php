<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<section class="custom-new modal modal-hide form-modal">

    <div class="form-header">
        <?= Html::tag('h3', 'Создание таможенного поста:') ?>
        <i class="close-btn bi bi-x-square"></i>
    </div>

    <?php $form = ActiveForm::begin(['id' => 'custom-new']); ?>

    <?= $form->field($formModel, 'CODE')->textInput() ?>
    <?= $form->field($formModel, 'NAMT')->textInput() ?>
    <?= $form->field($formModel, 'OKPO')->textInput() ?>
    <?= $form->field($formModel, 'OGRN')->textInput() ?>
    <?= $form->field($formModel, 'INN')->textInput() ?>
    <?= $form->field($formModel, 'NAME_ALL')->textInput() ?>
    <?= $form->field($formModel, 'ADRTAM')->textInput() ?>
    <?= $form->field($formModel, 'PROSF')->textInput() ?>
    <?= $form->field($formModel, 'TELEFON')->textInput() ?>
    <?= $form->field($formModel, 'FAX')->textInput() ?>
    <?= $form->field($formModel, 'EMAIL')->textInput() ?>
    <?= $form->field($formModel, 'COORDS_LATITUDE')->textInput() ?>
    <?= $form->field($formModel, 'COORDS_LONGITUDE')->textInput() ?>

    <div class="submit-btn form-group">
        <button type="submit" class="modal-button accept-button">Сохранить</button>
        <button type="button" class="modal-button cancel-button">Отмена</button>
    </div>

    <?php ActiveForm::end(); ?>

</section>