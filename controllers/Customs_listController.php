<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\Pages;
// use Yii;
// use yii\web\Response;
// use yii\widgets\ActiveForm;
// use app\models\FilterCustoms;


class Customs_listController extends Controller
{
    public function actionIndex()
    {
        $page = Pages::find()
            ->where(['page_url' => 'customs_list'])
            ->one();

        return $this->render('index', [
            'page' => $page,
        ]);
    }
}
