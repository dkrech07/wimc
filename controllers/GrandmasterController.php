<?php

namespace app\controllers;

use app\helpers\HelperService as HelpersHelperService;
use Yii;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\web\Controller;
use app\models\LoginForm;
use yii\filters\AccessControl;
use app\services\HelperService;

use app\models\SearchCustoms;
use app\models\FilterCustoms;

class GrandmasterController extends Controller
{
    // public function behaviors()
    // {
    //     return [
    //         'access' => [
    //             'class' => AccessControl::class,
    //             // 'only' => ['admin'],
    //             'rules' => [
    //                 [
    //                     'allow' => true,
    //                     // 'actions' => ['admin'],
    //                     'matchCallback' => function ($rule, $action) {
    //                         return ((new HelperService())->checkAuthorization() !== null);
    //                     }
    //                 ]
    //             ]
    //         ]
    //     ];
    // }
    // public function behaviors()
    // {
    //     return [
    //         'access' => [
    //             'class' => AccessControl::class,
    //             'only' => ['admin'],
    //             'rules' => [
    //                 [
    //                     'allow' => true,
    //                     'actions' => ['admin'],
    //                     'roles' => ['@']
    //                 ]
    //             ]
    //         ]
    //     ];
    // }

    // public $layout = 'grandmaster';

    public function actionIndex()
    {
        $loginForm = new LoginForm();

        if (Yii::$app->request->getIsPost()) {
            $loginForm->load(\Yii::$app->request->post());

            // if (Yii::$app->request->isAjax) {
            //     Yii::$app->response->format = Response::FORMAT_JSON;

            //     return ActiveForm::validate($loginForm);
            // }

            if ($loginForm->validate()) {
                $user = $loginForm->getUser();
                Yii::$app->user->login($user);
                $this->redirect('http://localhost/wimc/web/grandmaster/admin');
            }
        }
        return $this->render('index', [
            'loginForm' => $loginForm
        ]);
    }

    public function actionAdmin()
    {
        $this->layout = 'grandmaster';
        // print('<br>');
        // print('<br>');
        // print('<br>');
        // print('<br>');
        // print('<br>');
        // print('<br>');
        // print_r((new HelperService())->checkAuthorization());
        // print_r((new HelperService())->checkAuthorization());
        // print($action->id);

        return $this->render('admin', [
            // 'loginForm' => $loginForm
        ]);
    }

    public function beforeAction($action)
    {
        if ($action->id === 'admin') {
            if ((new HelperService())->checkAuthorization() === null) {
                $this->redirect('http://localhost/wimc/web/grandmaster');
                return false;
            }
        }
        return true;
    }
}
