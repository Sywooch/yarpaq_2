<?php

namespace common\models\notification;

use Yii;

class NewOrderUserNotification extends Notification
{
    protected $layout = 'new-order-for-user';

    public function __construct($order) {
        $this->subject = Yii::t('app', 'Thank you for your order');

        $this->to = $order->email;

        $this->layoutData = [
            'order'     => $order,
            'header'    => Yii::t('mail', 'Sifarişiniz qəbul olundu')
        ];
    }
}