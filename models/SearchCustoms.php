<?php

namespace app\models;

use yii\base\Model;

class SearchCustoms extends Model
{
    public $ADRTAM;

    public function rules()
    {
        return [
            [['ADRTAM'], 'required'],
            [['ADRTAM'], 'string', 'max' => 128],

        ];
    }

    public function attributeLabels()
    {
        return [
            'ADRTAM' => 'Адрес таможенного поста'
        ];
    }
}
