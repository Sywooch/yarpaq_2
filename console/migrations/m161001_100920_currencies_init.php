<?php

use yii\db\Schema;
use yii\db\Migration;

class m161001_100920_currencies_init extends Migration
{
    public function up()
    {
        $this->createTable('{{%currency}}', [
            'id' => Schema::TYPE_PK,
            'title' => Schema::TYPE_STRING . ' NOT NULL',
            'code' => Schema::TYPE_STRING . ' NOT NULL',
            'value' => Schema::TYPE_FLOAT . ' NOT NULL',
            'decimal_place' => Schema::TYPE_INTEGER,
            'status' => Schema::TYPE_SMALLINT . ' NOT NULL',
            'created_at' => Schema::TYPE_DATETIME . ' NOT NULL',
            'updated_at' => Schema::TYPE_DATETIME . ' NOT NULL',
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%currency}}');
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
