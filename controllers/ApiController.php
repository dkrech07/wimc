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
    public function actionGeocoder($geocode) //: array
    {
        // Yii::$app->response->format = Response::FORMAT_JSON;
        // print((new GeocoderService())->getCoords($geocode));
        // exit;
        // $this->redirect($this->createUrl('contorller/action', $_GET));
        // $this->redirect('/geoapi/?term=' . $geocode);


        return (new GeocoderService())->getCoords($geocode);
    }
}
