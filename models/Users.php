<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $user_dt_add
 * @property int $role
 * @property string $login
 * @property string $email
 * @property string $name
 * @property string $password
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_dt_add', 'role', 'login', 'email', 'name', 'password'], 'required'],
            [['user_dt_add'], 'safe'],
            [['role'], 'integer'],
            [['login', 'email', 'name'], 'string', 'max' => 128],
            [['password'], 'string', 'max' => 64],
            [['login'], 'unique'],
            [['email'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_dt_add' => 'User Dt Add',
            'role' => 'Role',
            'login' => 'Login',
            'email' => 'Email',
            'name' => 'Name',
            'password' => 'Password',
        ];
    }
}
