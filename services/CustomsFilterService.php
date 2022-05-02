<?php

namespace app\services;

use app\models\Customs;
use app\models\Cities;
// use app\models\TasksSearchForm;
// use yii\db\Expression;

class CustomsFilterService
{
    public function getFilteredCustoms() //: object
    {
        // if ($customscode === 'head') {
        //     $query = Customs::find()->all();
        // }

        // if ($customscode === 'excise') {
        //     $query = Customs::find()->all();
        // }

        // if ($customscode === 'others') {
        //     $query = Customs::find()->all();
        // }

        // if ($customscode === 'head') {
        //     $query = Customs::find()->all();
        // }

        $query = Customs::find()->all();



        return $query;
    }
}
