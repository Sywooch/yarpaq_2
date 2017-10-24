<?php

namespace common\models\notification;

use Yii;

class Notification
{

    public $to;
    public $subject = 'Default subject';
    protected $layout;
    protected $layoutData;

    public function send() {
        return Yii::$app->mailer->compose($this->layout, $this->layoutData)
            ->setFrom([Yii::$app->params['supportEmail'] => 'Yarpaq.az'])
            ->setTo($this->to)
            ->setSubject($this->subject)
            ->send();
    }
}