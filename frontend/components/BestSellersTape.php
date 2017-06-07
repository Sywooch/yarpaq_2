<?php

namespace frontend\components;


use common\models\order\OrderProduct;

class BestSellersTape extends Tape
{
    public $mainLabel = 'Bestsellers';
    public $seeAllLabel = 'See All';

    public function loadProducts() {
        $topSellOrderProducts = OrderProduct::find('product_id IS NOT NULL')
            ->select(['COUNT(product_id) AS count, product_id'])
            ->groupBy('product_id')
            ->orderBy('count')
            ->limit(10)
            ->with('product')
            ->all();

        foreach ($topSellOrderProducts as $orderProduct) {
            $this->products[] = $orderProduct->product;
        }
    }
}