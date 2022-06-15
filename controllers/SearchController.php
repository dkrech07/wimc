<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\SearchCustoms;
use app\services\GeocoderService;
use app\services\NearestPointService;
use app\services\LogService;
use app\models\FilterCustoms;

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
        $filter_model = new FilterCustoms();

        if (\Yii::$app->request->isAjax && \Yii::$app->request->post()) {
            $request = Yii::$app->request;
            $data = $request->post();

            $form_model->latitude = $data['latitude'];
            $form_model->longitude = $data['longitude'];
            $form_model->autocomplete = $data['autocomplete'];

            if (!$data['latitude'] || !$data['longitude']) {
                $form_model = null;
                return json_encode($form_model, JSON_UNESCAPED_UNICODE); // Отсюда приходят данные в модель формы на фронт;
            }

            // if (!$form_model->validate()) {
            //     $errors = $form_model->getErrors();

            //     return json_encode($errors, JSON_UNESCAPED_UNICODE); // Отсюда приходят данные в модель формы на фронт;
            // }

            $filter_model->main = $data['main'];
            $filter_model->head = $data['head'];
            $filter_model->excise = $data['excise'];
            $filter_model->others = $data['others'];
            $filter_model->captions = $data['captions'];

            $nearest_point = (new NearestPointService())->getNearestPoint($form_model->latitude, $form_model->longitude, $filter_model);

            $form_model->filter = implode(', ', [$data['main'], $data['head'], $data['excise'], $data['others'], $data['captions']]);
            $form_model->nearest_lat = $nearest_point['nearestPoint']['x'];
            $form_model->nearest_lon = $nearest_point['nearestPoint']['y'];
            $form_model->distance = $nearest_point['distance'] * 100000;
            $form_model->nearest_code = $nearest_point['nearestPoint']['code'];

            (new LogService())->logSearch($form_model);

            return json_encode($form_model, JSON_UNESCAPED_UNICODE); // Отсюда приходят данные в модель формы на фронт;
        }
    }
}
