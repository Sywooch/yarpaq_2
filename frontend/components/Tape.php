<?php

namespace frontend\components;


use yii\base\Widget;

class Tape extends Widget
{
    protected function getItems() {

    }

    public function run() {
        return $this->render('_tape', ['items' => $this->getItems()]);
    }
}