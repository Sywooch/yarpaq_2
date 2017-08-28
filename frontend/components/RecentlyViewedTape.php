<?php

namespace frontend\components;


use common\models\Product;
use frontend\models\ViewedProduct;

class RecentlyViewedTape extends Tape
{
    public $mainLabel = 'Recently viewed products';
    public $seeAllLabel = '';

    public function loadProducts() {
        $viewed = ViewedProduct::find()
            ->joinWith('product p')
            ->with('product')
            ->andWhere(['p.status_id' => Product::STATUS_ACTIVE])
            ->andWhere(['p.moderated' => 1])
            ->all();

        foreach ($viewed as $viewed_item) {
            if ($viewed_item->product instanceof Product) {
                $this->products[] = $viewed_item->product;
            }
        }
    }
}