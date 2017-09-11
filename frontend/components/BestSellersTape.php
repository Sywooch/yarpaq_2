<?php

namespace frontend\components;


use common\models\order\OrderProduct;
use common\models\Product;

class BestSellersTape extends Tape
{
    public $mainLabel = 'Bestsellers';
    public $seeAllLabel = 'See All';

    public function loadProducts() {
        $last_3_months = new \DateTime('-3 months');

        $topSellOrderProducts = OrderProduct::find('product_id IS NOT NULL')
            ->select(['COUNT(product_id) AS count, product_id'])
            ->joinWith('product p', 'p.id = {{%order_product}}.product_id')
            ->andWhere(['p.status_id' => Product::STATUS_ACTIVE])
            ->andWhere(['p.moderated' => 1])
            ->joinWith('order o', 'o.id = {{%order_product}}.order_id')
            ->andWhere(['>=', 'o.created_at', $last_3_months->format('Y-m-d H:i:s')])
            ->andWhere(['o.order_status_id' => 23])
            ->groupBy('product_id')
            ->orderBy(['count' => SORT_DESC])
            ->limit(20)
            ->with('product')
            ->all();

        foreach ($topSellOrderProducts as $orderProduct) {

            if ($orderProduct->product instanceof Product) {
                $this->products[] = $orderProduct->product;
            }

        }
    }
}