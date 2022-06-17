<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "questions".
 *
 * @property int $id
 * @property string $question_dt_add
 * @property string $user_name
 * @property string $user_email
 * @property string $form_content
 */
class Questions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'questions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['question_dt_add', 'user_name', 'form_content'], 'required'],
            [['question_dt_add'], 'safe'],
            [['user_name', 'user_email'], 'string', 'max' => 256],
            [['form_content'], 'string', 'max' => 10000],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'question_dt_add' => 'Question Dt Add',
            'user_name' => 'Ваше имя',
            'user_email' => 'Email',
            'form_content' => 'Текст сообщения',
        ];
    }
}
