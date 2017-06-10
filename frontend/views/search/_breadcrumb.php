<?php
$parents = $category->getParents(true)->all();
?>
<div class="selected-product">

    <?php if (count($parents)) { ?>

        <a href="<?= $parents[0]->url; ?>" class="title-filter">
            <i class="fa fa-angle-left" aria-hidden="true"></i>
            <?= $parents[0]->title; ?>
        </a>

        <?php foreach (array_slice($parents, 1) as $parent) { ?>

        <a href="<?= $parent->url; ?>" class="name-product"
           style="margin-left: <?= ($parent->depth - 2) * 12 ?>px; margin-top: 4px;">
            <span><?= $parent->title; ?></span>
        </a>

        <?php } ?>

    <?php } ?>

    <div style="margin-left: <?= $category->depth * 12 ?>px; margin-top: 4px;">
        <?= $category->title; ?>
        <div class="green hide"><?= $productsCount; ?> <?= Yii::t('app', 'məhsul'); ?></div>
    </div>

    <?php foreach ($category->getChildren()->all() as $childCategory) { ?>
        <a href="<?= $childCategory->url; ?>" class="name-product"
           style="margin-left: <?= ($childCategory->depth - 2) * 12 ?>px; margin-top: 4px;">
            <span><?= $childCategory->title; ?></span>
        </a>
    <?php } ?>



</div>