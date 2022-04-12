<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\SearchCustoms;

class CustomsController extends Controller
{
    public function actionIndex()
    {
        $searchCustomsModel = new SearchCustoms();

        return $this->render('index', [
            'searchCustomsModel' => $searchCustomsModel,
            // 'cities' => $cities,
        ]);
    }
}
