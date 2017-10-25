<?php

namespace common\models\notification;

use common\models\User;
use Yii;
use yii\base\Exception;
use yii\helpers\ArrayHelper;

class NewOrderSellerNotification extends Notification
{
    protected $layout = 'new-order-for-seller';
    private $productsBySeller = [];
    private $order;

    public function __construct($order) {
        $this->subject = Yii::t('app', 'New order').': '.$order->id;
        $this->order = $order;

        // group products by seller id
        $this->productsBySeller = ArrayHelper::map($order->getOrderProducts()->with('product')->all(), 'id', function ($orderProduct) {
            return $orderProduct;
        }, function ($orderProduct) {
            return $orderProduct->product->seller->id;
        });
    }

    public function send() {
        foreach ($this->productsBySeller as $seller_id => $orderProducts ) {
            $seller = User::findOne($seller_id);

            if (!$seller) {
                throw new Exception('Seller not found');
            }

            $this->to = $seller->email;
            $this->layoutData = [
                'order' => $this->order,
                'orderProducts' => $orderProducts
            ];
            parent::send();
        }
    }
}