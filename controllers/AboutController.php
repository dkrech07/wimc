<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\Pages;
// use Yii;
// use yii\web\Response;
// use yii\widgets\ActiveForm;
// use app\models\FilterCustoms;


class AboutController extends Controller
{
    public function actionIndex()
    {
        // $PagesModel = new Pages();

        $page = Pages::find()
            ->where(['page_url' => 'about'])
            ->one();

        return $this->render('index', [
            'page' => $page,
        ]);
    }
}
