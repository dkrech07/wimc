<?php

use app\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\jui\AutoComplete;
use yii\web\JsExpression;

AppAsset::register($this);

$this->title = 'Grandmaster';
?>

<div class="row">
    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'enableAjaxValidation' => true,
        // 'fieldConfig' => [
        //     'labelOptions' => ['class' => 'form-modal-description'],
        //     'inputOptions' => ['class' => 'enter-form-email input input-middle']
        // ],
        'options' => [
            'autocomplete' => 'off',
            'class' => 'col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6', //form-horizontal
        ],
    ]); ?>

    <?= $form->field(
        $loginForm,
        'login',
        [
            // 'options' => [
            //     'class' => 'col-8 col-sm-8 col-md-8 col-lg-8 col-xl-8',
            // ],
        ]
    )->textInput([
        'id' => 'login',
        'class' => 'form-control',
        // 'required' => true,
    ]) ?>

    <?= $form->field($loginForm, 'password', [
        // 'options' => [
        //     'class' => 'col-8 col-sm-8 col-md-8 col-lg-8 col-xl-8',
        // ],
    ])->passwordInput(
        [
            'id' => 'password',
            'class' => 'form-control login',
            // 'required' => true,
        ]
    ) ?>

    <?= Html::submitButton('Войти', ['class' => 'btn btn-primary col-12']) ?>

    <!-- col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 -->

    <?php $form = ActiveForm::end(); ?>

</div>