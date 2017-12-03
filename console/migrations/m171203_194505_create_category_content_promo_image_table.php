<?php

use yii\db\Migration;

/**
 * Handles the creation of table `category_content_promo_image`.
 */
class m171203_194505_create_category_content_promo_image_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%category_content_promo_image}}', [
            'id' => $this->primaryKey(),
            'model_id' => $this->integer()->notNull(),
            'src_name' => $this->string()->notNull(),
            'web_name' => $this->string()->notNull(),
            'sort' => $this->smallInteger()->notNull()
        ]);

        $this->addForeignKey('promo_image_model', '{{%category_content_promo_image}}', 'model_id', '{{%category_content}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%category_content_promo_image}}');
    }
}
