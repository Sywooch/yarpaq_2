<?php

use yii\db\Migration;

class m171006_150541_improve_order_table extends Migration
{
    public function safeUp()
    {
        $this->createIndex('created_at', '{{%order}}', 'created_at');
    }

    public function safeDown()
    {
        $this->dropIndex('created_at', '{{%order}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171006_150541_improve_order_table cannot be reverted.\n";

        return false;
    }
    */
}
