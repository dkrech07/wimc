<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="content-block col-10 col-sm-10 col-md-10 col-lg-10 col-xl-10">

    <div class="form-header">
        <?= Html::tag('h3', 'Редактирование страницы: ' . Html::encode($pageFormModel->page_name)) ?>
    </div>

    <?php $form = ActiveForm::begin([
        'id' => 'page-edit',

        // 'encodeErrorSummary' => true,
        // 'errorSummaryCssClass' => 'help-block',

        // 'enableAjaxValidation' => true,

    ]); ?>


    <?= $form->field($pageFormModel, 'id')->textInput(['readonly' => true]) ?>
    <?= $form->field($pageFormModel, 'page_dt_add')->textInput(['readonly' => true]) ?>
    <?= $form->field($pageFormModel, 'page_url')->textInput(['readonly' => true]) ?>
    <?= $form->field($pageFormModel, 'page_user_change')->textInput(['readonly' => true]) ?>
    <?= $form->field($pageFormModel, 'page_name')->textInput() ?>
    <?= $form->field($pageFormModel, 'page_content')->textarea() ?>

    <div class="submit-btn form-group">
        <button type="submit" class="modal-button accept-button">Сохранить</button>
        <button type="button" class="modal-button cancel-button">Отмена</button>
    </div>



    <?php ActiveForm::end(); ?>

</div>