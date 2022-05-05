<?php

namespace app\services;

use app\models\Customs;
use app\models\Cities;
use app\models\FilterCustoms;

// use app\models\TasksSearchForm;
// use yii\db\Expression;

class CustomsFilterService
{
    public function getFilteredCustoms(FilterCustoms $form_model) //: object
    {
        $query = "SELECT * FROM customs";

        $without_head_query = "SUBSTRING(CODE, -3) NOT IN (000)";
        $without_excise_query = "SUBSTRING(CODE, 1, 5) NOT IN (10009)";
        $without_others_query = "SUBSTRING(CODE, 1, 3) NOT IN (121, 122, 123, 124, 125)";

        $sql_array = [$without_head_query, $without_excise_query, $without_others_query];

        foreach ($sql_array as $sql_key => $sql) {
            if ($sql_key == 0) {
                $query .= " WHERE ";
            } else {
                $query .= " AND ";
            }
            $query .= $sql;
        }

        // if ($form_model->head == '1') {
        //     $form_array[] = 'head';
        // }
        // if ($form_model->excise == '1') {
        //     $form_array[] = 'excise';
        // }
        // if ($form_model->others == '1') {
        //     $form_array[] = 'others';
        // }
        // if ($form_model->captions == '1') {
        //     $form_array[] = 'captions';
        // }

        // foreach ($form_array as $form_key => $form_param) {
        // if ($form_key == 0) {
        //     $sql .= " WHERE ";
        // } else {
        //     $sql .= " OR ";
        // }

        //     if ($form_param === 'head') {
        //         $sql .= "SUBSTRING(CODE, -3) IN (000)";
        //     }

        //     if ($form_param === 'excise') {
        //         $sql .= "SUBSTRING(CODE, 1, 5) IN (10009)";
        //     }

        //     if ($form_param === 'others') {
        //         $sql .= "SUBSTRING(CODE, 1, 3) IN (121, 122, 123, 124, 125)";
        //     }
        // }

        return Customs::findBySql($query)->all();






        // return $form_param;


        // SELECT * FROM materials WHERE podcat IN(10, 11, 13, 111)

        // if ($form_model->head == 1) {
        //     $sql .= ' ';
        // }


        // if ($form_model->others === 1) {
        //     $sql .= ' WHERE SUBSTRING(CODE, -3)=122 AND ';


        //     $query->andWhere(['status' => '121'])
        //         ->andWhere(['CODE' => '122'])
        //         ->andWhere(['CODE' => '123'])
        //         ->andWhere(['CODE' => '124'])
        //         ->andWhere(['CODE' => '125']);
        // }


        // if ($form_model->head == 1) {
        //     $sql = 'SELECT * FROM customs WHERE SUBSTRING(CODE, -3)=000';
        // }





        // $query = Customs::find();




        // if ($customscode == 'head') {


        //     return Customs::findBySql('SELECT * FROM customs WHERE SUBSTRING(CODE, -3)=000')->all();

        //     // return Customs::find()
        //     //     ->where(['CODE' => '000'])->substr(-3)
        //     //     ->all();
        // }

        // return $query;

        // if ($customscode === 'excise') {
        //     $query->andWhere(['CODE' => '000']);
        // }

        // if ($customscode === 'others') {
        //     $query->andWhere(['status' => '121'])
        //         ->andWhere(['CODE' => '122'])
        //         ->andWhere(['CODE' => '123'])
        //         ->andWhere(['CODE' => '124'])
        //         ->andWhere(['CODE' => '125']);
        // }


        // if ($customscode === 'head') {
        //     $query = Customs::find()->all();
        // }


        // }





        // foreach ($queries as $query) {

        // }
    }
}
