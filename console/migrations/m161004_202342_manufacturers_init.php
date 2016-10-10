<?php

use yii\db\Schema;
use yii\db\Migration;

class m161004_202342_manufacturers_init extends Migration
{
    public function up()
    {
        $this->createTable('{{%manufacturer}}', [
            'id' => Schema::TYPE_PK,
            'title' => Schema::TYPE_STRING . ' NOT NULL',
            'image' => Schema::TYPE_STRING . ' NOT NULL',
            'created_at' => Schema::TYPE_DATETIME . ' NOT NULL',
            'updated_at' => Schema::TYPE_DATETIME . ' NOT NULL',
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%manufacturer}}');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
