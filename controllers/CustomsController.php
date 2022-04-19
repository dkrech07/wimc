<?php

namespace app\controllers;

use Yii;
// use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\web\Controller;
use app\models\SearchCustoms;
use app\services\CustomsFilterService;

class CustomsController extends Controller
{
    public function actionIndex()
    {
        $searchCustomsModel = new SearchCustoms();

        if (Yii::$app->request->isPost) {
            $searchCustomsModel->load(Yii::$app->request->post());

            // if (Yii::$app->request->isAjax) {
            //     Yii::$app->response->format = Response::FORMAT_JSON;
            //     return ActiveForm::validate($searchCustomsModel);
            // }

            if ($searchCustomsModel->validate()) {
                // print_r($searchCustomsModel);
                // exit;
                // $taskId = $tasksService->createTask($addTaskFormModel);
                // $this->redirect(['tasks/view', 'id' => $taskId]);
            }
        }

        return $this->render('index', [
            'searchCustomsModel' => $searchCustomsModel,
            // 'customs' => $customs,
        ]);
    }

    public function actionAjax() //: array
    {
        $customs = (new CustomsFilterService())->getFilteredCustoms();
        $customs_coords = [];

        foreach ($customs as $number => $custom) {
            if ($number < 100) {
                $customs_coords[] = [$custom['COORDS_LATITUDE'], $custom['COORDS_LONGITUDE']];
            }
        }

        // header('Content-Type: text/html; charset=utf-8');

        // $customs_coords = array(
        //     ['лалала', 'nanana'],
        //     ['лалала', 'nanana'],
        // );

        // print_r($customs_coords);
        echo json_encode($customs_coords);
        // Yii::$app->response->format = Response::FORMAT_JSON;
        // print((new GeocoderService())->getCoords($geocode));
        // exit;
        // return $result;
    }
}
