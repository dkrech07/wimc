<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pages".
 *
 * @property int $ID
 * @property string $PAGE_DT_ADD
 * @property string $PAGE_NAME
 * @property string|null $PAGE_CONTENT
 * @property string $PAGE_URL
 * @property string $PAGE_USER_CHANGE
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
            [['PAGE_DT_ADD', 'PAGE_NAME', 'PAGE_URL', 'PAGE_USER_CHANGE'], 'required'],
            [['PAGE_DT_ADD'], 'safe'],
            [['PAGE_NAME', 'PAGE_CONTENT', 'PAGE_URL', 'PAGE_USER_CHANGE'], 'string', 'max' => 256],
            [['PAGE_URL'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'PAGE_DT_ADD' => 'Page Dt Add',
            'PAGE_NAME' => 'Page Name',
            'PAGE_CONTENT' => 'Page Content',
            'PAGE_URL' => 'Page Url',
            'PAGE_USER_CHANGE' => 'Page User Change',
        ];
    }
}
