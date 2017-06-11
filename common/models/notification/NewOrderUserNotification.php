<?php

namespace common\models\notification;

use Yii;

class NewOrderUserNotification extends Notification
{

    public $subject;
    protected $layout = 'new-order-for-user';

    public function __construct($user, $order) {
        $this->subject = Yii::t('app', 'Thank you for your order');

        $this->to = $user->email;

        $this->layoutData = [
            'order' => $order,
            'user'  => $user
        ];
    }
}