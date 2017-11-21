<?php

use yii\db\Migration;

class m171120_204247_alter_review_table extends Migration
{
    public function safeUp()
    {
        $this->dropColumn('{{%review}}', 'type');
        $this->addColumn('{{%review}}', 'stars', $this->integer());
        $this->addColumn('{{%review}}', 'status', $this->integer());
    }

    public function safeDown()
    {
        $this->addColumn('{{%review}}', 'type', $this->string());
        $this->dropColumn('{{%review}}', 'stars');
        $this->dropColumn('{{%review}}', 'status');
    }

}
