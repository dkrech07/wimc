<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\services\CustomsFilterService;
use app\models\FilterCustoms;

class FilterController extends Controller
{
    public function actionCheckbox()
    {

        $form_model = new FilterCustoms();

        if (\Yii::$app->request->isAjax && \Yii::$app->request->post()) {

            $request = Yii::$app->request;
            $data = $request->post();

            $form_model->head = $data['head'];
            $form_model->excise = $data['excise'];
            $form_model->others = $data['others'];
            $form_model->captions = $data['captions'];
        }

        $customs = (new CustomsFilterService())->getFilteredCustoms($form_model);

        $customs_coords = [
            "type" => "FeatureCollection",
            "features" => [],
            'customs_count' => count($customs),
        ];

        foreach ($customs as $number => $custom) {
            $customs_coords['features'][] =
                [
                    "type" => "Feature",
                    "id" => $number,
                    "geometry" => [
                        "type" => "Point",
                        "coordinates" => [
                            $custom['COORDS_LATITUDE'], $custom['COORDS_LONGITUDE']
                        ]
                    ],
                    "properties" => [
                        "balloonContentHeader" => $custom['CODE'] . ' ' . $custom['NAMT'],
                        "balloonContentBody" => $custom['ADRTAM'],
                        "balloonContentFooter" => $custom['TELEFON'],
                        "iconCaption" => $custom['CODE'] . ' ' . $custom['NAMT'],
                    ]

                ];
        }

        return json_encode($customs_coords, JSON_UNESCAPED_UNICODE);
    }
}
