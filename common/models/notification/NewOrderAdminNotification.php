<?php

namespace common\models\notification;

use Yii;

class NewOrderAdminNotification extends Notification
{

    public $subject;
    protected $layout = 'new-order-for-admin';

    public function __construct($user, $order) {
        $this->subject = Yii::t('app', 'New order').': '.$order->id;

        $this->to = 'sales@yarpaq.az';

        $this->layoutData = [
            'order' => $order,
            'user'  => $user
        ];
    }
}