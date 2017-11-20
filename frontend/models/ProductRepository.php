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

    /**
     * Фильтрует результат по ID
     *
     * @param $id array|string
     * @return $this
     */
    public function filterByID($id) {
        if (!is_array($id)) {
            $id = [$id];
        }

        $this->andFilterWhere(['in', '{{%product}}.id', $id]);

        return $this;
    }

    /**
     * Фильтрует по категории товара
     *
     * @param Category $category Категория
     * @param bool|true $wholeBranch Учитывать ли вложенные категории
     * @return $this
     */
    public function withinCategory(Category $category, $wholeBranch = true) {
        if ($wholeBranch) {
            $categoryQuery = Category::find()
                ->select('id')
                ->andWhere(['>', 'lft', $category->lft])
                ->andWhere(['<', 'rgt', $category->rgt]);
        } else {
            $categoryQuery = $category->id;
        }


        $this->joinWith('productCategories pc');
        $this->andWhere(['pc.category_id' => $categoryQuery]);

        return $this;
    }

    public function filterBySellerID($id) {
        $this->andWhere(['user_id' => $id]);

        return $this;
    }

    public function withOptionValues(array $optionValues) {
        $this->joinWith('productOptions po');
        $this->leftJoin('{{%product_option_value}} pov', 'pov.product_option_id = po.id');
        $this->andWhere(['pov.option_value_id' => $optionValues]);

        return $this;
    }
}