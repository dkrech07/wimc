<?php

use app\assets\AppAsset;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\captcha\Captcha;
// use yii\helpers\ArrayHelper;
// use yii\jui\AutoComplete;
// use yii\web\JsExpression;
// use yii\helpers\Url;

AppAsset::register($this);

$this->title = $page->page_name;
$this->registerMetaTag(['name' => 'description', 'content' => $page->page_meta_description]);
?>

<h2><?php print($page->page_name) ?></h2>


<!-- <form action="upload.php" class="dropzone"></form> -->


<?php if ($formSent == false) : ?>

    <div class="wrapper question-form col-12 col-sm-12 col-md-8 col-lg-8 col-xl-8">
        <?php $form = ActiveForm::begin([
            'id' => 'question-form',
            // 'enableAjaxValidation' => true,
            'options' => [
                'autocomplete' => 'off',
                'class' => 'dropzone', //form-horizontal
                'style' => 'margin-bottom: 10px;',
            ],
        ]); ?>

        <?= $form->field($questionsFormModel, 'form_content', ['template' => '{label}{input}{error}'])->textarea(['id' => 'form_content', 'rows' => '10']) ?>

        <div class="letters-counter">
            <span class='letters-number'>0</span><span>/1000</span>
        </div>

        <?= $form->field($questionsFormModel, 'user_name', ['template' => '{label}{input}{error}'])->textInput(['id' => 'user_name']) ?>

        <div class="need-answer-group col-12 col-sm-12 col-md-8 col-lg-8 col-xl-8">
            <input class="need-answer" type="checkbox" id="need-answer" name="need-answer">
            <label class="need-answer" for="need-answer">Требуется ответ</label>
        </div>

        <?= $form->field($questionsFormModel, 'user_email', ['template' => '{label}{input}{error}'])->textInput(['id' => 'user_email']) ?>

        <?= $form->field($questionsFormModel, 'verifyCode')->widget(Captcha::className(), [
            'captchaAction' => '/contacts/captcha',
            'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-9">{input}</div></div>',
        ]) ?>

        <p class="form-label">Загрузить файл</p>
        <div class="new-file">
            <?= $form
                ->field($questionsFormModel, 'files[]', ['template' => "{input}{label}", 'labelOptions' => ['class' => 'add-file']])
                ->fileInput(['style' => 'display: none;', 'multiple' => true]) ?>
        </div>

        <?= Html::submitInput('Отправить сообщение', [
            // 'style' => 'margin-top: 30px;',
            'class' => 'question-button btn btn-outline-primary col-12 col-sm-12 col-md-8 col-lg-8 col-xl-8' // btn btn-primary
        ]) ?>

        <?php ActiveForm::end(); ?>
    </div>

<?php else : ?>

    <p>Спасибо! Сообщение успешно отправлено!</p>

<?php endif; ?>

<?php print($page->page_content) ?>