<?php

use yii\db\Migration;

class m171006_152841_improve_category_table extends Migration
{
    public function safeUp()
    {
        $this->createIndex('status','{{%category}}', 'status');
        $this->createIndex('top',   '{{%category}}', 'isTop');
        $this->createIndex('depth', '{{%category}}', 'depth');
    }

    public function safeDown()
    {
        $this->dropIndex('status',  '{{%category}}');
        $this->dropIndex('top',     '{{%category}}');
        $this->dropIndex('depth',   '{{%category}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171006_152841_improve_category_table cannot be reverted.\n";

        return false;
    }
    */
}
