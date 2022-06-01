<?php

namespace app\controllers;

use Yii;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\web\Controller;
use app\models\LoginForm;
use app\models\SearchCustoms;
use app\models\FilterCustoms;

class GrandmasterController extends Controller
{
    public $layout = 'grandmaster';

    public function actionIndex()
    {

        $loginForm = new LoginForm();

        if (Yii::$app->request->getIsPost()) {
            $loginForm->load(\Yii::$app->request->post());

            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($loginForm);
            }

            if ($loginForm->validate()) {
                $user = $loginForm->getUser();
                Yii::$app->user->login($user);

                $this->redirect('/tasks/index');
            }
        }
        return $this->render('index', [
            'loginForm' => $loginForm
        ]);
    }
}
