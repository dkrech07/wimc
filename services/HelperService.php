<?php

namespace app\services;

use Yii;
use yii\db\Expression;
use app\models\User;

class HelperService
{
    /**
     * @return object|null
     */
    public static function checkAuthorization(): ?object
    {
        if (Yii::$app->user->isGuest) {
            return null;
        }

        return User::findIdentity(Yii::$app->user->getId());
    }

    public static function getCurrentDate(): string
    {
        $expression = new Expression('NOW()');
        $now = (new \yii\db\Query)->select($expression)->scalar();
        return $now;
    }
}
