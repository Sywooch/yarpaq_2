<?php

use yii\db\Migration;

/**
 * Handles the creation of table `home_category`.
 */
class m171109_133229_create_home_category_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('{{%home_category}}', [
            'id' => $this->primaryKey(),
            'status'            => $this->smallInteger()->notNull(),
            'bg_color'          => $this->string()->notNull(),
            'related_cat_id'    => $this->integer()->notNull(),

            'product_id_1'      => $this->integer()->notNull(),
            'web_name_1'        => $this->string()->notNull(),
            'src_name_1'        => $this->string()->notNull(),

            'product_id_2'      => $this->integer()->notNull(),
            'web_name_2'        => $this->string()->notNull(),
            'src_name_2'        => $this->string()->notNull(),

            'product_id_3'      => $this->integer()->notNull(),
            'web_name_3'        => $this->string()->notNull(),
            'src_name_3'        => $this->string()->notNull(),
        ]);

        $this->addForeignKey('related_cat_id', '{{%home_category}}', 'related_cat_id', '{{%category}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('product_id_1', '{{%home_category}}', 'product_id_1', '{{%product}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('product_id_2', '{{%home_category}}', 'product_id_2', '{{%product}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('product_id_3', '{{%home_category}}', 'product_id_3', '{{%product}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('{{%home_category}}');
    }
}
