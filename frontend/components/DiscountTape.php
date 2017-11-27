<?php

namespace frontend\components;

use frontend\models\ProductRepository;

class DiscountTape extends Tape
{
    public $mainLabel = 'Discount products';
    public $seeAllLabel = 'See All';

    public function loadProducts() {
        $repo = new ProductRepository();
        $this->products = $repo
            ->visibleOnTheSite()
            ->hasDiscount()
            ->orderBy(['d.id' => SORT_DESC])
            ->limit(10)
            ->all();
    }
}