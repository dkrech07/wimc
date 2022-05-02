<?php

namespace app\controllers;

use Yii;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\web\Controller;
use app\models\SearchCustoms;
use app\models\FilterCustoms;
use app\models\Cities;
use app\services\CustomsFilterService;
use app\services\GeocoderService;
use app\services\NearestPointService;
use phpDocumentor\Reflection\Types\Null_;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Psr7\Request;

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
            // $nearest_point = new Point($form_model->latitude, $form_model->longitude);

            $nearest_point = (new NearestPointService())->getNearestPoint($form_model->latitude, $form_model->longitude);

            $form_model->nearest_lat = $nearest_point['nearestPoint']['x'];
            $form_model->nearest_lon = $nearest_point['nearestPoint']['y'];
            $form_model->distance = $nearest_point['distance'] * 100000;


            // return json_encode($nearest_point, JSON_UNESCAPED_UNICODE); // Отсюда приходят данные в модель формы на фронт;

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
        $filterCustoms = new filterCustoms();

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
            'filterCustoms' => $filterCustoms,

            // 'customs' => $customs,
        ]);
    }

    // public function actionAjax() //: array
    // {
    //     $customs = (new CustomsFilterService())->getFilteredCustoms();
    //     $customs_coords = [
    //         "type" => "FeatureCollection",
    //         "features" => []
    //     ];

    //     foreach ($customs as $number => $custom) {
    //         $customs_coords['features'][] =
    //             [
    //                 "type" => "Feature",
    //                 "id" => $number,
    //                 "geometry" => [
    //                     "type" => "Point",
    //                     "coordinates" => [
    //                         $custom['COORDS_LATITUDE'], $custom['COORDS_LONGITUDE']
    //                     ]
    //                 ],
    //                 "properties" => [
    //                     "balloonContentHeader" => $custom['CODE'] . ' ' . $custom['NAMT'],
    //                     "balloonContentBody" => $custom['ADRTAM'],
    //                     "balloonContentFooter" => $custom['TELEFON'],
    //                     "iconCaption" => $custom['CODE'] . ' ' . $custom['NAMT'],
    //                 ]

    //             ];
    //     }

    //     return json_encode($customs_coords, JSON_UNESCAPED_UNICODE);
    // }

    public function actionCheckbox()
    {

        $form_model = new FilterCustoms();
        $customs = (new CustomsFilterService())->getFilteredCustoms();


        if (\Yii::$app->request->isAjax && \Yii::$app->request->post()) {

            $request = Yii::$app->request;
            $data = $request->post();

            $form_model->head = $data['head'];
            // $form_model->excise = $data['excise'];
            // $form_model->others = $data['others'];
            // $form_model->captions = $data['captions'];

            if (isset($form_model->head)) {
                $customs = (new CustomsFilterService())->getFilteredCustoms('head');
            }
            // if (isset($form_model->excise)) {
            //     $customs = (new CustomsFilterService())->getFilteredCustoms('excise');
            // }
            // if (isset($form_model->others)) {
            //     $customs = (new CustomsFilterService())->getFilteredCustoms('others');
            // }


            // (new CustomsFilterService())->getFilteredCustoms($customscodes);
            // if ($data['settings'] === 'excise') {
            //     $form_model->excise = $data['checked'];
            // }
            // if ($data['settings'] === 'others') {
            //     $form_model->others = $data['checked'];
            // }
            // if ($data['settings'] === 'captions') {
            //     $form_model->captions = $data['checked'];
            // }


            // $customscodes = [$form_model->head, $form_model->excise, $form_model->others];

            // (new CustomsFilterService())->getFilteredCustoms($customscodes);


            // return json_encode($customscodes, JSON_UNESCAPED_UNICODE);
        }

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
