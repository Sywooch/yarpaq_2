<?php

use yii\db\Migration;

class m171002_102602_discount extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%discount}}', [
            'id'            => $this->primaryKey()->notNull(),
            'product_id'    => $this->integer()->notNull(),
            'value'         => $this->double()->notNull(),
            'period'        => $this->smallInteger()->notNull(),
            'start_date'    => $this->dateTime(),
            'end_date'      => $this->dateTime()
        ]);

        $this->addForeignKey('product', '{{%discount}}', 'product_id', '{{%product}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropTable('{{%discount}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171002_102602_discount cannot be reverted.\n";

        return false;
    }
    */
}
