<?php

use app\assets\GrandmasterAsset;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

// use yii\helpers\Url;
// use yii\helpers\ArrayHelper;
// use yii\jui\AutoComplete;
// use yii\web\JsExpression;

GrandmasterAsset::register($this);

$this->title = 'Grandmaster';
?>

<div class="row">
    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        // 'enableAjaxValidation' => true,
        // 'fieldConfig' => [
        //     'labelOptions' => ['class' => 'form-modal-description'],
        //     'inputOptions' => ['class' => 'enter-form-email input input-middle']
        // ],
        'options' => [
            // 'autocomplete' => 'off',
            'class' => 'col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6', //form-horizontal
        ],
    ]); ?>

    <?= $form->field($loginForm, 'login')->input('login') ?>
    <?= $form->field($loginForm, 'password')->passwordInput() ?>



    <?= Html::submitButton('Войти', ['class' => 'btn btn-primary col-12']) ?>

    <!-- col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 -->

    <?php $form = ActiveForm::end(); ?>

</div>