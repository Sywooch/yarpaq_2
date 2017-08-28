<?php

namespace frontend\components;

use frontend\models\ProductRepository;

class NewTape extends Tape
{
    public $mainLabel = 'New products';
    public $seeAllLabel = 'See All';

    public function loadProducts() {
        $repo = new ProductRepository();
        $this->products = $repo->visibleOnTheSite()
            ->orderBy(['moderated_at' => SORT_DESC])
            ->limit(10)
            ->all();
    }
}