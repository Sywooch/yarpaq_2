<?php

$currency = Yii::$app->currency;

?>
<div class="product_block">
    <header>

        <!-- Breadcrumbs -->
        <?= $this->render('@app/views/blocks/breadcrumb', [
            'currentPageTitle' => $info->title
        ]); ?>
        <!-- Breadcrumbs END -->

    </header>

    <div class="info-block">
        <h1><?= $info->title; ?></h1>
        <?= $info->content->body; ?>
    </div>
</div>