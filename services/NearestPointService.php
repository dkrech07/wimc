<?php

namespace app\services;

use app\services\CustomsFilterService;
use app\models\FilterCustoms;

class NearestPointService
{
    function distanceTo($current_point, $nearest_point)
    {
        $distanceX = floatval($current_point['x']) - floatval($nearest_point['x']); // вычитаю корддинаты по оси x;
        $distanceY = floatval($current_point['y']) - floatval($nearest_point['y']); // вычитаю координаты по оси y;
        $distance = sqrt($distanceX * $distanceX + $distanceY * $distanceY); // считаю дистанцию;
        return $distance;
    }

    public function getNearestPoint($x, $y, $filter_model)
    {
        $current_point = [
            "x" => $x,
            "y" => $y,
        ];

        $customs_points = [];
        $customs = (new CustomsFilterService())->getFilteredCustoms($filter_model);

        foreach ($customs as $number => $custom) {

            $custom_point = [
                "x" => $custom['COORDS_LATITUDE'],
                "y" => $custom['COORDS_LONGITUDE'],
            ];

            $customs_points[] = [
                "distance" => self::distanceTo($current_point, $custom_point),
                "code" => $custom['CODE'],
                'namt' => $custom['NAMT'],
                'adrtam' => $custom['ADRTAM'],
                "x" => $custom['COORDS_LATITUDE'],
                "y" => $custom['COORDS_LONGITUDE'],
            ];
        }

        usort($customs_points, function ($a, $b) {
            return ($a['distance'] - $b['distance']);
        });

        // $otherNearestPoints = [];

        // foreach ($customs_points as $nearest_point_nuber => $other_nearest_point) {
        //     if ($nearest_point_nuber > 0 && $other_nearest_point['distance'] - $customs_points[0]['distance'] < 0.5) {
        //         $otherNearestPoints[] = $other_nearest_point;
        //     }
        // }

        return  ['nearestPoints' => array_slice($customs_points, 0, 3)];
    }
}
