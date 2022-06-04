<?php

use app\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\jui\AutoComplete;
use yii\web\JsExpression;

AppAsset::register($this);

// if ($cookiePageContent->page_name) {
//     $this->title = $cookiePageContent->page_name;
// }
?>

<?php $cookiePageContent ?>