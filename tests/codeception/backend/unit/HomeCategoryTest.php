<?php

namespace tests\codeception\backend\unit;


use common\models\Product;
use tests\codeception\frontend\fixtures\CategoryFixture;

class HomeCategoryTest extends DbTestCase
{

    public function fixtures()
    {
        return [
            'categories' => CategoryFixture::className(),
        ];
    }

    public function testCreateHomeCategory() {

        // создание

        //$homeCategory = new HomeCategory();
    }
}