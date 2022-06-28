<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;

?>

<div class="content-block col-10 col-sm-10 col-md-10 col-lg-10 col-xl-10">

    <div class="form-header">
        <?= Html::tag('h3', 'Выберите страницу для редактирования:') ?>
    </div>

    <ul class="pages-edit-list">
        <li class="page-edit">
            <a href="/grandmaster/pages/?id=whs">Карта СВХ</a>
        </li>
        <li class="page-edit">
            <a href="/grandmaster/pages/?id=customs_list">Справочник постов</a>
        </li>
        <li class="page-edit">
            <a href="/grandmaster/pages/?id=about">Как это работает</a>
        </li>
        <li class="page-edit">
            <a href="/grandmaster/pages/?id=contacts">Связаться с нами</a>
        </li>
        <li class="page-edit">
            <a href="/grandmaster/pages/?id=cookie">Cookie</a>
        </li>
        <li class="page-edit">
            <a href="/grandmaster/pages/?id=cookie_message">Сообщение об использовании cookie</a>
        </li>
    </ul>

</div>