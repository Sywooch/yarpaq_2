<?php

namespace common\models\product;

use frontend\models\ProductRepository;
use Yii;

/**
 *
 * Class ProductBulkDeleter
 * Отвечает за массовое удаление товаров включая их картинки
 *
 * @package common\models\product
 */
class ProductBulkDeleter
{
    protected $ids;

    public function __construct(array $ids) {
        $this->ids = $ids;
    }

    /**
     * Запуск удаления
     */
    public function execute() {
        $products = (new ProductRepository())->filterByID($this->ids)->with('gallery')->all();


        // Удаление продуктов
        $db = Yii::$app->db;
        $db->createCommand()
            ->delete('{{%product}}', ['id' => $this->ids])
            ->execute();


        // Удаление картинок с жесткого диска
        foreach ($products as $product) {
            foreach ($product->gallery as $image) {
                $image->deleteImage();
            }
        }
    }
}