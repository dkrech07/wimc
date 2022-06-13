<?php

use yii\helpers\Html;
use yii\helpers\Url;
use TaskForce\utils\NounPluralConverter;
?>



<tr class="statistics_item">
    <td class="custom-param id"><?= Html::encode($model->id); ?></td>
    <td class="custom-param code"><?= Html::encode($model->history_dt_add_search); ?></td>
    <td class="custom-param namt"><?= Html::encode($model->history_text_search); ?></td>
    <td class="custom-param okpo"><?= Html::encode($model->history_latitude); ?></td>
    <td class="custom-param ogrn"><?= Html::encode($model->history_longitude); ?></td>
    <td class="custom-param inn"><?= Html::encode($model->history_nearest_lat); ?></td>
    <td class="custom-param name_all"><?= Html::encode($model->history_nearest_lon); ?></td>
    <td class="custom-param adrtam"><?= Html::encode($model->history_nearest_code); ?></td>
    <td class="custom-param prosf"><?= Html::encode($model->history_distance); ?></td>
    <td class="custom-param telefon"><?= Html::encode($model->history_filter); ?></td>
</tr>