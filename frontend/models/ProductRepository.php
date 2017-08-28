<?php

namespace frontend\models;


use common\models\Product;

class ProductRepository
{

    private $query;

    public function __construct() {
        $this->query = Product::find();
    }

    public function visibleOnTheSite() {
        $this->query->andWhere([
            'status_id' => Product::STATUS_ACTIVE,
            'moderated' => 1
        ]);

        return $this->query;
    }

    public function ___toString() {
        return $this->query;
    }
}