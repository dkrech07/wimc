<?php

namespace app\controllers;

use Yii;
use yii\web\Response;
use app\services\GeocoderService;
use yii\web\Controller;
use app\services\CustomsFilterService;


class AjaxController extends Controller
{
    // /**
    //  * @param string $geocode
    //  * 
    //  * @return array
    //  */
    public function actionAjax() //: array
    {
        // Yii::$app->response->format = Response::FORMAT_JSON;
        // // print((new GeocoderService())->getCoords($geocode));
        // // exit;
        // return (new GeocoderService())->getCoords($geocode);
        return (new CustomsFilterService())->getFilteredCustoms();
    }
}
