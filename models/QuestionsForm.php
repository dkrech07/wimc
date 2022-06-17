<?php

namespace app\models;

use yii\base\Model;

/**
 * This is the model class for table "questions_form".
 *
 * @property int $id
 * @property string $user_name
 * @property string $user_email
 * @property string $form_content
 */
class QuestionsForm extends Model
{
    public $user_name;
    public $user_email;
    public $form_content;
    public $verifyCode;

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
            [['user_name', 'form_content', 'verifyCode'], 'required'],
            [['user_name', 'user_email'], 'string', 'max' => 256],
            [['form_content'], 'string', 'max' => 1000],
            ['verifyCode', 'captcha', 'captchaAction' => '/contacts/captcha'],
            // загрузка файла
            // капча
            // соглашение на обработку персональных данных
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_name' => 'Ваше имя',
            'user_email' => 'Email',
            'form_content' => 'Текст сообщения',
            'verifyCode' => 'Подтвердите, что вы не бот',
        ];
    }
}
