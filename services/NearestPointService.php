<?php

namespace app\services;

use app\services\CustomsFilterService;
use app\models\FilterCustoms;

class NearestPointService
{
    function distanceTo($current_point, $nearest_point)
    {
        $distanceX = intval($current_point['x']) - intval($nearest_point['x']); // вычитаю корддинаты по оси x;
        $distanceY = intval($current_point['y']) - intval($nearest_point['y']); // вычитаю координаты по оси y;
        $distance = sqrt($distanceX * $distanceX + $distanceY * $distanceY); // считаю дистанцию;
        return $distance;
    }

    public function getNearestPoint($x, $y, $filter_model)
    {
        $current_point = [
            "x" => $x,
            "y" => $y,
        ];

        // $form_model = new FilterCustoms();
        $customs = (new CustomsFilterService())->getFilteredCustoms($filter_model);
        $customs_points = [];
        foreach ($customs as $number => $custom) {
            $customs_points[] = [
                "x" => $custom['COORDS_LATITUDE'],
                "y" => $custom['COORDS_LONGITUDE'],
                "code" => $custom['CODE'],
            ];
        }

        $curNearestPoint = $customs_points[0];
        $curNearestDistance = self::distanceTo($current_point, $curNearestPoint);


        foreach ($customs_points as $customs_point) {
            $distance = self::distanceTo($current_point, $customs_point);
            if ($distance < $curNearestDistance) {
                $curNearestDistance = $distance;
                $curNearestPoint = $customs_point;
            }
        }

        return  ['nearestPoint' => $curNearestPoint, 'distance' => $curNearestDistance];
    }
}
