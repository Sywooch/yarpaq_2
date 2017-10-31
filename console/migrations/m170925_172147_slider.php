<?php

use yii\db\Migration;
use yii\db\Schema;

class m170925_172147_slider extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%slide}}', [
            'id'            => Schema::TYPE_PK,
            'name'          => Schema::TYPE_STRING . ' CHARACTER SET utf8 NOT NULL',
            'status'        => Schema::TYPE_SMALLINT . ' NOT NULL',
            'sort'          => Schema::TYPE_SMALLINT . ' NOT NULL',
            'created_at'    => Schema::TYPE_DATETIME . ' NOT NULL',
            'updated_at'    => Schema::TYPE_DATETIME,
            'settings'      => Schema::TYPE_STRING
        ]);


        $this->createTable('{{%slide_image}}', [
            'id'            => Schema::TYPE_PK,
            'model_id'      => Schema::TYPE_INTEGER . ' NOT NULL',
            'language_id'   => Schema::TYPE_SMALLINT . ' NOT NULL',
            'link'          => Schema::TYPE_STRING,
            'src_name'      => Schema::TYPE_STRING . ' NOT NULL',
            'web_name'      => Schema::TYPE_STRING . ' NOT NULL'
        ]);
        $this->addForeignKey('model_id', '{{%slide_image}}', 'model_id', '{{%slide}}', 'id', 'CASCADE', 'CASCADE');

    }

    public function safeDown()
    {
        $this->dropTable('{{%slide_image}}');
        $this->dropTable('{{%slide}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170925_172147_slider cannot be reverted.\n";

        return false;
    }
    */
}
