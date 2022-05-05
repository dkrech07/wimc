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
            $preset = "islands#greenIcon";

            if (substr($custom['CODE'], -3) == '000') {
                $preset = "islands#redIcon";
            }

            if (substr($custom['CODE'], 0, 5) == '10009') {
                $preset = "islands#yellowIcon";
            }

            if (substr($custom['CODE'], 0, 3) == '121' || substr($custom['CODE'], 0, 3) == '122' || substr($custom['CODE'], 0, 3) == '123' || substr($custom['CODE'], 0, 3) == '124' || substr($custom['CODE'], 0, 3) == '125') {
                $preset = "islands#blueIcon";
            }

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
                    ],
                    "options" => [
                        "preset" => $preset,
                    ],
                ];
        }

        return json_encode($customs_coords, JSON_UNESCAPED_UNICODE);
    }
}
