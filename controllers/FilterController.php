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
            $form_model->captions = $data['captions'];
        }

        // $form_model_cache = Yii::$app->cache->get('filter_params');

        $customs = (new CustomsFilterService())->getFilteredCustoms($form_model);

        $customs_coords = [
            'main' => [],
            'head' => [],
            'excise' => [],
            'others' => [],
        ];

        function getCustom($custom, $custom_type, $captions = null)
        {
            //linear-gradient(to right, #00AA00, #FFFFFF)
            // linear-gradient(to right, #FF0000, #FFFFFF); color: #FFFFFF',
            // linear-gradient(to right, #0000FF, #FFFFFF); color: #FFFFFF',
            // inear-gradient(to right, #FFd700, #FFFFFF); color: #FFFFFF',

            $custom_color = [
                'main' => 'padding: 3px; background: #00AA00; color: #FFFFFF;',
                'head' => 'padding: 3px; background: #FF0000; color: #FFFFFF;',
                'excise' => 'padding: 3px; background: #0000FF; color: #FFFFFF;',
                'others' => 'padding: 3px; background: #E8B000; color: #FFFFFF;',
            ];

            if ($custom['TELEFON']) {
                $phone_number = preg_replace('~\D+~', '',  $custom['TELEFON']);
                $phone = ' <i class="bi bi-telephone-fill"></i> ' . '<a href="tel:' . '+7' . $phone_number . '">' . '+7' . $custom['TELEFON'] . '</a>';
            } else {
                $phone = '';
            }

            if ($custom['EMAIL']) {
                $email = '<i class="bi bi-envelope-fill"></i> ' . '<a href="mailto:' . $custom['EMAIL'] . '">' . $custom['EMAIL'] . '</a>';
            } else {
                $email = '';
            }

            return [
                "coordinates" => [
                    'lat' => $custom['COORDS_LATITUDE'],
                    'lon' => $custom['COORDS_LONGITUDE'],
                ],
                "code" => $custom['CODE'],
                "properties" => [
                    "balloonContentHeader" => '<div class=ballon_header style="font-size: 12px;' . $custom_color[$custom_type] . '">' . ' <i class="bi bi-geo-alt-fill"></i> ' . $custom['CODE'] . ' ' . $custom['NAMT'] . '</div>',
                    "balloonContentBody" => '<div class=ballon_body>' . $custom['ADRTAM'] . '</div>',
                    "balloonContentFooter" =>


                    '<div class=ballon_footer>' . $phone  . '</div>' .
                        '<div class=ballon_footer>' . $email . '</div>',



                    // "balloonContentFooter" => '<div class=ballon_footer>' . $custom['EMAIL'] . '</div>',



                    // "balloonContentHeader" => $custom['CODE'] . ' ' . $custom['NAMT'],
                    // "balloonContentBody" => $custom['ADRTAM'],
                    // "balloonContentFooter" => $custom['TELEFON'],
                    "iconCaption" => $custom['CODE'] . ' ' . $custom['NAMT'],
                ],
            ];
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

            // }

            // else {
            //     return [
            //         "coordinates" => [
            //             'lat' => $custom['COORDS_LATITUDE'],
            //             'lon' => $custom['COORDS_LONGITUDE'],
            //         ],
            //         "code" => $custom['CODE'],
            //     ];
            // }
        }

        foreach ($customs as $number => $custom) {
            if (substr($custom['CODE'], -3) == '000') {
                $customs_coords['head'][] = getCustom($custom, 'head', $data['captions']);
            } else if (substr($custom['CODE'], 0, 5) == '10009') {
                $customs_coords['excise'][] = getCustom($custom, 'excise', $data['captions']);
            } else if (
                substr($custom['CODE'], 0, 3) == '121'
                || substr($custom['CODE'], 0, 3) == '122'
                || substr($custom['CODE'], 0, 3) == '123'
                || substr($custom['CODE'], 0, 3) == '124'
                || substr($custom['CODE'], 0, 3) == '125'
            ) {
                $customs_coords['others'][] = getCustom($custom, 'others', $data['captions']);
            } else {
                $customs_coords['main'][] = getCustom($custom, 'main', $data['captions']);
            }
        }

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

        return json_encode($customs_coords, JSON_UNESCAPED_UNICODE);
    }
}
