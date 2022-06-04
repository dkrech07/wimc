<?php

namespace app\controllers;

use app\helpers\HelperService as HelpersHelperService;
use Yii;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\web\Controller;
use app\models\LoginForm;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use app\services\HelperService;
use app\services\GrandmasterService;
use app\models\CustomEditForm;
use app\models\PageEditFormModel;
use app\models\Customs;

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
                $this->redirect('grandmaster/admin');
            }
        }
        return $this->render('index', [
            'loginForm' => $loginForm
        ]);
    }

    public function actionAdmin()
    {
        $this->layout = 'grandmaster';
        return $this->render('admin', [
            // 'loginForm' => $loginForm
        ]);
    }

    public function actionCustoms()
    {
        $this->layout = 'grandmaster';

        $customEditFormModel = new CustomEditForm();

        if (\Yii::$app->request->isAjax && \Yii::$app->request->post()) {
            $request = Yii::$app->request;
            $data = $request->post();
            return json_encode((new GrandmasterService())->getEditCustom($data['ID']), JSON_UNESCAPED_UNICODE);
        }

        if (Yii::$app->request->isPost) {
            $customEditFormModel->load(Yii::$app->request->post());

            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($customEditFormModel);
            }

            if ($customEditFormModel->validate()) {
                (new GrandmasterService())->editCustom($customEditFormModel);
                return $this->refresh();
            }
        }


        $query = (new GrandmasterService())->getСustoms();

        // !isset($query) && $query = Customs::find();
        // $categories = Categories::find()->all();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 5,
            ],
            // 'sort' => [
            //     'defaultOrder' => [
            //         'ID' => SORT_DESC,
            //     ]
            // ],
        ]);

        return $this->render('customs', [
            'dataProvider' => $dataProvider,
            'customEditFormModel' => $customEditFormModel
        ]);
    }

    public function actionUsers()
    {
        $this->layout = 'grandmaster';
        return $this->render('users', [
            // 'loginForm' => $loginForm
        ]);
    }

    public function actionStatistics()
    {
        $this->layout = 'grandmaster';
        return $this->render('statistics', [
            // 'loginForm' => $loginForm
        ]);
    }

    public function actionMessages()
    {
        $this->layout = 'grandmaster';
        return $this->render('messages', [
            // 'loginForm' => $loginForm
        ]);
    }

    public function actionPages()
    {

        $pageEditFormModel = new PageEditFormModel();

        $this->layout = 'grandmaster';
        return $this->render('pages', [
            'pageEditFormModel' => $pageEditFormModel
        ]);
    }

    public function beforeAction($action)
    {
        if ($action->id === 'index') {
            if ((new HelperService())->checkAuthorization() !== null) {
                $this->redirect('/grandmaster/admin');
                return false;
            }
        }

        if ($action->id === 'admin') {
            if ((new HelperService())->checkAuthorization() === null) {
                $this->redirect('/grandmaster');
                return false;
            }
        }
        return true;
    }
}
