<?php

use yii\db\Migration;

class m170920_131244_add_product_default_price extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%product}}', 'cost_price', \yii\db\mysql\Schema::TYPE_DOUBLE);
    }

    public function safeDown()
    {
        $this->dropColumn('{{%product}}', 'cost_price');

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170920_131244_add_product_default_price cannot be reverted.\n";

        return false;
    }
    */
}
