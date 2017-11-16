<?php

use yii\db\Migration;

class m171115_194152_add_subtotal_column_to_order extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%order}}', 'subtotal', $this->decimal()->after('comment'));
    }

    public function safeDown()
    {
        $this->dropColumn('{{%order}}', 'subtotal');
    }
}
