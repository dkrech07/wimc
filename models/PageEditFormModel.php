<?php

namespace app\models;

use yii\base\Model;

class PageEditFormModel extends Model
{
    public $id;
    public $page_dt_add;
    public $page_name;
    public $page_meta_description;
    public $page_url;
    public $page_user_change;
    public $page_content;

    public function rules()
    {
        return [
            [['id', 'page_dt_add', 'page_name', 'page_meta_description', 'page_url', 'page_user_change', 'page_content'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'page_dt_add' => 'Дата и время изменения страницы:',
            'page_name' => 'Название страницы:',
            'page_meta_description' => 'Метатег description:',
            'page_content' => 'Контент страницы:',
            'page_url' => 'URL страницы:',
            'page_user_change' => 'Пользователь вносивший изменения:',
        ];
    }
}
