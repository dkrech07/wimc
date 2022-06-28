<?php

use yii\helpers\Html;
use yii\helpers\Url;
use TaskForce\utils\NounPluralConverter;
?>



<tr class="custom-item">
    <td class="search-param"><?= Html::encode($model->id); ?></td>
    <td class="search-param"><?= Html::encode($model->history_dt_add_ip); ?></td>
    <td class="search-param"><?= Html::encode($model->history_ip); ?></td>
</tr>