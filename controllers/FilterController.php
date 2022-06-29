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

        $form_model = new FilterCustoms();

        if (\Yii::$app->request->isAjax && \Yii::$app->request->post()) {

            $request = Yii::$app->request;
            $data = $request->post();

            $form_model->main = $data['main'];
            $form_model->head = $data['head'];
            $form_model->excise = $data['excise'];
            $form_model->others = $data['others'];
            $form_model->captions = $data['captions'];

            // $form_model->autocomplete = $data['autocomplete'];
            // $form_model->latitude = $data['latitude'];
            // $form_model->longitude = $data['longitude'];

            (new LogService())->logIP(Yii::$app->request->userIP);


            $customs = (new CustomsFilterService())->getFilteredCustoms($form_model);



            // (new CustomsFilterService())->getCustom($custom, $custom_type, $captions = null);

            $customs_coords = (new CustomsFilterService())->getCustoms($customs, $data);

            return json_encode($customs_coords, JSON_UNESCAPED_UNICODE);
        }
    }
}
