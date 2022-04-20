<?php

namespace app\controllers;

use Yii;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\web\Controller;
use app\models\SearchCustoms;
use app\models\Cities;
use app\services\CustomsFilterService;

class CustomsController extends Controller
{
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

    public function actionAjaxcities()
    {
        $cities = (new CustomsFilterService())->getFilteredCities();

        $city_coords = [];
        foreach ($cities as $number => $city) {
            // if ($number < 2) {
            $city_coords[] = [
                // 'id' => $number,
                'city' => $city['CITY'],
                'coordinates' => [$city["COORDS_LATITUDE"], $city["COORDS_LONGITUDE"]],
            ];
            // }
        }
        // return ($city_coords['Абаза']);
        return json_encode($city_coords, JSON_UNESCAPED_UNICODE);
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
