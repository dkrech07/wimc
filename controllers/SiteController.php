<?php

namespace app\controllers;

use Yii;
use app\models\RegistrationForm;
use app\models\Cities;
use app\services\UserService;
use app\services\AuthService;
use yii\web\Controller;
use TaskForce\utils\CustomHelpers;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class SiteController extends Controller
{
    public function actionLogout()
    {
        \Yii::$app->user->logout();
        // return $this->goHome();
        $this->redirect('http://localhost/wimc/web/grandmaster');
    }

    // public function behaviors()
    // {
    //     return [
    //         'access' => [
    //             'class' => AccessControl::class,
    //             'only' => ['registration'],
    //             'rules' => [
    //                 [
    //                     'allow' => true,
    //                     'actions' => ['registration'],
    //                     'matchCallback' => function ($rule, $action) {
    //                         return CustomHelpers::checkAuthorization() === null;
    //                     }
    //                 ]
    //             ]
    //         ]
    //     ];
    // }

    // public function actions()
    // {
    //     return [
    //         'auth' => [
    //             'class' => 'yii\authclient\AuthAction',
    //             'successCallback' => [$this, 'onAuthSuccess'],
    //         ],
    //     ];
    // }

    // public function onAuthSuccess($client)
    // {
    //     $attributes = $client->getUserAttributes();
    //     $sourceId = ArrayHelper::getValue($attributes, 'id');
    //     $source = $client->getId();

    //     $auth = (new AuthService())->findAuthUser($source, $sourceId);
    //     if (isset($auth)) {
    //         Yii::$app->user->login($auth->user);
    //         return $this->goHome();
    //     }

    //     $email = ArrayHelper::getValue($attributes, 'email');
    //     if (isset($email)) {
    //         $user = (new UserService())->findUserByEmail($email);
    //         if (isset($user)) {
    //             (new AuthService())->saveAuthUser($user->id, $source, $sourceId);
    //             Yii::$app->user->login($user);
    //         } else {
    //             $user = (new UserService())->saveNewVkProfile($attributes);
    //             (new AuthService())->saveAuthUser($user->id, $source, $sourceId);
    //             Yii::$app->user->login($user);
    //         }
    //         return $this->goHome();
    //     }
    // }


    // public function actionRegistration()
    // {
    //     $RegistrationModel = new RegistrationForm();

    //     $cities = Cities::find()
    //         ->select(['id', 'city'])
    //         ->indexBy('id')
    //         ->asArray()
    //         ->all();

    //     if (Yii::$app->request->getIsPost()) {
    //         $RegistrationModel->load(Yii::$app->request->post());

    //         if ($RegistrationModel->validate()) {
    //             (new UserService())->saveNewUserProfile($RegistrationModel);

    //             $user = $RegistrationModel->getUser();
    //             Yii::$app->user->login($user);
    //             $this->redirect('/tasks/index');
    //         }
    //     }
    //     return $this->render('registration', [
    //         'model' => $RegistrationModel,
    //         'cities' => $cities,
    //     ]);
    // }

    // public function beforeAction($action)
    // {
    //     if ($action->id === 'registration') {
    //         if (CustomHelpers::checkAuthorization() !== null) {
    //             $this->redirect('/tasks/index');
    //             return false;
    //         }
    //     }
    //     return true;
    // }
}
