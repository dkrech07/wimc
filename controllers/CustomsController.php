<?php

namespace app\controllers;

use Yii;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\web\Controller;
use app\models\SearchCustoms;
use app\models\Cities;
use app\services\CustomsFilterService;
use app\services\GeocoderService;

class CustomsController extends Controller
{

    public function actionAutocomplete()
    {
        $searchCustomsModel = new SearchCustoms();

        if (Yii::$app->request->get('term')) {
            // $model = Company::find()->where(['like', 'name', Yii::$app->request->get('term')])->limit(5)->asArray()->all();
            // foreach ($model as $value) {
            //     $result[] = $value['name'];
            // }

            // return 'Тест, Тест, Тест.';
            // print(Yii::$app->request->get('term'));
            return (new GeocoderService())->getCoords(Yii::$app->request->get('term'));
        }
    }

    public function actionSearch()
    {

        $form_model = new SearchCustoms();
        if (\Yii::$app->request->isAjax) {
            // return 'Запрос принят!';
        }
        if ($form_model->load(\Yii::$app->request->post())) {
            // var_dump($form_model->geo);
            return json_encode($form_model, JSON_UNESCAPED_UNICODE); // Отсюда приходят данные в модель формы на фронт;
        }


        // if (Yii::$app->request->isPost) {
        //     $form_model->load(Yii::$app->request->post());

        //     if (Yii::$app->request->isAjax) {
        //         Yii::$app->response->format = Response::FORMAT_JSON;
        //         return ActiveForm::validate($form_model);
        //     }

        //     if ($form_model->validate()) {
        //         return json_encode($form_model, JSON_UNESCAPED_UNICODE);
        //         // exit;
        //         // $taskId = $tasksService->createTask($addTaskFormModel);
        //         // $this->redirect(['tasks/view', 'id' => $taskId]);
        //     }
        // }
    }

    // public function actionPage()
    // {
    //     $form_model = new TestForm();
    //     if (\Yii::$app->request->isAjax) {
    //         return 'Запрос принят!';
    //     }
    //     if ($form_model->load(\Yii::$app->request->post())) {
    //         var_dump($form_model);
    //     }
    //     return $this->render('page', compact('form_model'));
    // }


    public function actionIndex()
    {
        $searchCustomsModel = new SearchCustoms();
        if (Yii::$app->request->isPost) {
            $searchCustomsModel->load(Yii::$app->request->post());

            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($searchCustomsModel);
            }

            if ($searchCustomsModel->validate()) {
                print_r($searchCustomsModel);
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
        $customs_coords = [
            "type" => "FeatureCollection",
            "features" => []
        ];

        foreach ($customs as $number => $custom) {
            $customs_coords['features'][] =
                [
                    "type" => "Feature",
                    "id" => $number,
                    "geometry" => [
                        "type" => "Point",
                        "coordinates" => [
                            $custom['COORDS_LATITUDE'], $custom['COORDS_LONGITUDE']
                        ]
                    ],
                    "properties" => [
                        "balloonContentHeader" => $custom['CODE'] . ' ' . $custom['NAMT'],
                        "balloonContentBody" => $custom['ADRTAM'],
                        "balloonContentFooter" => $custom['TELEFON'],
                        "iconCaption" => $custom['CODE'] . ' ' . $custom['NAMT'],
                    ]

                ];
        }

        return json_encode($customs_coords, JSON_UNESCAPED_UNICODE);
    }
}
