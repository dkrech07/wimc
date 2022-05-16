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

            $form_model->main = $data['main'];
            $form_model->head = $data['head'];
            $form_model->excise = $data['excise'];
            $form_model->others = $data['others'];
            // $form_model->captions = $data['captions'];
        }

        // $form_model_cache = Yii::$app->cache->get('filter_params');

        $customs = (new CustomsFilterService())->getFilteredCustoms($form_model);

        // $customs_coords = [
        //     'main' => [],
        //     'head' => [],
        //     'excise' => [],
        //     'others' => [],
        // ];

        $customs_coords = [
            "type" => "FeatureCollection",
            "features" => []
        ];

        // foreach ($customs as $number => $custom) {
        // }

        function getCustom($custom, $custom_type, $number, $captions = null)
        {
            if ($custom_type == 'head') {
                $pointColor = "islands#redIcon";
            } else if ($custom_type == 'excise') {
                $pointColor = "islands#yellowIcon";
            } else if ($custom_type == 'others') {
                $pointColor = "islands#blueIcon";
            } else if ($custom_type == 'main') {
                $pointColor = "islands#greenIcon";
            }

            return
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
                        "preset" => "islands#greenDotIcon",
                    ],
                    "options" => [
                        "preset" => $pointColor,
                    ]
                ];
        }


        foreach ($customs as $number => $custom) {
            if (substr($custom['CODE'], -3) == '000') {
                $custom_type = 'head';
                $customs_coords['features'][] = getCustom($custom, $custom_type, $number); //$data['captions']
            } else if (substr($custom['CODE'], 0, 5) == '10009') {
                $custom_type = 'excise';
                $customs_coords['features'][] = getCustom($custom, $custom_type, $number); // $data['captions']
            } else if (
                substr($custom['CODE'], 0, 3) == '121'
                || substr($custom['CODE'], 0, 3) == '122'
                || substr($custom['CODE'], 0, 3) == '123'
                || substr($custom['CODE'], 0, 3) == '124'
                || substr($custom['CODE'], 0, 3) == '125'
            ) {
                $custom_type = 'others';
                $customs_coords['features'][] = getCustom($custom, $custom_type, $number); // $data['captions']
            } else {
                $custom_type = 'main';
                $customs_coords['features'][] = getCustom($custom, $custom_type, $number); // $data['captions']
            }
        }

        return json_encode($customs_coords, JSON_UNESCAPED_UNICODE);
    }
}


        // function getCustom($custom, $captions)
        // {
        // if ($captions == 1) {
        //     return [
        //         "coordinates" => [
        //             'lat' => $custom['COORDS_LATITUDE'],
        //             'lon' => $custom['COORDS_LONGITUDE'],
        //         ],
        //         "properties" => [
        //             "balloonContentHeader" => $custom['CODE'] . ' ' . $custom['NAMT'],
        //             "balloonContentBody" => $custom['ADRTAM'],
        //             "balloonContentFooter" => $custom['TELEFON'],
        //             "iconCaption" => $custom['CODE'] . ' ' . $custom['NAMT'],
        //         ],
        //     ];
        // } else {

        // }


        // if ($captions == 1) {
        //     return [
        //         "coordinates" => [
        //             'lat' => $custom['COORDS_LATITUDE'],
        //             'lon' => $custom['COORDS_LONGITUDE'],
        //         ],
        //         "code" => $custom['CODE'],
        //         "properties" => [
        //             "balloonContentHeader" => $custom['CODE'] . ' ' . $custom['NAMT'],
        //             "balloonContentBody" => $custom['ADRTAM'],
        //             "balloonContentFooter" => $custom['TELEFON'],
        //             "iconCaption" => $custom['CODE'] . ' ' . $custom['NAMT'],
        //         ],
        //     ];
        // } else {
        //     return [
        //         "coordinates" => [
        //             'lat' => $custom['COORDS_LATITUDE'],
        //             'lon' => $custom['COORDS_LONGITUDE'],
        //         ],
        //         "code" => $custom['CODE'],
        //     ];
        // }
        // }



        // Yii::$app->cache->set('filter_params', $form_model);

        // $customs_coords = [
        //     "type" => "FeatureCollection",
        //     "features" => [],
        //     'customs_count' => count($customs),
        // ];

        // foreach ($customs as $number => $custom) {
        //     $preset = "islands#greenIcon";

        //     if (substr($custom['CODE'], -3) == '000') {
        //         $preset = "islands#redIcon";
        //     }

        //     if (substr($custom['CODE'], 0, 5) == '10009') {
        //         $preset = "islands#yellowIcon";
        //     }

        //     if (substr($custom['CODE'], 0, 3) == '121' || substr($custom['CODE'], 0, 3) == '122' || substr($custom['CODE'], 0, 3) == '123' || substr($custom['CODE'], 0, 3) == '124' || substr($custom['CODE'], 0, 3) == '125') {
        //         $preset = "islands#blueIcon";
        //     }

        //     $customs_coords['features'][] =
        //         [
        //             "type" => "Feature",
        //             "id" => $number,
        //             "geometry" => [
        //                 "type" => "Point",
        //                 "coordinates" => [
        //                     $custom['COORDS_LATITUDE'], $custom['COORDS_LONGITUDE']
        //                 ]
        //             ],
        //             "properties" => [
        //                 "balloonContentHeader" => $custom['CODE'] . ' ' . $custom['NAMT'],
        //                 "balloonContentBody" => $custom['ADRTAM'],
        //                 "balloonContentFooter" => $custom['TELEFON'],
        //                 "iconCaption" => $custom['CODE'] . ' ' . $custom['NAMT'],
        //             ],
        //             "options" => [
        //                 "preset" => $preset,
        //             ],
        //         ];
        // }
