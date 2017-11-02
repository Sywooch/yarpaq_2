<?php

namespace common\models\notification;

use common\models\User;
use Yii;
use yii\base\Exception;
use yii\helpers\ArrayHelper;

class OrderStatusChangedSellerNotification extends Notification
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

            $header = $this->getHeader($this->order);

            $this->to = $seller->email;
            $this->layoutData = [
                'order' => $this->order,
                'orderProducts' => $orderProducts,
                'header' => Yii::t('mail', $header)
            ];
            parent::send();
        }
    }

    protected function getHeader($order) {
        switch ($order->order_status_id) {
            case '3':
                return Yii::t('mail', 'Your order has been sent');
                break;
            case '7':
                return Yii::t('mail', 'Your order has been canceled');
                break;
            default:
                return Yii::t('mail', 'Your order status is "{status_name}"', ['status_name' => $order->status->name]);
                break;
        }
    }
}