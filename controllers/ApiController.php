<?php

namespace app\controllers;

use Yii;
use yii\web\Response;
use app\services\GeocoderService;
use yii\web\Controller;
use yii\helpers\Url;

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

        // if (Yii::$app->request->get('term')) {
        // $model = Company::find()->where(['like', 'name', Yii::$app->request->get('term')])->limit(5)->asArray()->all();
        // foreach ($model as $value) {
        //     $result[] = $value['name'];
        // }


        return (new GeocoderService())->getCoords($geocode);
        // }

        // Yii::$app->response->redirect(Url::to('/customs/geocode?term=' . $geocode));

    }
}
