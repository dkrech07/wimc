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
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                // 'class' => 'yii\captcha\CaptchaAction',
                'class' => 'app\services\NumericCaptcha',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        $questionsFormModel = new QuestionsForm();
        $formSent = false;

        $page = Pages::find()
            ->where(['page_url' => 'contacts'])
            ->one();

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
            'page' => $page,
            'questionsFormModel' => $questionsFormModel,
            'formSent' => $formSent,
        ]);
    }
}
