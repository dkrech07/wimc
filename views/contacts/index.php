<?php

use app\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\jui\AutoComplete;
use yii\web\JsExpression;

AppAsset::register($this);

$this->title = $pageTitle;
?>

<h2><?php print($pageTitle) ?></h2>
<?php print($pageContent) ?>