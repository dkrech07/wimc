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
        $query = Customs::find()->all();

        return $query;
    }
}
