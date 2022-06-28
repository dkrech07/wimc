<?php

namespace app\models;

use yii\base\Model;

class SearchCity extends Model
{
    public $CITY;
    public $COORDS_LATITUDE;
    public $COORDS_LONGITUDE;

    public function rules()
    {
        return [
            [['CITY'], 'required'],
            [['CITY', 'COORDS_LATITUDE', 'COORDS_LONGITUDE'], 'string', 'max' => 128],
        ];
    }

    public function attributeLabels()
    {
        return [
            'ADRTAM' => 'Адрес таможенного поста',
        ];
    }
}
