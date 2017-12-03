<?php

namespace tests\codeception\frontend\unit;


use common\models\Product;
use common\models\search\SearchLog;
use common\models\search\SearchLogger;

class SearchLogTest extends DbTestCase
{

    /**
     * Когда поиск ничего не находит
     */
    public function testSearchWithNoResult() {

        $random_keyword = 'keyword '.rand(10000, 100000);

        SearchLogger::log($random_keyword, 0);

        $row = SearchLog::find()
            ->where(['text' => $random_keyword])
            ->andWhere(['no_result' => 1])
            ->one();

        $this->assertTrue((bool)$row);
    }
}