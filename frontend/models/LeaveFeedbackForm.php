<?php

namespace frontend\models;


use yii\base\Model;

class LeaveFeedbackForm extends Model
{
    public $stars;
    public $comment;

    public function rules() {
        return [
            [['stars'], 'required'],
            [['stars'], 'integer'],
            ['comment', 'string']
        ];
    }
}