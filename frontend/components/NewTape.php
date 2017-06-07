<?php

namespace frontend\components;


use common\models\Product;

class NewTape extends Tape
{
    public $mainLabel = 'New products';
    public $seeAllLabel = 'See All';

    public function loadProducts() {
        $this->products = Product::find()
            ->andWhere(['status_id' => Product::STATUS_ACTIVE])
            ->orderBy(['moderated_at' => SORT_DESC])
            ->limit(10)
            ->all();
    }
}