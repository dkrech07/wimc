<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $ID
 * @property string $USER_DT_ADD
 * @property int $ROLE
 * @property string $LOGIN
 * @property string $EMAIL
 * @property string $NAME
 * @property string $PASSWORD
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
            [['USER_DT_ADD', 'ROLE', 'LOGIN', 'EMAIL', 'NAME', 'PASSWORD'], 'required'],
            [['USER_DT_ADD'], 'safe'],
            [['ROLE'], 'integer'],
            [['LOGIN', 'EMAIL', 'NAME'], 'string', 'max' => 128],
            [['PASSWORD'], 'string', 'max' => 64],
            [['LOGIN'], 'unique'],
            [['EMAIL'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'USER_DT_ADD' => 'User Dt Add',
            'ROLE' => 'Role',
            'LOGIN' => 'Login',
            'EMAIL' => 'Email',
            'NAME' => 'Name',
            'PASSWORD' => 'Password',
        ];
    }
}
