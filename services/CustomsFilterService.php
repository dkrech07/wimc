<?php

namespace app\services;

use app\models\Customs;
use app\models\Cities;
// use app\models\TasksSearchForm;
// use yii\db\Expression;

class CustomsFilterService
{
    public function getFilteredCustoms($customscode = null) //: object
    {
        $query = Customs::find();

        if (!$customscode) {
            return $query->all();
        }


        if ($customscode == 'head') {
            return $query->where(['customs.CODE' => '000'])->all();
        }

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
