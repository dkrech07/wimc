<?php

namespace app\services;

use app\services\CustomsFilterService;


class Point
{
    public $x, $y;

    function __construct($x, $y)
    {
        $this->x = $x; // lat приходит из формы;
        $this->y = $y; // lon приходит из формы;
    }

    function distanceTo(Point $point)
    {
        $distanceX = $this->x - $point->x; // вычитаю корддинаты по оси x;
        $distanceY = $this->y - $point->y; // вычитаю координаты по оси y;
        $distance = sqrt($distanceX * $distanceX + $distanceY * $distanceY); // считаю дистанцию;
        return $distance;
    }

    function __toString() // эта точка используется для расчета расстояния;
    {
        return 'x: ' . $this->x . ', y: ' . $this->y; // преобразую то что получилось в текст;
    }
}

$customs = (new CustomsFilterService())->getFilteredCustoms();
$customs_points = [];
foreach ($customs as $number => $custom) {
    $customs_points[] = [
        "lat" => $custom['COORDS_LATITUDE'],
        "lon" => $custom['COORDS_LONGITUDE']
    ];
}

$a = new Point(0, 0);

$points = [];
foreach ($customs_points as $number => $custom_point) {
    $points[] = new Point($custom_point['lat'], $custom_point['lon']);
}

$curNearestPoint = $points[0];
$curNearestDistance = $a->distanceTo($curNearestPoint);
foreach ($points as $point) {
    $distance = $a->distanceTo($point);
    if ($distance < $curNearestDistance) {
        $curNearestDistance = $distance;
        $curNearestPoint = $point;
    }
}

print 'nearest point: ' . $curNearestPoint;
