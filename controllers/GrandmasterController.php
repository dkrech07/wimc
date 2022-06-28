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
use app\models\CustomNewForm;
use app\models\PageEditFormModel;
use app\models\CustomSearchForm;
use app\models\HistorySearch;
use app\models\HistoryGeocoder;
use app\models\HistoryIp;
use app\models\Questions;

use app\models\Customs;

use app\models\SearchCustoms;
use app\models\FilterCustoms;
use app\services\QuestionService;
use Symfony\Component\Console\Question\Question;

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

    public function actionCustoms($ALL = null, $CODE = null, $NAMT = null)
    {
        $this->layout = 'grandmaster';

        $customEditFormModel = new CustomEditForm();
        $customSearchFormModel = new CustomSearchForm();
        $customNewFormModel = new customNewForm();


        if (\Yii::$app->request->isAjax && \Yii::$app->request->post()) {
            $request = Yii::$app->request;
            $data = $request->post();

            // Если пришел ID, отдаю найденный пост для просмотра/редактирования
            if (key($data) == 'CUSTOM_ID') {
                return json_encode((new GrandmasterService())->getEditCustom($data['CUSTOM_ID']), JSON_UNESCAPED_UNICODE);
            }

            if (key($data) == 'CUSTOM_DELETE') {
                (new GrandmasterService())->deleteCustom($data['CUSTOM_DELETE']);
                $this->refresh();
            }
        }

        $customSearchFormModel->CODE = $CODE;
        $customSearchFormModel->NAMT = $NAMT;

        $query = (new GrandmasterService())->getSearchCusom($customSearchFormModel);

        if (Yii::$app->request->isPost) {
            if (Yii::$app->request->post('CustomNewForm')) {
                $customNewFormModel->load(Yii::$app->request->post());
                if (Yii::$app->request->isAjax) {
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return ActiveForm::validate($customNewFormModel);
                }
                if ($customNewFormModel->validate()) {
                    (new GrandmasterService())->addNewCustom($customNewFormModel);
                    return $this->refresh();
                }
            }

            if (Yii::$app->request->post('CustomEditForm')) {
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
        }

        if ($ALL === 'all') {
            $pagination = false;
        } else {
            $pagination = ['pageSize' => 50];
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination,
            'sort' => [
                'defaultOrder' => [
                    'ID' => SORT_DESC,
                ]
            ],
        ]);

        return $this->render('customs', [
            'dataProvider' => $dataProvider,
            'customEditFormModel' => $customEditFormModel,
            'customNewFormModel' => $customNewFormModel,
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

    public function actionStatistics($id = 'search')
    {

        $this->layout = 'grandmaster';


        if ($id == 'search') {
            $query = HistorySearch::find();
            $statisticsItem = '_search_item';
        } else if ($id == 'geocoder') {
            $query = HistoryGeocoder::find();
            $statisticsItem = '_geocoder_item';
        } else if ($id == 'ip') {
            $query = HistoryIp::find();
            $statisticsItem = '_ip_item';
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 50,
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
        ]);

        return $this->render('statistics', [
            'statisticsItem' => $statisticsItem,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionMessages()
    {
        $query = Questions::find()
            ->joinWith('questionsFiles');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 50,
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
        ]);


        $this->layout = 'grandmaster';
        return $this->render('messages', [
            'dataProvider' => $dataProvider
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
