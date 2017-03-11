<?php

namespace common\components;

class UserConfig extends \webvimark\modules\UserManagement\components\UserConfig
{
    /**
     * @inheritdoc
     */
    public $identityClass = 'common\models\User';
}