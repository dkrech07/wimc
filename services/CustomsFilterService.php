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
        // Головные
        // Посты, код которых заканчивается на *****000, за исключением постов, код которых начинается на 10009*** и на 121-125*****.
        // Акцизные
        // Посты, код которых начинается на 10009***.
        // Специальные
        // Посты, код которых начинается на 121-125*****.
        // 	Основные
        // Посты, которые не подошли под условия выше. То есть, все посты, кроме тех, код которых заканчивается на *****000 или начинается на 10009*** и 121-125*****.


        $main_query = "SELECT * FROM customs WHERE SUBSTRING(CODE, -3) NOT IN (000) AND SUBSTRING(CODE, 1, 5) NOT IN (10009) AND SUBSTRING(CODE, 1, 3) NOT IN (121, 122, 123, 124, 125)";
        $head_query = "SELECT * FROM customs WHERE SUBSTRING(CODE, -3) IN (000) AND SUBSTRING(CODE, 1, 5) NOT IN (10009) AND SUBSTRING(CODE, 1, 3) NOT IN (121, 122, 123, 124, 125)";
        $excise_query = "SELECT * FROM customs WHERE SUBSTRING(CODE, 1, 5) IN (10009)";
        $others_query = "SELECT * FROM customs WHERE SUBSTRING(CODE, 1, 3) IN (121, 122, 123, 124, 125)";

        $customs = [
            'main' => null,
            'head' => null,
            'excise' => null,
            'others' => null,
        ];


        $customs['main'] = Customs::findBySql($main_query)->all();

        if ($form_model->head == '1') {
            $customs['head'] = Customs::findBySql($head_query)->all();
        }

        if ($form_model->excise == '1') {
            $customs['excise'] = Customs::findBySql($excise_query)->all();
        }

        if ($form_model->others == '1') {
            $customs['others'] = Customs::findBySql($others_query)->all();
        }

        return $customs;

        // $without_head_query = "SUBSTRING(CODE, -3) NOT IN (000) AND SUBSTRING(CODE, 1, 3) NOT IN (121, 122, 123, 124, 125)";
        // $without_excise_query = "SUBSTRING(CODE, 1, 5) NOT IN (10009)";
        // $without_others_query = "SUBSTRING(CODE, 1, 3) NOT IN (121, 122, 123, 124, 125)";

        // $queries = [
        //     'head' => $without_head_query,
        //     'excise' => $without_excise_query,
        //     'others' => $without_others_query,
        // ];

        // if ($form_model->head == '1') {
        //     unset($queries['head']);
        // } else {
        //     $queries['head'] = $without_head_query;
        // }

        // if ($form_model->excise == '1') {
        //     unset($queries['excise']);
        // } else {
        //     $queries['excise'] = $without_excise_query;
        // }

        // if ($form_model->others == '1') {
        //     unset($queries['others']);
        // } else {
        //     $queries['others'] = $without_others_query;
        // }

        // $queries_keys = [];
        // foreach ($queries as $key => $query) {
        //     $queries_keys[] = $key;
        // }

        // foreach ($queries_keys as $key => $query) {
        //     if ($key === 0) {
        //         $sql .= " WHERE ";
        //     } else {
        //         $sql .= " AND ";
        //     }
        //     $sql .= $queries[$query];
        // }

        // return Customs::findBySql($sql)->all();
    }

    function distanceTo($user_point, $current_point)
    {
        $distanceX = floatval($user_point['x']) - floatval($current_point['x']); // вычитаю корддинаты по оси x;
        $distanceY = floatval($user_point['y']) - floatval($current_point['y']); // вычитаю координаты по оси y;
        $distance = sqrt($distanceX * $distanceX + $distanceY * $distanceY); // считаю дистанцию;
        return $distance;
    }

    public function getCustom($custom, $filterCustomsModel, $custom_type)
    {
        $user_point = [
            "x" => $filterCustomsModel['longitude'],
            "y" => $filterCustomsModel['latitude'],
        ];

        $current_point = [
            "x" => $custom['COORDS_LONGITUDE'],
            "y" => $custom['COORDS_LATITUDE'],
        ];

        if ($filterCustomsModel['longitude'] && $filterCustomsModel['latitude']) {
            $distance = self::distanceTo($user_point, $current_point) * 100;

            // $distance = round(self::distanceTo($user_point, $current_point) * 100, 2);
        } else {
            $distance = null;
        }

        return [
            "distance" => $distance,
            "point_type" => 'points',
            "custom_type" => $custom_type,
            'longitude' => $custom['COORDS_LONGITUDE'],
            'latitude' => $custom['COORDS_LATITUDE'],
            "code" => $custom['CODE'],
            "namt" => $custom['NAMT'],
            "adrtam" => $custom['ADRTAM'],
            "telefon" => $custom['TELEFON'],
            "email" => $custom['EMAIL'],
        ];
    }

    public function getCustoms($customs, $filterCustomsModel)
    {
        $customs_coords = [];

        // foreach ($customs as $number => $custom) {
        //     if (substr($custom['CODE'], -3) == '000') {
        //         $customs_coords[] = self::getCustom($custom, $filterCustomsModel, 'head');
        //     } else if (substr($custom['CODE'], 0, 5) == '10009') {
        //         $customs_coords[] = self::getCustom($custom, $filterCustomsModel, 'excise');
        //     } else if (
        //         substr($custom['CODE'], 0, 3) == '121'
        //         || substr($custom['CODE'], 0, 3) == '122'
        //         || substr($custom['CODE'], 0, 3) == '123'
        //         || substr($custom['CODE'], 0, 3) == '124'
        //         || substr($custom['CODE'], 0, 3) == '125'
        //     ) {
        //         $customs_coords[] = self::getCustom($custom, $filterCustomsModel, 'others');
        //     } else {
        //         $customs_coords[] = self::getCustom($custom, $filterCustomsModel, 'main');
        //     }
        // }
        if ($customs['main']) {
            foreach ($customs['main'] as $number => $custom) {
                $customs_coords[] = self::getCustom($custom, $filterCustomsModel, 'main');
            }
        }

        if ($customs['head']) {
            foreach ($customs['head'] as $number => $custom) {
                $customs_coords[] = self::getCustom($custom, $filterCustomsModel, 'head');
            }
        }
        if ($customs['excise']) {
            foreach ($customs['excise'] as $number => $custom) {
                $customs_coords[] = self::getCustom($custom, $filterCustomsModel, 'excise');
            }
        }
        if ($customs['others']) {
            foreach ($customs['others'] as $number => $custom) {
                $customs_coords[] = self::getCustom($custom, $filterCustomsModel, 'others');
            }
        }

        // key

        usort($customs_coords, function ($a, $b) {
            return ($a['distance'] * 100 - $b['distance'] * 100);
        });

        if ($filterCustomsModel['longitude'] && $filterCustomsModel['latitude']) {
            $customs_coords[0]['point_type'] = 'nearest';
            $customs_coords[1]['point_type'] = 'nearest';
            $customs_coords[2]['point_type'] = 'nearest';
        }

        return $customs_coords;
        // return $customs;
    }
}
