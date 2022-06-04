<?php

namespace app\models;

use yii\base\Model;

class PageEditFormModel extends Model
{
    public $page_dt_add;
    public $page_name;
    public $page_content;
    public $page_url;
    public $page_user_change;

    public static function tableName()
    {
        return 'pageEditForm';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['page_dt_add', 'page_name', 'page_url', 'page_user_change'], 'required'],
            [['page_dt_add'], 'safe'],
            [['page_name', 'page_content', 'page_url', 'page_user_change'], 'string', 'max' => 256],
            [['page_url'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'page_dt_add' => 'Дата и время изменения страницы:',
            'page_name' => 'Название страницы:',
            'page_content' => 'Контент страницы:',
            'page_url' => 'URL страницы:',
            'page_user_change' => 'Пользователь вносивший изменения:',
        ];
    }
}
