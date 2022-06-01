<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "questions_form".
 *
 * @property int $ID
 * @property string $QUESTION_DT_ADD
 * @property string $USER_NAME
 * @property string $USER_EMAIL
 * @property string $FORM_CONTENT
 */
class QuestionsForm extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'questions_form';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['QUESTION_DT_ADD', 'USER_NAME', 'USER_EMAIL', 'FORM_CONTENT'], 'required'],
            [['QUESTION_DT_ADD'], 'safe'],
            [['USER_NAME', 'USER_EMAIL', 'FORM_CONTENT'], 'string', 'max' => 256],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'QUESTION_DT_ADD' => 'Question Dt Add',
            'USER_NAME' => 'User Name',
            'USER_EMAIL' => 'User Email',
            'FORM_CONTENT' => 'Form Content',
        ];
    }
}
