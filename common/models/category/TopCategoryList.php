<?php

namespace common\models\category;


class TopCategoryList
{
    public static function getCategories() {
        return Category::find()
            ->andWhere(['isTop' => 1])
            ->andWhere(['depth' => 2])
            ->andWhere(['status' => Category::STATUS_ACTIVE])
            ->orderBy('lft');
    }
}