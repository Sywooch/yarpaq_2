<?php

use yii\db\Migration;

class m161001_090928_add_email_and_email_confirmed_to_user extends Migration
{
	public function safeUp()
	{
		$this->addColumn(Yii::$app->getModule('user-management')->user_table, 'email', 'varchar(128)');
		$this->addColumn(Yii::$app->getModule('user-management')->user_table, 'email_confirmed', 'smallint(1) not null default 0');
		Yii::$app->cache->flush();

	}

	public function safeDown()
	{
		$this->dropColumn(Yii::$app->getModule('user-management')->user_table, 'email');
		$this->dropColumn(Yii::$app->getModule('user-management')->user_table, 'email_confirmed');
		Yii::$app->cache->flush();
	}
}
