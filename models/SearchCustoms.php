<?php

namespace app\models;

use yii\base\Model;

class SearchCustoms extends Model
{
    // public $ADRTAM;
    public $latitude;
    public $longitude;
    // public $city;
    public $geo;
    public $nearest_lat;
    public $nearest_lon;

    public function rules()
    {
        return [
            // [['city'], 'required'],
            [['geo'], 'string'],

            // [['ADRTAM'], 'required'],
            // [['ADRTAM'], 'string', 'max' => 128],
            [['latitude', 'longitude', 'nearest_lat', 'nearest_lon'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'geo' => 'Адрес таможенного поста:',
        ];
    }
}
