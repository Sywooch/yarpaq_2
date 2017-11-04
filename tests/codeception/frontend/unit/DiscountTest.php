<?php

namespace tests\codeception\frontend\unit;

use tests\codeception\frontend\fixtures\ProductFixture;
use common\models\product\Discount;

class DiscountTest extends DbTestCase
{
    public function fixtures()
    {
        return [
            'products' => ProductFixture::className(),
        ];
    }

    public function testDiscountAppliance() {

        /**
         * @var $product   \common\models\Product
         */

        // берем продукт
        $product = $this->products('product1');

        // даем скидку
        $discount = new Discount();
        $discount->value = 8;

        $product->setDiscount($discount);


        // проверяем есть ли у товара скидка
        $product->refresh();
        $this->assertTrue( $product->hasDiscount() );
    }
}