<?php

use yii\helpers\Html;
use yii\helpers\Url;
use TaskForce\utils\NounPluralConverter;
?>



<tr class="statistics_item">
    <td class="search-param"><?= Html::encode($model->id); ?></td>
    <td class="search-param"><?= Html::encode($model->history_dt_add_geocoder); ?></td>
    <td class="search-param"><?= Html::encode($model->request_text_geocoder); ?></td>
    <td class="search-param"><?= Html::encode($model->response_text_geocoder); ?></td>
</tr>