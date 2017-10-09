<?php

namespace frontend\models;


use common\models\category\Category;
use yii\db\ActiveQuery;

class CategoryRepository extends ActiveQuery
{

    public function __construct() {
        parent::__construct(Category::className());

        $this->orderBy('lft');
    }

    public function baseCategories() {
        $this->andWhere(['depth' => 2]);

        return $this;
    }

    public function visibleOnTheSite() {
        $this->andWhere(['>=', 'depth', 2])
            ->andWhere(['status' => Category::STATUS_ACTIVE])
            ->andWhere(['isTop' => 0]);

        return $this;
    }
}