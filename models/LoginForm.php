<?php

namespace app\models;

use yii\base\Model;

class LoginForm extends Model
{
    public $login;
    public $password;
    private $_user;

    public function rules()
    {
        return [
            [['login', 'password'], 'required'],
            [['login', 'password'], 'safe'],
            ['password', 'validatePassword'],
        ];
    }

    public function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findOne(['login' => $this->login]);
        }

        return $this->_user;
    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !\Yii::$app->security->validatePassword($this->password, $user->password)) {
                $this->addError($attribute, 'Неправильный логин или пароль');
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'login' => 'Логин',
            'password' => 'Пароль',
        ];
    }
}
