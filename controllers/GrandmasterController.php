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
use app\models\CustomSearchForm;

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

    public function actionCustoms($id = null)
    {

        //trash-start

        // $pageSize = 50;
        // if (\Yii::$app->request->isAjax && \Yii::$app->request->post()) {
        //     $request = Yii::$app->request;
        //     $data = $request->post();
        // $pagination = [
        //     'pageSize' => 50,
        // ];

        // if (key($data) == 'allCustomsBtn') {
        //     if ($data['allCustomsBtn'] == 1) {
        //         $pagination = false;
        //         return json_encode(($data), JSON_UNESCAPED_UNICODE);

        //         // return $this->refresh();
        //     } else {
        //         $pagination = true;
        //     }
        // }

        // if (\Yii::$app->request->isAjax) {
        //     if (key($data) == 'allCustomsBtn') {
        //         if ($data['allCustomsBtn'] == 1) {
        //             $pagination = false;
        //             return json_encode(($data), JSON_UNESCAPED_UNICODE);

        //             // return $this->refresh();
        //         }
        //     }
        // } else {
        // $pagination = [
        //     'pageSize' => 50,
        // ];
        // }

        // 'pagination' => $pagination,
        // 'sort' => [
        //     'defaultOrder' => [
        //         'ID' => SORT_DESC,
        //     ]
        // ],

        // trash-end

        $this->layout = 'grandmaster';

        $customEditFormModel = new CustomEditForm();
        $customSearchFormModel = new CustomSearchForm();

        //&& \Yii::$app->request->post()

        if (\Yii::$app->request->isAjax) {
            $request = Yii::$app->request;
            $data = $request->post();

            // Если пришел ID, отдаю найденный пост для просмотра/редактирования
            if (key($data) == 'ID') {
                return json_encode((new GrandmasterService())->getEditCustom($data['ID']), JSON_UNESCAPED_UNICODE);
            }

            // Если пришли параметры CODE или NAME, отдаю результат поиска
            if (key($data) == 'CODE' || key($data) == 'NAMT') {

                // print_r($data);
                // exit;

                $customSearchFormModel->CODE = $data['CODE'];
                $customSearchFormModel->NAMT = $data['NAMT'];

                // return $this->redirect('customs?=search');

                // return $this->render('customs', [
                //     'dataProvider' => $dataProvider,
                //     'customEditFormModel' => $customEditFormModel,
                //     'customSearchFormModel' => $customSearchFormModel,
                // ]);

                // return json_encode($query, JSON_UNESCAPED_UNICODE);
            }
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

        !isset($query) && $query = (new GrandmasterService())->getСustoms();
        // print_r($query);
        // exit;

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 50,
            ],
        ]);

        return $this->render('customs', [
            'dataProvider' => $dataProvider,
            'customEditFormModel' => $customEditFormModel,
            'customSearchFormModel' => $customSearchFormModel,
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

    public function actionPages($id = null)
    {
        $this->layout = 'grandmaster';

        if (!$id) {
            return $this->render('allpages', [
                // 'pageFormModel' => $pageFormModel
            ]);
        } else {
            $pageFormModel = (new GrandmasterService())->getEditPage($id);
            $pageEditFormModel = new PageEditFormModel();

            if (Yii::$app->request->getIsPost()) {

                $pageEditFormModel->load(Yii::$app->request->post());

                if (Yii::$app->request->isAjax) {
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return ActiveForm::validate($pageEditFormModel);
                }

                if ($pageEditFormModel->validate()) {
                    (new GrandmasterService())->editPage($pageEditFormModel);
                    return $this->refresh();
                }
            }

            return $this->render('pages', [
                'pageFormModel' => $pageFormModel
            ]);
        }
    }

    public function beforeAction($action)
    {
        if ($action->id === 'index') {
            if ((new HelperService())->checkAuthorization() !== null) {
                $this->redirect('/grandmaster/admin');
                return false;
            }
        }

        if ($action->id !== 'index') {
            if ((new HelperService())->checkAuthorization() === null) {
                $this->redirect('/grandmaster');
                return false;
            }
        }
        return true;
    }
}
