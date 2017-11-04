<?php

namespace tests\codeception\frontend\unit;


use common\models\product\Discount;
use frontend\models\ProductRepository;
use tests\codeception\frontend\fixtures\ProductFixture;

class SaleCategory extends DbTestCase
{
    public function fixtures()
    {
        return [
            'products' => ProductFixture::className(),
        ];
    }

    public function testFindProductWithDiscount() {

        // берем продукт
        $product = $this->products('product1');

        // даем скидку
        $discount = new Discount();
        $discount->value = 8;

        $product->setDiscount($discount);

        // поиск по товарам, с учетом наличия скидки
        $repo = new ProductRepository();
        $products = $repo
            ->hasDiscount()
            //->filterByID( $product->id )
            ->all();

        $this->assertTrue( $products[0]->id == $product->id );
    }

}