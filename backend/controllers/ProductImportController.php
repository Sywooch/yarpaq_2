<?php

namespace backend\controllers;

use common\models\category\Category;
use common\models\category\CategoryContent;
use common\models\Product;
use common\models\ProductImage;
use webvimark\components\AdminDefaultController;
use Yii;
use yii\base\Exception;

class ProductImportController extends AdminDefaultController
{
    private $productAssoc;
    private $products;
    private $errorModels = [];
    private $userAssoc;
    private $manAssoc;


    public function actionClearFakeImages() {
        $images = ProductImage::find()
//            ->andWhere(['model_id' => 9866])
            ->all();

        foreach ($images as $image) {

            if (!is_file($image->path)) {
                $image->delete();
            }

        }
    }

    public function actionIndex() {
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 3000); //3000 seconds = 50 minutes

        $this->userAssoc    = $this->getUserAssoc();
        $this->manAssoc     = $this->getManAssoc();

        //$this->importProducts();
        //$this->importImages();
    }

    private function getProductAssoc() {

        $sql = 'SELECT `old_id`, `new_id` FROM `product_assoc`';

        $assocs = Yii::$app->db->createCommand($sql)->queryAll();

        $ids = [];
        foreach ($assocs as $assoc) {
            $ids[ $assoc['old_id'] ] = $assoc['new_id'];
        }

        return $ids;
    }


    private function getUserAssoc() {

        $sql = 'SELECT `old_id`, `new_id` FROM `user_assoc` WHERE `type` = "user"';

        $assocs = Yii::$app->db->createCommand($sql)->queryAll();

        $ids = [];
        foreach ($assocs as $assoc) {
            $ids[ $assoc['old_id'] ] = $assoc['new_id'];
        }

        return $ids;
    }

    private function getManAssoc() {

        $sql = 'SELECT `old_id`, `new_id` FROM `man_assoc`';

        $assocs = Yii::$app->db->createCommand($sql)->queryAll();

        $ids = [];
        foreach ($assocs as $assoc) {
            $ids[ $assoc['old_id'] ] = $assoc['new_id'];
        }

        return $ids;
    }

    private function importProducts() {
        // достаем ассоциации Products
        $this->productAssoc = $this->getProductAssoc();

        // запрос для получения товаров со старого сайта
        $product_sql = '
SELECT `p`.*, `pd`.`name` as `d_name`, `pd`.`description` as `d_desc`
FROM `oc_product` `p` LEFT JOIN `oc_product_description` `pd` ON `p`.`product_id` = `pd`.`product_id`
WHERE `pd`.`language_id` = 1 ORDER BY `p`.`product_id`';
        $product_sql .= ' LIMIT 10000, 2000';

        // выполняем запрос
        $this->products = Yii::$app->db_old->createCommand($product_sql)->queryAll();

        $this->errorModels = ['models' => []];

        foreach ($this->products as $product) {
            $model = $this->getModel($product['product_id']);
            $this->fillModel($model, $product);
            $this->saveModel($model, $product['product_id']);
        }

        $this->printReport();

    }


    private function saveModel($model, $old_id) {
        $tr = Yii::$app->db->beginTransaction();

        try {
            // сохраняем модель
            $modelSaved = $model->save();

            if (!$modelSaved) {
                $this->errorModels['models'][$old_id] = $model;
                throw new Exception('model #' . $old_id . ' not saved');
            }

            // сохраняем ассоциацию, если ее не было
            if (!$this->hasAssoc($old_id)) {
                $replace_sql = 'REPLACE INTO `product_assoc` (`old_id`, `new_id`) VALUES ('.$old_id.', '.$model->id.')';
                Yii::$app->db->createCommand($replace_sql)->execute();
            }

            $this->productAssoc[ $old_id ] = $model->id;

            $tr->commit();

            return true;

        } catch (Exception $e) {
            $tr->rollBack();

            return false;
        }
    }

    private function fillModel($model, $desc_data) {
        /**
         * @var $model Category
         */

        $model->title           = $desc_data['d_name'];
        $model->description     = html_entity_decode($desc_data['d_desc']);
        $model->model           = $desc_data['model'];
        $model->sku             = $desc_data['sku'];
        $model->upc             = $desc_data['upc'];
        $model->ean             = $desc_data['ean'];
        $model->jan             = $desc_data['jan'];
        $model->isbn            = $desc_data['isbn'];
        $model->mpn             = $desc_data['mpn'];
        $model->location_id     = 216;
        $model->condition_id    = 1;
        $model->price           = $desc_data['price'];
        $model->currency_id     = 1;
        $model->quantity        = $desc_data['quantity'];
        $model->stock_status_id = $desc_data['stock_status_id'];

        $model->weight          = $desc_data['weight'];
        $model->weight_class_id = $desc_data['weight_class_id'];

        $model->length          = $desc_data['length'];
        $model->width           = $desc_data['width'];
        $model->height          = $desc_data['height'];
        $model->length_class_id = $desc_data['length_class_id'];


        $manufacturer_id = null;
        if (isset($this->manAssoc[$desc_data['manufacturer_id']])) {
            $manufacturer_id = $this->manAssoc[$desc_data['manufacturer_id']];
        }
        $model->manufacturer_id         = $manufacturer_id;

        $user_id = null;
        if (isset($this->userAssoc[$desc_data['user_id']])) {
            $user_id = $this->userAssoc[$desc_data['user_id']];
        }
        $model->user_id         = $user_id;

        $model->moderated       = $desc_data['moderated'];
        $model->moderated_at    = $desc_data['moderation_date'];
        $model->status_id       = $desc_data['status'];
        $model->viewed          = $desc_data['viewed'];

        $model->created_at      = $desc_data['date_added'];
        $model->updated_at      = $desc_data['date_modified'];
    }

    /**
     * Проверка - имеется ли ассоциация
     *
     * @param $old_id
     * @return bool
     */
    private function hasAssoc($old_id) {
        return in_array($old_id, array_keys($this->productAssoc));
    }

    /**
     * Если есть ассоциация, то возвращается модель из базы.
     * Если нет, то создается новая.
     *
     * @param $old_id
     * @return Product|static
     */
    private function getModel($old_id) {
        $model = new Product();
        // если ассоциация есть, то обновляем данные
        if ($this->hasAssoc($old_id)) {
            $tmp = Product::findOne($this->productAssoc[ $old_id ]);

            if ($tmp) {
                $model = $tmp;
            }
        }

        $model->scenario = 'import';

        return $model;
    }

    private function printReport() {

        $errors = $this->errorModels;

        // Print report
        if (count($errors['models'])) {
            echo '<h2>Products report</h2>';
            echo '<table>';

            echo '<tr><td><b>Product ID</b></td><td><b>Errors (total error models '.count($errors['models']).')</b></td></tr>';

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
    }

    private function importImages() {
        $productAssocs = $this->getProductAssoc();

        // очищаем таблицу картинок
        Yii::$app->db->createCommand('TRUNCATE `y2_product_image`')->query();

        // выполняем запрос
        $images_sql = 'SELECT `image`, `product_id` FROM `oc_product`';
        $products = Yii::$app->db_old->createCommand($images_sql)->queryAll();


        foreach ($products as $product) {
            if (!isset($productAssocs[ $product['product_id'] ])) continue;
            if ($product['image'] == '') continue;

            $src = basename($product['image']);
            $url = basename($product['image']);


            $model = new ProductImage();
            $model->model_id    = $productAssocs[ $product['product_id'] ];
            $model->src_name    = $src;
            $model->web_name    = $url;
            $model->sort        = 1;

            if (!$model->save() ) {
                echo $product['product_id'].' '.json_encode( $model->getErrors() ).'<br>';
            }
        }


        $images_sql = 'SELECT `image`, `product_id` FROM `oc_product_image` ORDER BY `product_id`';

        $products = Yii::$app->db_old->createCommand($images_sql)->queryAll();

        $currentProduct = null;
        $sort = 2;
        foreach ($products as $product) {
            if (!isset($productAssocs[ $product['product_id'] ])) continue;
            if ($product['image'] == '') continue;


            if ($product['product_id'] == $currentProduct) {
                $sort++;
            } else {
                $sort = 2;
                $currentProduct = $product['product_id'];
            }


            $src = basename($product['image']);
            $url = basename($product['image']);


            $model = new ProductImage();
            $model->model_id    = $productAssocs[ $product['product_id'] ];
            $model->src_name    = $src;
            $model->web_name    = $url;
            $model->sort        = $sort;

            if (!$model->save() ) {
                echo $product['product_id'].' '.json_encode( $model->getErrors() ).'<br>';
            }
        }

    }
}