<?php

namespace tests\codeception\backend\unit;


use common\models\Product;
use tests\codeception\frontend\fixtures\ProductFixture;

class ProductTest extends DbTestCase
{

    public function fixtures()
    {
        return [
            'products' => ProductFixture::className(),
        ];
    }

    public function testAutoInStock() {

        // берем продукт
        $product = $this->products('product1');

        // ставим количесво = 0, сохраняем
        $product->quantity = 0;
        $product->save();

        // Проверка: статус Out Of Stock
        $this->assertTrue( $product->stock_status_id == Product::AVAILABILITY_OUT_OF_STOCK );

        // ставим количество = 1, сохраняем
        $product->quantity = 1;
        $product->save();

        // Проверка: статус In Stock
        $this->assertTrue( $product->stock_status_id == Product::AVAILABILITY_IN_STOCK );

    }
}