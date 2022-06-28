<?php

namespace app\controllers;

use app\services\GeocoderService;
use yii\web\Controller;


class ApiController extends Controller
{
    /**
     * @param string $geocode
     * 
     * @return array
     */
    public function actionGeocoder($geocode) //: array
    {
        return (new GeocoderService())->getCoords($geocode);
    }
}
