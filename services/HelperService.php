<?php

namespace app\services;

use Yii;
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
}
