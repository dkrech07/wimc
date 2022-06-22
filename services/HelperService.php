<?php

namespace app\services;

use Yii;
use yii\db\Expression;
use app\models\User;

const COUNT_BYTES_IN_KILOBYTE = 1024;

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

    public static function getFileSize(string $file_path)
    {
        $fileSize = filesize(Yii::getAlias('@webroot') . '/upload/files/' . $file_path) / COUNT_BYTES_IN_KILOBYTE;

        return ceil($fileSize);
    }
}
