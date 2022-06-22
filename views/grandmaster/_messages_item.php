<?php

use yii\helpers\Html;
use app\services\HelperService;
use yii\helpers\Url;
use TaskForce\utils\NounPluralConverter;
?>



<tr class="custom-item">
    <td class="search-param"><?= Html::encode($model->id); ?></td>
    <td class="search-param"><?= Html::encode($model->question_dt_add); ?></td>
    <td class="search-param"><?= Html::encode($model->user_name); ?></td>
    <td class="search-param"><?= Html::encode($model->user_email); ?></td>
    <td class="search-param"><?= Html::encode($model->form_content); ?></td>

    <td class="search-param">
        <?php foreach ($model->questionsFiles as $questionFile) : ?>
            <p class="question-file"><a target="_blank" href="<?= '/upload/files/' . $questionFile->file_link ?>"> <?= Html::encode($questionFile->file_link); ?></a>
                <span><?= (new HelperService())->getFileSize($questionFile->file_link) ?> Кб</span>
            </p>
        <?php endforeach; ?>
    </td>

</tr>