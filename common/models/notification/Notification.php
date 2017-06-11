<?php

namespace common\models\notification;

use Yii;

class Notification
{

    public $to;
    public $subject = 'Default subject';
    public $text = '';
    public $html = '';
    protected $layout;
    protected $layoutData;

    public function send() {
        return Yii::$app->mailer->compose($this->layout, $this->layoutData)
            ->setFrom(Yii::$app->params['supportEmail'])
            ->setTo($this->to)
            ->setSubject($this->subject)
            ->setTextBody($this->text)
            ->setHtmlBody($this->html)
            ->send();
    }
}