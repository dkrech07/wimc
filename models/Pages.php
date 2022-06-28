<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pages".
 *
 * @property int $id
 * @property string $page_dt_add
 * @property string $page_name
 * @property string|null $page_meta_description
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
            [['page_name', 'page_meta_description', 'page_content', 'page_url', 'page_user_change'], 'string'],
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
            'page_dt_add' => 'Page Dt Add',
            'page_name' => 'Page Name',
            'page_meta_description' => 'Page Meta Description',
            'page_content' => 'Page Content',
            'page_url' => 'Page Url',
            'page_user_change' => 'Page User Change',
        ];
    }
}
