<?php

use yii\helpers\Html;
use yii\helpers\Url;
use TaskForce\utils\NounPluralConverter;
?>



<tr class="statistics_item">
    <td class="custom-param id"><?= Html::encode($model->id); ?></td>
    <td class="custom-param code"><?= Html::encode($model->history_dt_add_geocoder); ?></td>
    <td class="custom-param namt"><?= Html::encode($model->request_text_geocoder); ?></td>
    <td class="custom-param okpo"><?= Html::encode($model->response_text_geocoder); ?></td>
</tr>