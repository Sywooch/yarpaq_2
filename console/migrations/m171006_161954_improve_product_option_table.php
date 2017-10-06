<?php

use yii\db\Migration;

class m171006_161954_improve_product_option_table extends Migration
{
    public function safeUp()
    {
        $this->createIndex('viewed',    '{{%product}}', 'viewed');
        $this->createIndex('updated_at','{{%product}}', 'updated_at');

        $this->createIndex('product_id','{{%product_option}}', 'product_id');
    }

    public function safeDown()
    {
        $this->dropIndex('viewed',      '{{%product}}');
        $this->dropIndex('updated_at',  '{{%product}}');

        $this->dropIndex('product_id',  '{{%product_option}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171006_161954_improve_product_option_table cannot be reverted.\n";

        return false;
    }
    */
}
