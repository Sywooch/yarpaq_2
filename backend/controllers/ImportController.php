<?php

namespace backend\controllers;

use webvimark\components\AdminDefaultController;
use Yii;

class ImportController extends AdminDefaultController
{

    public function actionIndex() {
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 3000); //3000 seconds = 50 minutes

        $this->cleanCategories();
        $this->cleanProducts();
        $this->cleanUsers();
    }

    protected function cleanCategories() {
        $db = Yii::$app->db;

        $db->createCommand('DELETE FROM {{%category}} WHERE parent_id > 0')->execute();
        $db->createCommand('DELETE FROM cat_assoc')->execute();
    }

    protected function cleanProducts() {
        $db = Yii::$app->db;

        $db->createCommand('SET FOREIGN_KEY_CHECKS = 0')->execute();
        $db->createCommand('TRUNCATE TABLE {{%product_image}}')->execute();
        $db->createCommand('TRUNCATE TABLE {{%product_category}}')->execute();
        $db->createCommand('TRUNCATE TABLE {{%product_option}}')->execute();
        $db->createCommand('TRUNCATE TABLE {{%product_option_value}}')->execute();
        $db->createCommand('TRUNCATE TABLE {{%product}}')->execute();
        $db->createCommand('DELETE FROM product_assoc')->execute();
        $db->createCommand('SET FOREIGN_KEY_CHECKS = 1')->execute();
    }

    protected function cleanUsers() {
        $db = Yii::$app->db;

        $db->createCommand('DELETE FROM {{%user}} WHERE id > 1')->execute();
        $db->createCommand('ALTER TABLE {{%user}} AUTO_INCREMENT=2;')->execute();
    }




}