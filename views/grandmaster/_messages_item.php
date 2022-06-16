<?php

use yii\helpers\Html;
use yii\helpers\Url;
use TaskForce\utils\NounPluralConverter;
?>



<tr class="custom-item">
    <td class="search-param"><?= Html::encode($model->id); ?></td>
    <td class="search-param"><?= Html::encode($model->question_dt_add); ?></td>
    <td class="search-param"><?= Html::encode($model->user_name); ?></td>
    <td class="search-param"><?= Html::encode($model->user_email); ?></td>
    <td class="search-param"><?= Html::encode($model->form_content); ?></td>

    <!-- <td id='<?= Html::encode($model->id); ?>' class="custom-param edit edit-param"><i class="edit-param bi bi-pencil-square"></i></td> -->
</tr>