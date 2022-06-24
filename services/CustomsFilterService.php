<?php

namespace app\services;

use app\models\Customs;
use app\models\Cities;
use app\models\FilterCustoms;

// use app\models\TasksSearchForm;
// use yii\db\Expression;

// Чтобы исключить попадание постов в разные группы, условие такое.
// 1. Головные - сюда включаются посты, код которых заканчивается на *****000, за исключением постов, начинающихся на 10009*** и 121-125*****.
// 2. Акцизные - сюда включаются посты, код которых начинается на 10009***. Так и есть сейчас.
// 3. Специальные - сюда включаются посты, код которых начинается на 121-125*****. Так и есть сейчас.

class CustomsFilterService
{
    public function getFilteredCustoms(FilterCustoms $form_model) //: object
    {
        $sql = "SELECT * FROM customs";

        $without_head_query = "SUBSTRING(CODE, -3) NOT IN (000) AND SUBSTRING(CODE, 1, 3) NOT IN (121, 122, 123, 124, 125)";
        $without_excise_query = "SUBSTRING(CODE, 1, 5) NOT IN (10009)";
        $without_others_query = "SUBSTRING(CODE, 1, 3) NOT IN (121, 122, 123, 124, 125)";

        $queries = [
            'head' => $without_head_query,
            'excise' => $without_excise_query,
            'others' => $without_others_query,
        ];

        if ($form_model->head == '1') {
            unset($queries['head']);
        } else {
            $queries['head'] = $without_head_query;
        }

        if ($form_model->excise == '1') {
            unset($queries['excise']);
        } else {
            $queries['excise'] = $without_excise_query;
        }

        if ($form_model->others == '1') {
            unset($queries['others']);
        } else {
            $queries['others'] = $without_others_query;
        }

        $queries_keys = [];
        foreach ($queries as $key => $query) {
            $queries_keys[] = $key;
        }

        foreach ($queries_keys as $key => $query) {
            if ($key === 0) {
                $sql .= " WHERE ";
            } else {
                $sql .= " AND ";
            }
            $sql .= $queries[$query];
        }

        return Customs::findBySql($sql)->all();
    }
}
