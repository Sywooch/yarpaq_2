<?php

namespace common\models\search;

use Yii;
use common\models\User;

class SearchLogger
{
    public static function log($text, $total) {
        $user = User::getCurrentUser();

        $searchLog = new SearchLog();
        $searchLog->text = $text;
        $searchLog->no_result = $total > 0 ? 0 : 1;


        if ($user) {
            $searchLog->user_id = $user->id;
        }

        $searchLog->save();
    }
}