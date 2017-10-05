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
            ->orderBy(['moderated_at' => SORT_DESC])
            ->limit(10)
            ->all();
    }
}