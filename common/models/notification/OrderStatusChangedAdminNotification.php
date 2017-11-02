<?php

namespace common\models\notification;

use Yii;

class OrderStatusChangedAdminNotification extends Notification
{

    public $subject;
    protected $layout = 'new-order-for-admin';

    public function __construct($order) {
        $this->subject = Yii::t('app', 'New order').': '.$order->id;

        $this->to = 'sales@yarpaq.az';

        $header = $this->getHeader($order);

        $this->layoutData = [
            'order' => $order,
            'header' => Yii::t('mail', $header)
        ];
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