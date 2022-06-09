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

        $this->createTable('{{%history_geocoder}}', [
            'id' => $this->primaryKey(),
            'history_dt_add_geocoder' => $this->dateTime()->notNull(),
            'request_text_geocoder' => $this->string(256)->null(), // Текст запроса для геокодера OpenMaps (из автокоплита); 
            'response_text_geocoder' => $this->string(256)->null(), // Ответ геокодера OpenMaps; 
        ]);

        $this->createTable('{{%history_search}}', [
            'id' => $this->primaryKey(),
            'history_dt_add_search' => $this->dateTime()->notNull(),
            'request_text_search' => $this->string(256)->null(), // Текст запроса для поиска ближайшей точки (из поля поиска по сабмиту);
            'response_text_search' => $this->string(256)->null(), // Ответ сервера при попытке найти ближайший таможенный пост;
        ]);

        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey(),
            'user_dt_add' => $this->dateTime()->notNull(),
            'role' => $this->integer()->notNull(),
            'login' => $this->string(128)->notNull()->unique(),
            'email' => $this->string(128)->notNull()->unique(),
            'name' => $this->string(128)->notNull(),
            'password' => $this->string(64)->notNull(),
        ]);

        $this->createTable('{{%pages}}', [
            'id' => $this->primaryKey(),
            'page_dt_add' => $this->dateTime()->notNull(),
            'page_name' => $this->string()->notNull(),
            'page_content' => $this->string()->null(),
            'page_url' => $this->string()->notNull()->unique(),
            'page_user_change' => $this->string()->notNull(),
        ]);

        $this->createTable('{{%questions_form}}', [
            'id' => $this->primaryKey(),
            'question_dt_add' => $this->dateTime()->notNull(),
            'user_name' => $this->string(512)->notNull(),
            'user_email' => $this->string(256)->notNull(),
            'form_content' => $this->string(256)->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%customs}}');
        $this->dropTable('{{%history_geocoder}}');
        $this->dropTable('{{%history_search}}');
        $this->dropTable('{{%pages}}');
        $this->dropTable('{{%questions_form}}');
    }
}
