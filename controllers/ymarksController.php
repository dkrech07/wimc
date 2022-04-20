<?php

namespace app\controllers;

use Yii;
use yii\widgets\ActiveForm;
use yii\web\Controller;
use app\models\SearchCustoms;
use app\services\CustomsFilterService;

class YmarksController extends Controller
{
    public function actionAjax() //: array
    {
        $customs = (new CustomsFilterService())->getFilteredCustoms();
        $customs_coords = [];

        foreach ($customs as $number => $custom) {
            // if ($number < 250) {
            $customs_coords[] = [$custom['COORDS_LATITUDE'], $custom['COORDS_LONGITUDE']];
            // }
        }

        // header('Content-Type: text/html; charset=utf-8');

        // $customs_coords = array(
        //     ['лалала', 'nanana'],
        //     ['лалала', 'nanana'],
        // );

        // print_r($customs_coords);
        return json_encode($customs_coords);
        // Yii::$app->response->format = Response::FORMAT_JSON;
        // print((new GeocoderService())->getCoords($geocode));
        // exit;
        // return $result;
    }
}
