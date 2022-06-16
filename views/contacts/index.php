<?php

use app\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\jui\AutoComplete;
use yii\web\JsExpression;
use yii\captcha\Captcha;

AppAsset::register($this);

$this->title = $pageTitle;
?>

<h2><?php print($pageTitle) ?></h2>

<?php if ($formSent == false) : ?>

    <div class="wrapper question-form col-12 col-sm-12 col-md-8 col-lg-8 col-xl-8">
        <?php $form = ActiveForm::begin([
            'id' => 'question-form',
            'enableAjaxValidation' => true,
            'options' => [
                'autocomplete' => 'off',
                'class' => '', //form-horizontal
                'style' => 'margin-bottom: 10px;',
            ],
        ]); ?>

        <?= $form->field($questionsFormModel, 'user_name', ['template' => '{label}{input}'])->textInput(['id' => 'user_name']) ?>
        <?= $form->field($questionsFormModel, 'user_email', ['template' => '{label}{input}'])->textInput(['id' => 'user_email']) ?>
        <?= $form->field($questionsFormModel, 'form_content', ['template' => '{label}{input}'])->textInput(['id' => 'form_content']) ?>

        <!-- <?= $form->field($questionsFormModel, 'verifyCode')->widget(Captcha::className()) ?> -->

        <?= Html::submitInput('Отправить сообщение', [
            // 'style' => 'margin-top: 30px;',
            'class' => 'question-button btn btn-outline-primary col-12 col-sm-12 col-md-8 col-lg-8 col-xl-8' // btn btn-primary
        ]) ?>

        <?php ActiveForm::end(); ?>
    </div>

<?php else : ?>

    <p>Спасибо! Сообщение успешно отправлено!</p>

<?php endif; ?>

<?php print($pageContent) ?>