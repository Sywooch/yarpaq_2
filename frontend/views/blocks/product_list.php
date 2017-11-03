
    <?php if (isset($products) && count($products)) {
        foreach ($products as $product) {
            echo $this->render('@app/views/blocks/product', [
                'product' => $product
            ]);
        }
    } else { ?>
    <div class="no-result">
        <p>
            <?= Yii::t('app', 'No results'); ?>
        </p>
    </div>
    <?php } ?>

