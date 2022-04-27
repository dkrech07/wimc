<?php

<?= $globalSearchForm->field($model, 'cityLabel')->widget(\yii\jui\AutoComplete::className(), [
    'clientOptions' => [
        'source' => new JsExpression('
            function (request, response) {
                $.ajax({
                    url: "/app/print-cities-json",
                    data: {
                        "country_id": countryId,
                        q: request.term
                    },
                    dataType: "json",
                    success: function(data) {
                        response($.map(data.cities, function (rt) {
                            return {
                                label: rt.title,
                                value: rt.id
                            };
                        }));
                    },
                    error: function () {
                        response([]);
                    }
                });
            }
        '),
        'select' => new JsExpression('
            function (event, ui) {
                this.value = ui.item.label;

                $("#globalsearchform-cityid").val(ui.item.value);
                event.preventDefault();
            }
        '),
    ],
    'options' => [
        'class' => 'form-control'
    ]
]) ?>
<?= $globalSearchForm->field($model, 'cityId')->hiddenInput(['value'=> ''])->label(false); ?>