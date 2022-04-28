<?php

namespace app\services;

use app\services\CustomsFilterService;


class NearestPointService
{
    function distanceTo($current_point, $nearest_point)
    {
        $distanceX = $current_point->x - $nearest_point->x; // вычитаю корддинаты по оси x;
        $distanceY = $current_point->y - $nearest_point->y; // вычитаю координаты по оси y;
        $distance = sqrt($distanceX * $distanceX + $distanceY * $distanceY); // считаю дистанцию;
        return $distance;
    }

    public function getNearestPoint($x, $y)
    {
        $current_point = [
            "x" => intval($x),
            "y" => intval($y),
        ];

        $customs = (new CustomsFilterService())->getFilteredCustoms();
        $customs_points = [];
        foreach ($customs as $number => $custom) {
            $customs_points[] = [
                "x" => intval($custom['COORDS_LATITUDE']),
                "y" => intval($custom['COORDS_LONGITUDE']),
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

        return $curNearestPoint;
    }
}
