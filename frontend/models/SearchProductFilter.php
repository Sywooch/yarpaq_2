<?php

namespace frontend\models;

use Yii;

class SearchProductFilter extends ProductFilter
{
    const SORT_SCORE_HIGHEST = 'score_highest';

    public $sort = self::SORT_SCORE_HIGHEST;

    public function getSortOptions() {
        return [
            self::SORT_SCORE_HIGHEST    => Yii::t('app', 'Best match'),
            self::SORT_PRICE_LOWEST     => Yii::t('app', 'Price: lowest first'),
            self::SORT_PRICE_HIGHEST    => Yii::t('app', 'Price: highest first'),
            self::SORT_NEWLY_LISTED     => Yii::t('app', 'Newly listed'),
        ];
    }
}