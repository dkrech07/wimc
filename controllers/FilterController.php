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
            // $form_model->head = $data['head'];
            // $form_model->excise = $data['excise'];
            // $form_model->others = $data['others'];
            // $form_model->captions = $data['captions'];
        }

        $customs = (new CustomsFilterService())->getFilteredCustoms($form_model);


        $customs_coords = [
            'main' => [],
            'head' => [],
            'excise' => [],
            'others' => [],
        ];

        function getCustom($custom)
        {
            return [
                "coordinates" => [
                    'lat' => $custom['COORDS_LATITUDE'],
                    'lon' => $custom['COORDS_LONGITUDE'],
                ],
                "code" => $custom['CODE'],
            ];
        }

        foreach ($customs as $number => $custom) {
            if ($form_model['main'] !== 1) {
                $customs_coords['main'][] = getCustom($custom);
            }
        }

        return json_encode($customs_coords, JSON_UNESCAPED_UNICODE);

        // return json_encode($customs_coords, JSON_UNESCAPED_UNICODE);

        // $form_model_cache = Yii::$app->cache->get('filter_params');

        // function getCustom($custom, $captions)
        // {
        //     if ($captions == 1) {
        //         return [
        //             "coordinates" => [
        //                 'lat' => $custom['COORDS_LATITUDE'],
        //                 'lon' => $custom['COORDS_LONGITUDE'],
        //             ],
        //             "properties" => [
        //                 "balloonContentHeader" => $custom['CODE'] . ' ' . $custom['NAMT'],
        //                 "balloonContentBody" => $custom['ADRTAM'],
        //                 "balloonContentFooter" => $custom['TELEFON'],
        //                 "iconCaption" => $custom['CODE'] . ' ' . $custom['NAMT'],
        //             ],
        //         ];
        //     } else {
        //         return [
        //             "coordinates" => [
        //                 'lat' => $custom['COORDS_LATITUDE'],
        //                 'lon' => $custom['COORDS_LONGITUDE'],
        //             ],
        //             "code" => $custom['CODE'],
        //         ];
        //     }
        // }

        // foreach ($customs as $number => $custom) {

        //     if (substr($custom['CODE'], -3) == '000' && $form_model_cache['head'] != 1) {
        //         $customs_coords['head'][] = getCustom($custom, $form_model['captions']);
        //     } else if (substr($custom['CODE'], 0, 5) == '10009' && $form_model_cache['excise'] != 1) {
        //         $customs_coords['excise'][] = getCustom($custom, $form_model['captions']);
        //     } else if (substr($custom['CODE'], 0, 3) == '121' || substr($custom['CODE'], 0, 3) == '122' || substr($custom['CODE'], 0, 3) == '123' || substr($custom['CODE'], 0, 3) == '124' || substr($custom['CODE'], 0, 3) == '125' && $form_model_cache['others'] != 1) {
        //         $customs_coords['others'][] = getCustom($custom, $form_model['captions']);
        //     } else if ($form_model_cache['main'] !== 1) {
        //         $customs_coords['main'][] = getCustom($custom, $form_model['captions']);
        //     }
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

    }
}
