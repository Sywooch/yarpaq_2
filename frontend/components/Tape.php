<?php

namespace frontend\components;

use yii\base\Widget;

abstract class Tape extends Widget
{

    public $mainLabel;
    public $seeAllLabel;
    protected $products = [];

    public function init() {
        parent::init();

        // заполняет массив товарами
        $this->loadProducts();
    }

    abstract public function loadProducts();

    public function run() {
        return $this->render('_tape', [
            'mainLabel'     => $this->mainLabel,
            'seeAllLabel'   => $this->seeAllLabel,
            'products'      => $this->products
        ]);
    }
}