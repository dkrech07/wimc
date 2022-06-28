<?php

use yii\helpers\Html;
use yii\helpers\Url;
use TaskForce\utils\NounPluralConverter;
?>



<tr class="statistics_item">
    <td class="search-param"><?= Html::encode($model->id); ?></td>
    <td class="search-param"><?= Html::encode($model->history_dt_add_search); ?></td>
    <td class="search-param"><?= Html::encode($model->history_text_search); ?></td>
    <td class="search-param"><?= Html::encode($model->history_latitude); ?></td>
    <td class="search-param"><?= Html::encode($model->history_longitude); ?></td>
    <td class="search-param"><?= Html::encode($model->history_nearest_lat); ?></td>
    <td class="search-param"><?= Html::encode($model->history_nearest_lon); ?></td>
    <td class="search-param"><?= Html::encode($model->history_nearest_code); ?></td>
    <td class="search-param"><?= Html::encode($model->history_distance); ?></td>
    <td class="search-param"><?= Html::encode($model->history_filter); ?></td>
</tr>