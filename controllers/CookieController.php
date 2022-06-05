<?php

namespace app\controllers;

use Yii;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\web\Controller;
use app\models\Pages;
use app\models\FilterCustoms;


class CookieController extends Controller
{
    public function actionIndex()
    {
        // $PagesModel = new Pages();

        $pageCookie = Pages::find()
            ->where(['page_url' => 'cookie'])
            ->one();

        $cookiePageContent = $pageCookie->page_content;

        if (!$pageCookie->page_content) {
            $cookiePageContent = 'Тут пока ничего нет';
        }
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
            'cookiePageContent' => $cookiePageContent,
        ]);
    }
}
