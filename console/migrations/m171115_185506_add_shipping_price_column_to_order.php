<?php

use yii\db\Migration;

class m171115_185506_add_shipping_price_column_to_order extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%order}}', 'shipping_price', $this->decimal()->after('shipping_code'));
    }

    public function safeDown()
    {
        $this->dropColumn('{{%order}}', 'shipping_price');
    }
}
