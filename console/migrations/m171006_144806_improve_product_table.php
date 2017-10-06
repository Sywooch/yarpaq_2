<?php

use yii\db\Migration;

class m171006_144806_improve_product_table extends Migration
{
    public function safeUp()
    {
        $this->createIndex('status_id',     '{{%product}}', 'status_id');
        $this->createIndex('moderated',     '{{%product}}', 'moderated');
        $this->createIndex('moderated_at',  '{{%product}}', 'moderated_at');
    }

    public function safeDown()
    {
        $this->dropIndex('status_id',       '{{%product}}');
        $this->dropIndex('moderated',       '{{%product}}');
        $this->dropIndex('moderated_at',    '{{%product}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171006_144806_improve_product_table cannot be reverted.\n";

        return false;
    }
    */
}
