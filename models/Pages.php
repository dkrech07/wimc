<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pages".
 *
 * @property int $id
 * @property string $page_dt_add
 * @property string $page_name
 * @property string|null $page_content
 * @property string $page_url
 * @property string $page_user_change
 */
class Pages extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pages';
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
