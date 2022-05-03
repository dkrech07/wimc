<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\SearchCustoms;
use app\services\GeocoderService;
use app\services\NearestPointService;


class SearchController extends Controller
{
    public function actionAutocomplete()
    {
        if (Yii::$app->request->get('term')) {
            return (new GeocoderService())->getCoords(Yii::$app->request->get('term'));
        }
    }

    public function actionSearch()
    {

        $form_model = new SearchCustoms();
        if (\Yii::$app->request->isAjax) {
            // return 'Запрос принят!';
        }
        if ($form_model->load(\Yii::$app->request->post())) {
            $nearest_point = (new NearestPointService())->getNearestPoint($form_model->latitude, $form_model->longitude);

            $form_model->nearest_lat = $nearest_point['nearestPoint']['x'];
            $form_model->nearest_lon = $nearest_point['nearestPoint']['y'];
            $form_model->distance = $nearest_point['distance'] * 100000;

            return json_encode($form_model, JSON_UNESCAPED_UNICODE); // Отсюда приходят данные в модель формы на фронт;
        }
    }
}
