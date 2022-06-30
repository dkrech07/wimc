<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\services\CustomsFilterService;
use app\models\FilterCustoms;
use app\models\SearchCustoms;
use app\services\LogService;

class FilterController extends Controller
{
    public function actionCheckbox()
    {

        // autocomplete: 
        // captions: 0
        // excise: 0
        // head: 0
        // latitude: "58.01140625"
        // longitude: "56.20615272817086"
        // main: 1
        // others: 0

        $filterFormModel = new FilterCustoms();
        // $form_model = new SearchCustoms();

        if (\Yii::$app->request->isAjax && \Yii::$app->request->post()) {

            $request = Yii::$app->request;
            $data = $request->post();

            $filterFormModel->main = $data['main'];
            $filterFormModel->head = $data['head'];
            $filterFormModel->excise = $data['excise'];
            $filterFormModel->others = $data['others'];
            $filterFormModel->captions = $data['captions'];

            $filterFormModel->latitude = $data['latitude'];
            $filterFormModel->longitude = $data['longitude'];
            $filterFormModel->autocomplete = $data['autocomplete'];

            $customs_coords = (new CustomsFilterService())->getCustoms($filterFormModel);
            return json_encode($customs_coords, JSON_UNESCAPED_UNICODE);

            // (new LogService())->logIP(Yii::$app->request->userIP);
            // $customs = (new CustomsFilterService())->getFilteredCustoms($filterFormModel);
            // $nearest_point = (new NearestPointService())->getNearestPoint($form_model->latitude, $form_model->longitude, $filter_model);
            // $form_model->nearest_points = $nearest_point['nearestPoints'];
            // $form_model->filter = implode(', ', [$data['main'], $data['head'], $data['excise'], $data['others'], $data['captions']]);
            // (new CustomsFilterService())->getCustom($custom, $custom_type, $captions = null);
        }
    }
}
