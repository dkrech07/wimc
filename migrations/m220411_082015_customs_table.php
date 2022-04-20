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

        $this->createTable('{{%cities}}', [
            'ID' => $this->primaryKey(),
            'CITY' => $this->string(128)->notNull(),
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
        $this->dropTable('{{%cities}}');
        $this->dropTable('{{%users}}');
    }
}
