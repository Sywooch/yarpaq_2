<?php

use yii\db\Migration;

class m171006_153629_improve_product_image_table extends Migration
{
    public function safeUp()
    {
        $this->createIndex('sort','{{%product_image}}', 'sort');
    }

    public function safeDown()
    {
        $this->dropIndex('sort',  '{{%product_image}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171006_153629_improve_product_image_table cannot be reverted.\n";

        return false;
    }
    */
}
