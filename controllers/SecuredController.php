<?php

namespace app\controllers;

use yii\filters\AccessControl;
use yii\web\Controller;
use app\services\HelperService;

abstract class SecuredController extends Controller
{
    // public function behaviors()
    // {
    //     return [
    //         'access' => [
    //             'class' => AccessControl::class,
    //             'rules' => [
    //                 [
    //                     'allow' => true,
    //                     'roles' => ['@']
    //                 ]
    //             ]
    //         ]
    //     ];
    // }

    // public function beforeAction($action)
    // {
    //     if ($action->id === 'admin') {
    //         if ((new HelperService())->checkAuthorization() === null) {
    //             $this->redirect('http://localhost/wimc/web/grandmaster');
    //             return false;
    //         }
    //     }
    //     return true;
    // }
}
