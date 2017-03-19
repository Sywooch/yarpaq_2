<?php

namespace backend\controllers;

use common\models\category\Category;
use common\models\category\CategoryContent;
use webvimark\components\AdminDefaultController;
use Yii;
use yii\base\Exception;
use yii\web\Controller;

class CategoryImportController extends AdminDefaultController
{
    private $catAssoc;
    private $categories;
    private $categories_description;
    private $languages;
    private $errorModels = [];
    private $contents = [];


    public function actionIndex() {
        ini_set('memory_limit', '-1');

        $this->importCategories();
    }

    private function getCatAssoc() {

        $sql = 'SELECT `old_id`, `new_id` FROM `cat_assoc`';

        $assocs = Yii::$app->db->createCommand($sql)->queryAll();

        $ids = ['0' => 1];
        foreach ($assocs as $assoc) {
            $ids[ $assoc['old_id'] ] = $assoc['new_id'];
        }

        return $ids;
    }

    private function importCategories() {
        // достаем ассоциации Categories
        $this->catAssoc = $this->getCatAssoc();

        // запрос для получения категорий со старого сайта
        $category_sql = 'SELECT * FROM `oc_category` ORDER BY `category_id`';
        $category_description_sql = 'SELECT d.*, a.keyword FROM `oc_category_description` d LEFT JOIN `oc_url_alias` `a` ON `query` = concat("category_id=", d.category_id) ORDER BY d.`category_id`';

        // выполняем запрос
        $this->categories = Yii::$app->db_old->createCommand($category_sql)->queryAll();

        $categories_description = Yii::$app->db_old->createCommand($category_description_sql)->queryAll();
        foreach ($categories_description as $desc) {
            $this->categories_description[ $desc['category_id'] ][] = $desc;
        }

        $this->languages = [
            1 => 2, // English
            2 => 3, // Russian
            3 => 1, // Azeri
        ];

        $this->errorModels = ['models' => [], 'profiles' => []];

        $this->handleNodeChildren(0);

        $this->printReport();

    }

    private function handleNodeChildren($node_id) {
        foreach ($this->categories as $category) {
            // обрабатываем только корневые, остальные пойдут уже внутри
            if ($category['parent_id'] == $node_id) {
                $this->handleCategory($category, $node_id);
            }
        }
    }

    private function handleCategory($category, $parent) {
        $model = $this->getModel($category['category_id']);
        $this->fillModel($model, $this->categories_description[$category['category_id']]);
        $success = $this->saveModel($model, $category['category_id'], $parent);

        if ($success) {
            $this->handleNodeChildren($category['category_id']);
        }
    }

    private function saveModel($model, $old_id, $parent) {
        $tr = Yii::$app->db->beginTransaction();

        try {
            // сохраняем модель
            $parent = Category::findOne($this->catAssoc[$parent]);
            $model->parent_id = $parent->id;

            if ($this->hasAssoc($old_id)) {
                $modelSaved = $model->save();
            } else {
                $modelSaved = $model->appendTo($parent);
            }

            if (!$modelSaved) {
                $this->errorModels['models'][$old_id] = $model;
                throw new Exception('model #' . $old_id . ' not saved');
            }


            // сохраняем описание
            foreach ($this->contents as $content) {
                $content->category_id = $model->id;
                if (!$content->save()) {
                    $errors['profiles'][$old_id] = $content;
                    throw new Exception('desc #'.$old_id.' not saved');
                }
            }



            // сохраняем ассоциацию, если ее не было
            if (!$this->hasAssoc($old_id)) {
                $replace_sql = 'REPLACE INTO `cat_assoc` (`old_id`, `new_id`) VALUES ('.$old_id.', '.$model->id.')';
                Yii::$app->db->createCommand($replace_sql)->execute();
            }

            $this->catAssoc[ $old_id ] = $model->id;

            $tr->commit();

            return true;

        } catch (Exception $e) {
            $tr->rollBack();

            return false;
        }
    }

    private function fillModel($model, $desc_data) {
        $this->contents = []; // reset contents

        /**
         * @var $model Category
         */

        // основное
        $model->status          = 1;
        $model->template_id     = 1;


        // описание на 3 языках
        foreach ($desc_data as $desc) {

            $content                = $this->getContent($model, $desc['language_id']);

            $content->title         = $desc['name'];
            $content->name          = $desc['keyword'];
            $content->seo_keywords      = '';
            $content->seo_description   = '';

            $this->contents[] = $content;

        }
    }

    private function getContent($model, $lang_id) {
        $lang_id = $this->languages[$lang_id];

        $content = new CategoryContent();
        $content->lang_id = $lang_id;
        $content->category_id = $model->id;

        $tmp = CategoryContent::findOne(['category_id' => $model->id, 'lang_id' => $lang_id]);
        if ($tmp) {
            $content = $tmp;
        }

        return $content;
    }

    /**
     * Проверка - имеется ли ассоциация
     *
     * @param $old_cat_id
     * @return bool
     */
    private function hasAssoc($old_cat_id) {
        return in_array($old_cat_id, array_keys($this->catAssoc));
    }

    /**
     * Если есть ассоциация, то возвращается модель из базы.
     * Если нет, то создается новая.
     *
     * @param $old_cat_id
     * @return Category|static
     */
    private function getModel($old_cat_id) {
        $model = new Category();
        // если ассоциация есть, то обновляем данные
        if ($this->hasAssoc($old_cat_id)) {
            $tmp = Category::findOne($this->catAssoc[ $old_cat_id ]);

            if ($tmp) {
                $model = $tmp;
            }
        }

        return $model;
    }

    private function printReport() {

        $errors = $this->errorModels;

        // Print report
        if (count($errors['models'])) {
            echo '<h2>Categories report</h2>';
            echo '<table>';

            echo '<tr><td><b>Category ID</b></td><td><b>Errors (total error models '.count($errors['models']).')</b></td></tr>';

            foreach ($errors['models'] as $oid => $err_model) {
                echo '<tr>';

                echo '<td>#'.$oid.'</td>';

                echo '<td>';

                foreach ($err_model->getErrors() as $error) {
                    echo implode(', ', $error).'<br>';
                } unset($error);

                echo '</td>';



                echo '</tr>';
            }

            echo '</table>';
        }


        // Print report
        if (count($errors['profiles'])) {
            echo '<h2>Content report</h2>';
            echo '<table>';

            echo '<tr><td><b>Category ID</b></td><td><b>Errors (total error profiles '.count($errors['profiles']).')</b></td></tr>';

            foreach ($errors['profiles'] as $oid => $err_model) {
                echo '<tr>';

                echo '<td>#'.$oid.'</td>';

                echo '<td>';

                foreach ($err_model->getErrors() as $error) {
                    echo implode(', ', $error).'<br>';
                } unset($error);

                echo '</td>';



                echo '</tr>';
            }

            echo '</table>';
        }
    }
}