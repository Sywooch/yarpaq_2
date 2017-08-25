<?php

namespace frontend\components;

use common\models\Product;

class RecommendedTape extends Tape
{
    public $mainLabel = 'Bestsellers';
    public $seeAllLabel = 'See All';

    public function loadProducts() {
        $topSellOrderProducts = Product::find()
            ->andWhere(['in', 'id', []])
            ->all();

        foreach ($topSellOrderProducts as $orderProduct) {

            if ($orderProduct->product instanceof Product) {
                $this->products[] = $orderProduct->product;
            }

        }
    }
}