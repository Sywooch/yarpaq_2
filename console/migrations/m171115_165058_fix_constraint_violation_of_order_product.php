<?php

use yii\db\Migration;

class m171115_165058_fix_constraint_violation_of_order_product extends Migration
{
    public function safeUp()
    {
        $this->db->createCommand('UPDATE {{%order_product}} op SET `product_id` = NULL WHERE NOT EXISTS (SELECT id FROM {{%product}} p WHERE p.id = op.product_id ) ')->execute();
        $this->addForeignKey('op_product_id', '{{%order_product}}', 'product_id', '{{%product}}', 'id', 'SET NULL', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('op_product_id', '{{%order_product}}');
    }
}