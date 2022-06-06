<?php

namespace app\controllers;

use Yii;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\web\Controller;
use app\models\Pages;
use app\models\FilterCustoms;


class ContactsController extends Controller
{
    public function actionIndex()
    {
        // $PagesModel = new Pages();

        $page = Pages::find()
            ->where(['page_url' => 'contacts'])
            ->one();

        $pageTitle = $page->page_name;
        $pageContent = $page->page_content;

        if (!$page->page_name) {
            $pageTitle = 'Страница';
        }

        if (!$page->page_content) {
            $pageContent = 'Тут пока ничего нет';
        }

        return $this->render('index', [
            'pageTitle' => $pageTitle,
            'pageContent' => $pageContent,
        ]);
    }
}
