<?php
/**
 * Created by PhpStorm.
 * User: timurkarimov
 * Date: 10/29/17
 * Time: 00:23
 */

namespace tests\codeception\frontend\unit;


use common\models\Product;
use tests\codeception\frontend\fixtures\CategoryFixture;

class CategoryTest extends DbTestCase
{

    public function fixtures()
    {
        return [
            'categories' => CategoryFixture::className(),
        ];
    }


    /**
     * При деактивации категории, дочерние тоже должны быть деактивированы
     */
    public function testAutoDeactivateChildrenCategories() {
        $root = $this->categories('root');
        $category1 = $this->categories('cat1');

        // Сначала дочерняя категория активна
        $this->assertTrue( $category1->isVisible() );

        // Деактивируем root
        $root->deactivate();

        // Вложенная категори тоже деактивируется
        $category1->refresh();
        $this->assertFalse( $category1->isVisible() );
    }
}