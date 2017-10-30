<?php

namespace frontend\models;


use common\models\category\Category;
use common\models\Product;
use common\models\product\Discount;
use yii\db\ActiveQuery;
use yii\db\Query;

class ProductRepository extends ActiveQuery
{

    public function __construct() {
        parent::__construct(Product::className());
    }

    public function visibleOnTheSite() {
        $this->andWhere(['status_id' => Product::STATUS_ACTIVE]);
        $this->andWhere(['moderated' => 1]);

        $this->joinWith(['categories c']);
        $this->andWhere(['c.status' => Category::STATUS_ACTIVE]);
        $this->groupBy('{{%product}}.id');

        return $this;
    }

    public function hasDiscount() {
        $this->joinWith('discount d');
        $this->andWhere('d.value IS NOT NULL');

        $now = (new \DateTime())->format('Y-m-d H:i:s');
        $this->andWhere(['or',
            ['d.period' => Discount::PERIOD_CONSTANT],
            [
                'and',
                ['d.period' => Discount::PERIOD_RANGE],
                ['<=', 'd.start_date', $now],
                ['>=', 'd.end_date', $now]
            ]
        ]);

        return $this;
    }
}