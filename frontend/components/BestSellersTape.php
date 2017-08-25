<?php

namespace frontend\components;


use common\models\order\OrderProduct;
use common\models\Product;

class BestSellersTape extends Tape
{
    public $mainLabel = 'Bestsellers';
    public $seeAllLabel = 'See All';

    public function loadProducts() {
        $topSellOrderProducts = OrderProduct::find('product_id IS NOT NULL')
            ->select(['COUNT(product_id) AS count, product_id'])
            ->joinWith('product p')
            ->andWhere(['p.status_id' => Product::STATUS_ACTIVE])
            ->groupBy('product_id')
            ->orderBy(['count' => SORT_DESC])
            ->limit(10)
            ->with('product')
            ->all();

        foreach ($topSellOrderProducts as $orderProduct) {

            if ($orderProduct->product instanceof Product) {
                $this->products[] = $orderProduct->product;
            }

        }
    }
}