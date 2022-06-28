<?php

use app\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\jui\AutoComplete;
use yii\web\JsExpression;

AppAsset::register($this);

$this->title = $page->page_name;
$this->registerMetaTag(['name' => 'description', 'content' => $page->page_meta_description]);
?>

<h2><?php print($page->page_name) ?></h2>
<?php print($page->page_content) ?>