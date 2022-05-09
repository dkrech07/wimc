<!-- https://github.com/dkrech07/291473-task-force-2/blob/master/views/tasks/add.php -->










<div class='row' style="margin-bottom: 20px;">
    <div class="col-12 col-sm-12 col-md-10 col-lg-10 col-xl-10" id="map" style="width: 100%; min-height: 568px" data-latitude="<?= $searchCustomsModel->latitude ?>" data-longitude="<?= $searchCustomsModel->longitude ?>"></div>
    <div class="col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
        <?php $form = ActiveForm::begin([
            'id' => 'tasks-form',
            'fieldConfig' => [
                'template' => "{input}"
            ]
        ]); ?>

        <?= $form
            ->field($filterCustoms, 'head', [
                'template' => "{input}\n{label}",
                'options' => [
                    'style' => 'color: red;',
                    // 'style' => 'margin-bottom: 20px;',
                    'class' => 'customs-label'
                ]
            ])
            ->checkbox(['id' => 'head', 'class' => 'customs-checkbox'], false); ?>

        <?= $form
            ->field($filterCustoms, 'excise', [
                'template' => "{input}\n{label}",
                'options' => [
                    // 'style' => 'margin-bottom: 20px;',
                    'style' => 'color: #cda20b;',
                    'class' => 'customs-label'
                ]
            ])
            ->checkbox(['id' => 'excise', 'class' => 'customs-checkbox'], false); ?>

        <?= $form
            ->field($filterCustoms, 'others', [
                'template' => "{input}\n{label}",
                'options' => [
                    // 'style' => 'margin-bottom: 20px;',
                    'style' => 'color: blue;',
                    'class' => 'customs-label'
                ]
            ])
            ->checkbox(['id' => 'others', 'class' => 'customs-checkbox'], false); ?>

        <?= $form
            ->field($filterCustoms, 'captions', [
                'template' => "{input}\n{label}",
                'options' => [
                    // 'style' => 'margin-bottom: 20px;',
                    'class' => 'customs-label'
                ]
            ])
            ->checkbox(['id' => 'captions', 'class' => 'customs-checkbox'], false); ?>
        <?php ActiveForm::end(); ?>

        <div class="customs-count">
            <span>Найдено таможенных постов:</span>
            <b><span class="customs-number"></span></b>
        </div>
    </div>
</div>

<!-- <div class="map">
    <div id="map" style="width: 1280px; height: 568px" data-latitude="<?= $searchCustomsModel->latitude ?>" data-longitude="<?= $searchCustomsModel->longitude ?>"></div>
</div> -->
<!-- data-latitude="55.76" data-longitude="37.64" -->