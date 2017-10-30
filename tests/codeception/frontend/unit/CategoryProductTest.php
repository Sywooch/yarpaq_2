<?php
/**
 * Created by PhpStorm.
 * User: timurkarimov
 * Date: 10/29/17
 * Time: 00:23
 */

namespace tests\codeception\frontend\unit;


use common\models\Product;
use frontend\models\ProductRepository;
use tests\codeception\frontend\fixtures\CategoryFixture;
use tests\codeception\frontend\fixtures\ProductFixture;

class ProductVisibilityTest extends DbTestCase
{

    public function fixtures()
    {
        return [
            'products' => ProductFixture::className(),
            'categories' => CategoryFixture::className(),
        ];
    }

    /**
     * Видимость товара с активной категории и без нее
     */
    public function testVisibilityWithCategoryAndWithout() {
        /**
         * @var $product   \common\models\Product
         * @var $category1 \common\models\category\Category
         * @var $category2 \common\models\category\Category
         */
        // Берем товар
        $product = $this->products('product1');

        // Берем 2 категории
        $category1 = $this->categories('cat1');
        $category2 = $this->categories('cat2');

        // Привязываем товар к обеим категории
        $product->assignToCategory($category1);
        $product->assignToCategory($category2);

        // Обе категории делаем активные
        $category1->activate();
        $category2->activate();

        // Проверка: товар должен быть виден
        $product->refresh();
        $this->assertTrue( $product->isVisible() );

        // Скрываем одну категорию
        $category1->deactivate();

        // Проверка: товар по-прежнему виден
        $product->refresh();
        $this->assertTrue( $product->isVisible() );

        // Скрываем вторую категорию
        $category2->deactivate();

        // Проверка: товар становится не виден
        $product->refresh();
        $this->assertFalse( $product->isVisible() );
    }

    /**
     * При поиске товаров (в категории или в поиске) выбирать только те товары,
     * у которых есть хотябы одна активная категория
     */
    public function testFindProductsOnlyWithActiveCategory() {
        /**
         * @var $product   \common\models\Product
         * @var $category1 \common\models\category\Category
         * @var $category2 \common\models\category\Category
         */
        // Берем товар
        $product = $this->products('product1');


        // Берем 2 категории
        $category1 = $this->categories('cat1');
        $category2 = $this->categories('cat2');


        // Привязываем товар к обеим категории
        $product->assignToCategory($category1);
        $product->assignToCategory($category2);


        // Обе категории делаем активные
        $category1->activate();
        $category2->activate();


        // Проверка: делаем выборку и товар должен быть найден
        $this->assertTrue( count( $this->productSelect() ) == 1 );


        // Скрываем одну категорию
        $category1->deactivate();


        // Проверка: делаем выборку и товар опять же должен быть найден
        $this->assertTrue( count( $this->productSelect() ) == 1 );


        // Скрываем вторую категорию
        $category2->deactivate();


        // Проверка: делаем выборку и товар не должен быть найден
        $this->assertFalse( count( $this->productSelect() ) == 1 );
    }

    private function productSelect() {
        $productsRepo = new ProductRepository();
        return $productsRepo->visibleOnTheSite()->limit(1)->all();
    }
}