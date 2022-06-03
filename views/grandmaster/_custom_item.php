<?php

use yii\helpers\Html;
use yii\helpers\Url;
use TaskForce\utils\NounPluralConverter;
?>



<tr class="custom-item">
    <td class="custom-param id"><?= Html::encode($model->ID); ?></td>
    <td class="custom-param code"><?= Html::encode($model->CODE); ?></td>
    <td class="custom-param namt"><?= Html::encode($model->NAMT); ?></td>
    <td class="custom-param okpo"><?= Html::encode($model->OKPO); ?></td>
    <td class="custom-param ogrn"><?= Html::encode($model->OGRN); ?></td>
    <td class="custom-param inn"><?= Html::encode($model->INN); ?></td>
    <td class="custom-param name_all"><?= Html::encode($model->NAME_ALL); ?></td>
    <td class="custom-param adrtam"><?= Html::encode($model->ADRTAM); ?></td>
    <td class="custom-param prosf"><?= Html::encode($model->PROSF); ?></td>
    <td class="custom-param telefon"><?= Html::encode($model->TELEFON); ?></td>
    <td class="custom-param fax"><?= Html::encode($model->FAX); ?></td>
    <td class="custom-param email"><?= Html::encode($model->EMAIL); ?></td>
    <td class="custom-param coords_latitude"><?= Html::encode($model->COORDS_LATITUDE); ?></td>
    <td class="custom-param coords_longitude"><?= Html::encode($model->COORDS_LONGITUDE); ?></td>
    <td id='<?= Html::encode($model->ID); ?>' class="custom-param edit"><i class="bi bi-pencil-square"></i></td>
</tr>