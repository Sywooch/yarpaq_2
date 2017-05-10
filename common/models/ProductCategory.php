<?php
namespace common\models;

use yii\db\ActiveRecord;

class ProductCategory extends ActiveRecord
{

    /**
     * Удаляет старые связи и довбаляет новые
     *
     * @param $categoryIDs Array Массив ID привязанных категорий
     * @param $product_id Integer ID продукта
     * @throws \yii\db\Exception
     */
    public static function saveProductCategories($categoryIDs, $product_id) {
        $db = self::getDb();

        $transaction = $db->beginTransaction();

        // удаляем старые категории
        self::deleteByProductID($product_id);

        // добавляем новые, если есть
        if ($categoryIDs && is_array($categoryIDs)) {
            foreach ($categoryIDs as $category_id) {
                $productCategory = new ProductCategory();
                $productCategory->category_id = $category_id;
                $productCategory->product_id = $product_id;
                $productCategory->save();
            }
        }


        $transaction->commit();
    }

    public static function deleteByProductID($product_id) {
        $sql = 'DELETE FROM '.self::tableName().' WHERE `product_id` = '.(int) $product_id;
        return self::getDb()->createCommand($sql)->query();
    }
}