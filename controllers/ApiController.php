<?php

namespace app\controllers;

use Yii;
use yii\web\Response;
use app\services\GeocoderService;
use yii\web\Controller;

class ApiController extends Controller
{
    /**
     * @param string $geocode
     * 
     * @return array
     */
    public function actionGeocoder(string $geocode): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        // print((new GeocoderService())->getCoords($geocode));
        // exit;
        return (new GeocoderService())->getCoords($geocode);
    }
}
