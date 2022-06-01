<?php

namespace app\controllers;

use Yii;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\web\Controller;
use app\models\SearchCustoms;
use app\models\FilterCustoms;

class GrandmasterController extends Controller
{
    public $layout = 'grandmaster';

    public function actionIndex()
    {
        // $searchCustomsModel = new SearchCustoms();
        // $filterCustoms = new filterCustoms();
        // $form_model = new SearchCustoms();

        // if (Yii::$app->request->isPost) {
        //     $searchCustomsModel->load(Yii::$app->request->post());

        //     if (Yii::$app->request->isAjax) {
        //         Yii::$app->response->format = Response::FORMAT_JSON;
        //         return ActiveForm::validate($searchCustomsModel);
        //     }

        //     if ($searchCustomsModel->validate()) {
        //     }
        // }

        return $this->render('index', [
            // 'searchCustomsModel' => $searchCustomsModel,
            // 'filterCustoms' => $filterCustoms,
        ]);
    }
}
