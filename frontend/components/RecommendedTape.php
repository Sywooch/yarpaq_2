<?php

namespace frontend\components;

use common\models\Product;
use frontend\models\ProductRepository;

class RecommendedTape extends Tape
{
    public $mainLabel = 'Bestsellers';
    public $seeAllLabel = 'See All';

    public function loadProducts() {
        $repo = new ProductRepository();

        $topSellOrderProducts = $repo
            ->visibleOnTheSite()
            //->andWhere(['in', 'id', []])
            ->all();

        foreach ($topSellOrderProducts as $orderProduct) {

            if ($orderProduct->product instanceof Product) {
                $this->products[] = $orderProduct->product;
            }

        }
    }
}