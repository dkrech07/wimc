<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\services\CustomsFilterService;
use app\models\FilterCustoms;
use app\services\LogService;

class FilterController extends Controller
{
    public function actionCheckbox()
    {
        $filterCustomsModel = new FilterCustoms();

        if (\Yii::$app->request->isAjax && \Yii::$app->request->post()) {

            $request = Yii::$app->request;
            $data = $request->post();

            $filterCustomsModel->head = $data['head'];
            $filterCustomsModel->excise = $data['excise'];
            $filterCustomsModel->others = $data['others'];
            $filterCustomsModel->captions = $data['captions'];

            $filterCustomsModel->autocomplete = $data['autocomplete'];
            $filterCustomsModel->latitude = $data['latitude'];
            $filterCustomsModel->longitude = $data['longitude'];

            (new LogService())->logIP(Yii::$app->request->userIP);

            $customs = (new CustomsFilterService())->getFilteredCustoms($filterCustomsModel);
            $customs_coords = (new CustomsFilterService())->getCustoms($customs, $filterCustomsModel);
            return json_encode($customs_coords, JSON_UNESCAPED_UNICODE);
            // return json_encode($customs, JSON_UNESCAPED_UNICODE);
        }
    }
}
