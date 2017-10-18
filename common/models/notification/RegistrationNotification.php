<?php

namespace common\models\notification;

use Yii;
use yii\helpers\Url;

class RegistrationNotification extends Notification
{
    protected $layout = 'new-user';

    public function __construct($user) {
        $this->subject = Yii::t('app', 'Thank you for your registration');

        $this->to = $user->email;

        $this->layoutData = [
            'user'  => $user,
            'link'  => Url::to(['/user-management/auth/confirm-email-receive', 'token' => $user->confirmation_token], true)
        ];
    }
}