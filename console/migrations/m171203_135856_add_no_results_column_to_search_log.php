<?php

use yii\db\Migration;

class m171203_135856_add_no_results_column_to_search_log extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%search_log}}', 'no_result', $this->smallInteger());
    }

    public function safeDown()
    {
        $this->dropColumn('{{%search_log}}', 'no_result');
    }
}
