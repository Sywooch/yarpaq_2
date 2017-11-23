<?php

use yii\db\Migration;

class m171123_172704_add_seo_title_column_to_category extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%category_content}}', 'seo_header', $this->string(). ' AFTER `name`');
    }

    public function safeDown()
    {
        $this->dropColumn('{{%category_content}}', 'seo_header');
    }
}
