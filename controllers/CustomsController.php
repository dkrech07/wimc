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
        $list = [
            "type" => "FeatureCollection",
            "features" => [
                [
                    "type" => "Feature", "id" => 0, "geometry" => ["type" => "Point", "coordinates" => [55.831903, 37.411961]],
                    "properties" =>
                    [
                        "balloonContentHeader" => "<font size=3><b><a target='_blank' href='https =>//yandex.ru'>Здесь может быть ваша ссылка</a></b></font>",
                        "balloonContentBody" => "<p>Ваше имя => <input name='login'></p><p><em>Телефон в формате 2xxx-xxx =></em>  <input></p><p><input type='submit' value='Отправить'></p>",
                        "balloonContentFooter" => "<font size=1>Информация предоставлена => </font> <strong>этим балуном</strong>",
                        "clusterCaption" => "<strong><s>Еще</s> одна</strong> метка", "hintContent" => "<strong>Текст  <s>подсказки</s></strong>"
                    ]
                ],

            ]
        ];

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





            // if ($number < 3) {
            // $customs_coords[] = [
            //     'ID' => $custom['ID'],
            //     'CODE' => $custom['CODE'],
            //     'NAMT' => $custom['NAMT'],
            //     'OKPO' => $custom['OKPO'],
            //     'OGRN' => $custom['OGRN'],
            //     'INN' => $custom['INN'],
            //     'NAME_ALL' => $custom['NAME_ALL'],
            //     'ADRTAM' => $custom['ADRTAM'],
            //     'PROSF' => $custom['PROSF'],
            //     'TELEFON' => $custom['TELEFON'],
            //     'FAX' => $custom['FAX'],
            //     'EMAIL' => $custom['EMAIL'],
            //     'COORDS_LATITUDE' => $custom['COORDS_LATITUDE'],
            //     'COORDS_LONGITUDE' => $custom['COORDS_LONGITUDE'],
            // ];
            // }
            // $customs_coords[] = [$custom['COORDS_LATITUDE'], $custom['COORDS_LONGITUDE']];











        }



        return json_encode($customs_coords, JSON_UNESCAPED_UNICODE);
        // return serialize($customs_coords);
    }
}
