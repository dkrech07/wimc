<?php

namespace app\controllers;

use yii\web\Controller;

class CustomsController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index', [
            // 'model' => $RegistrationModel,
            // 'cities' => $cities,
        ]);
    }
}
