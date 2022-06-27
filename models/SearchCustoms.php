<?php

namespace app\models;

use yii\base\Model;

class SearchCustoms extends Model
{
    public $autocomplete;
    public $nearest_point;
    public $other_nearest_points;
    public $latitude;
    public $longitude;
    public $nearest_lat;
    public $nearest_lon;
    public $nearest_code;
    public $distance;
    public $filter;

    // public $head;
    // public $excise;
    // public $others;
    // public $captions;

    public function rules()
    {
        return [
            [['autocomplete'], 'required'], //, 'latitude', 'longitude'
            [['autocomplete', 'nearest_point', 'other_nearest_points', 'filter'], 'string'],

            // [['autocomplete', 'nearest_point', 'other_nearest_points',  'latitude', 'longitude', 'nearest_lat', 'nearest_lon', 'nearest_code', 'distance', 'filter'], 'string'],
            // [['head', 'excise', 'others', 'captions'], 'boolean'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'autocomplete' => 'Введите адрес, и сервис найдет ближайшие таможенные посты',
            // 'head' => 'Головные таможни',
            // 'excise' => 'Посты Акцизной таможни',
            // 'others' => 'Прочие посты (экспертные, оперативные и т.п. 121-125***',
            // 'captions' => 'Подписи ко всем меткам',
        ];
    }
}
