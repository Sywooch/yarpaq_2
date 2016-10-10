<?php

use yii\db\Migration;

class m161004_200540_remove_ip_not_null_user_visit_log extends Migration
{
    public function up()
    {
        $table_name = \Yii::$app->getModule('user-management')->user_visit_log_table;
        $this->alterColumn($table_name, 'ip', 'varchar(15)');
    }

    public function down()
    {
        $table_name = \Yii::$app->getModule('user-management')->user_visit_log_table;
        $this->alterColumn($table_name, 'ip', 'varchar(15) not null');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
