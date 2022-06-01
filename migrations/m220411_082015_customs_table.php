<?php

use yii\db\Migration;

/**
 * Class m220411_082015_customs_table
 */
class m220411_082015_customs_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%customs}}', [
            'ID' => $this->primaryKey(),
            'CODE' => $this->string(256)->notNull(),
            'NAMT' => $this->string(256)->notNull(),
            'OKPO' => $this->string(256)->null(),
            'OGRN' => $this->string(256)->null(),
            'INN' => $this->string(256)->null(),
            'NAME_ALL' => $this->string(256)->notNull(),
            'ADRTAM' => $this->string(256)->notNull(),
            'PROSF' => $this->string(256)->null(),
            'TELEFON' => $this->string(256)->null(),
            'FAX' => $this->string(256)->null(),
            'EMAIL' => $this->string(256)->null(),
            'COORDS_LATITUDE' => $this->string(256)->notNull(),
            'COORDS_LONGITUDE' => $this->string(256)->notNull(),
        ]);

        $this->createTable('{{%history}}', [
            'ID' => $this->primaryKey(),
            'HISTORY_DT_ADD' => $this->dateTime()->notNull(),
            'REQUEST_TEXT_GEOCODER' => $this->string(256)->null(), // Текст запроса для геокодера OpenMaps (из автокоплита);
            'REQUEST_TEXT_SEARCH' => $this->string(256)->null(), // Текст запроса для поиска ближайшей точки (из поля поиска по сабмиту);
            'RESPONSE_TEXT_GEOCODER' => $this->string(256)->null(), // Ответ геокодера OpenMaps;
            'RESPONSE_TEXT_SEARCH' => $this->string(256)->null(), // Ответ сервера при попытке найти ближайший таможенный пост;
        ]);

        $this->createTable('{{%users}}', [
            'ID' => $this->primaryKey(),
            'USER_DT_ADD' => $this->dateTime()->notNull(),
            'ROLE' => $this->integer()->notNull(),
            'LOGIN' => $this->string(128)->notNull()->unique(),
            'EMAIL' => $this->string(128)->notNull()->unique(),
            'NAME' => $this->string(128)->notNull(),
            'PASSWORD' => $this->string(64)->notNull(),
        ]);

        $this->createTable('{{%pages}}', [
            'ID' => $this->primaryKey(),
            'PAGE_DT_ADD' => $this->dateTime()->notNull(),
            'PAGE_NAME' => $this->dateTime()->notNull(),
            'PAGE_CONTENT' => $this->integer()->notNull(),
            'PAGE_URL' => $this->string(256)->notNull()->unique(),
            'PAGE_USER_CHANGE' => $this->dateTime()->notNull(),
        ]);

        $this->createTable('{{%questions-form}}', [
            'ID' => $this->primaryKey(),
            'QUESTION_DT_ADD' => $this->dateTime()->notNull(),
            'USER_NAME' => $this->dateTime()->notNull(),
            'USER_EMAIL' => $this->dateTime()->notNull(),
            'FORM_CONTENT' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%customs}}');
        $this->dropTable('{{%users}}');
    }
}
