<?php

namespace app\models;

use yii\base\Model;

class FilterCustoms extends Model
{

    public $head;
    public $excise;
    public $others;
    public $captions;
    public $main;

    public function rules()
    {
        return [
            [['head', 'excise', 'others', 'main', 'captions'], 'boolean'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'head' => 'Головные таможни',
            'excise' => 'Посты Акцизной таможни',
            'others' => 'Прочие посты (экспертные, оперативные и т.п. 121-125***',
            'captions' => 'Подписи ко всем меткам',
        ];
    }
}
