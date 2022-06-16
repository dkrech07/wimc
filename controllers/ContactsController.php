<?php

namespace app\controllers;

use Yii;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\web\Controller;
use app\models\Pages;
use app\models\QuestionsForm;
use app\services\QuestionService;


class ContactsController extends Controller
{
    public function actionIndex()
    {
        $PagesModel = new Pages();
        $questionsFormModel = new QuestionsForm();
        $formSent = false;

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

        if (Yii::$app->request->getIsPost()) {

            $questionsFormModel->load(Yii::$app->request->post());

            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($questionsFormModel);
            }

            if ($questionsFormModel->validate()) {
                (new QuestionService())->addQuestion($questionsFormModel);
                $formSent = true;
            }
        }

        return $this->render('index', [
            'pageTitle' => $pageTitle,
            'pageContent' => $pageContent,
            'questionsFormModel' => $questionsFormModel,
            'formSent' => $formSent,
            // 'captcha' => [
            //     'class' => 'yii\captcha\CaptchaAction',
            //     'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            // ],
        ]);
    }
}
