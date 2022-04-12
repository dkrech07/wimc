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
            'CODE' => $this->integer()->notNull(),
            'NAMT' => $this->string(128)->notNull(),
            'OKPO' => $this->integer()->null(),
            'OGRN' => $this->integer()->null(),
            'INN' => $this->integer()->null(),
            'NAME_ALL' => $this->string(128)->notNull(),
            'ADRTAM' => $this->string(128)->notNull(),
            'PROSF' => $this->integer()->null(),
            'TELEFON' => $this->string(128)->null(),
            'FAX' => $this->string(128)->null(),
            'EMAIL' => $this->string(128)->null(),
            'COORDS_LATITUDE' => $this->string(128)->notNull(),
            'COORDS_LONGITUDE' => $this->string(128)->notNull(),
        ]);

        $this->createTable('{{%users}}', [
            'ID' => $this->primaryKey(),
            'EMAIL' => $this->string(128)->notNull()->unique(),
            'NAME' => $this->string(128)->notNull(),
            'ROLE' => $this->integer()->notNull(),
            'PASSWORD' => $this->string(64)->notNull(),
            'DT_ADD' => $this->dateTime()->notNull(),
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
