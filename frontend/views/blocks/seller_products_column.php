<?php
use common\models\Product;
?>
<div>

    <?php
    $products = Product::find()->andWhere(['user_id' => $seller->id]);

    if (isset($limit)) { $products->limit($limit); }

    foreach ($products->all() as $product) {
        echo $this->render('@app/views/blocks/product', [
            'product' => $product
        ]);
    } ?>
</div>