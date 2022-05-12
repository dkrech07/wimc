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
            [['main', 'head', 'excise', 'others', 'captions'], 'boolean'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'main' => 'Основные',
            'head' => 'Головные',
            'excise' => 'Акцизные',
            'others' => 'Прочие', // (экспертные, оперативные и т.п. 121-125***
            'captions' => 'Подписи',
        ];
    }
}
