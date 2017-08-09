<?php

namespace common\models\search;

use Yii;
use common\models\User;

class SearchLogger
{
    public static function log($text) {
        $user = User::getCurrentUser();

        $searchLog = new SearchLog();
        $searchLog->text = $text;


        if ($user) {
            $searchLog->user_id = $user->id;
        }

        $searchLog->save();
    }
}