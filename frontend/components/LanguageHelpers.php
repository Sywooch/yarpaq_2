<?php

namespace frontend\components;


class LanguageHelpers
{
    public static function plural($count) {
        if ($count == 1) {
            return 1;
        }

        if ($count % 10 < 5) {
            return 2;
        }

        return 3;
    }
}