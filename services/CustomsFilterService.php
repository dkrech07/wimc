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

    public function getCustom($custom, $custom_type, $captions = null)
    {
        $custom_color = [
            'main' => 'padding: 3px; background: #00AA00; color: #FFFFFF;',
            'head' => 'padding: 3px; background: #FF0000; color: #FFFFFF;',
            'excise' => 'padding: 3px; background: #0000FF; color: #FFFFFF;',
            'others' => 'padding: 3px; background: #E8B000; color: #FFFFFF;',
        ];

        if ($custom['TELEFON']) {
            $phone_number = preg_replace('~\D+~', '',  $custom['TELEFON']);
            $phone = ' <i class="bi bi-telephone-fill"></i> ' . '<a href="tel:' . '+7' . $phone_number . '">' . '+7' . $custom['TELEFON'] . '</a>';
        } else {
            $phone = '';
        }

        if ($custom['EMAIL']) {
            $email = '<i class="bi bi-envelope-fill"></i> ' . '<a href="mailto:' . $custom['EMAIL'] . '">' . $custom['EMAIL'] . '</a>';
        } else {
            $email = '';
        }

        return [
            "distance" => null,
            "nearest" => null,
            "custom_type" => $custom_type,
            "coordinates" => [
                'lat' => $custom['COORDS_LATITUDE'],
                'lon' => $custom['COORDS_LONGITUDE'],
            ],
            "code" => $custom['CODE'],
            "properties" => [
                "balloonContentHeader" => '<div class=ballon_header style="font-size: 12px;' . $custom_color[$custom_type] . '">' . ' <i class="bi bi-geo-alt-fill"></i> ' . $custom['CODE'] . ' ' . $custom['NAMT'] . '</div>',
                "balloonContentBody" => '<div class=ballon_body>' . $custom['ADRTAM'] . '</div>',
                "balloonContentFooter" =>


                '<div class=ballon_footer>' . $phone  . '</div>' .
                    '<div class=ballon_footer>' . $email . '</div>',
                "iconCaption" => $custom['CODE'] . ' ' . $custom['NAMT'],
            ],
        ];
    }

    public function getCustoms($customs, $data)
    {
        $customs_coords = [];
        // 'main' => [],
        // 'head' => [],
        // 'excise' => [],
        // 'others' => [],


        foreach ($customs as $number => $custom) {
            if (substr($custom['CODE'], -3) == '000') {
                $customs_coords[] = self::getCustom($custom, 'head', $data['captions']);
            } else if (substr($custom['CODE'], 0, 5) == '10009') {
                $customs_coords[] = self::getCustom($custom, 'excise', $data['captions']);
            } else if (
                substr($custom['CODE'], 0, 3) == '121'
                || substr($custom['CODE'], 0, 3) == '122'
                || substr($custom['CODE'], 0, 3) == '123'
                || substr($custom['CODE'], 0, 3) == '124'
                || substr($custom['CODE'], 0, 3) == '125'
            ) {
                $customs_coords[] = self::getCustom($custom, 'others', $data['captions']);
            } else {
                $customs_coords[] = self::getCustom($custom, 'main', $data['captions']);
            }
        }


        // function distanceTo($current_point, $nearest_point)
        // {
        //     $distanceX = floatval($current_point['x']) - floatval($nearest_point['x']); // вычитаю корддинаты по оси x;
        //     $distanceY = floatval($current_point['y']) - floatval($nearest_point['y']); // вычитаю координаты по оси y;
        //     $distance = sqrt($distanceX * $distanceX + $distanceY * $distanceY); // считаю дистанцию;
        //     return $distance;
        // }

        // $form_model->autocomplete = $data['autocomplete'];
        // $form_model->latitude = $data['latitude'];
        // $form_model->longitude = $data['longitude'];

        // $current_point = [
        //     "x" => $data['longitude'],
        //     "y" => $data['latitude'],
        // ];

        // foreach ($customs_coords as $number => $custom) {

        //     $custom_point = [
        //         "x" => $custom['COORDS_LONGITUDE'],
        //         "y" => $custom['COORDS_LATITUDE'],
        //     ];


        //     $custom['distance'] = distanceTo($current_point, $custom_point);
        // }

        // usort($customs_points, function ($a, $b) {
        //     return ($a['distance'] - $b['distance']);
        // });

        return $customs_coords;
    }
}
