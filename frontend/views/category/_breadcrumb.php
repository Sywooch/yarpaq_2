<?php $parents = $category->getParents(true)->all(); ?>

<div class="breadcrumbs">
    <p>
        <?php if (count($parents)) { ?>

            <a href="<?= $parents[0]->url; ?>">
                <?= Yii::t('app', 'Home'); ?>
            </a>

            <?php foreach (array_slice($parents, 1) as $parent) { ?>
                / <a href="<?= $parent->url; ?>"><?= $parent->title; ?></a>
            <?php } ?>

            / <span><?= $category->title; ?></span>

        <?php } ?>
    </p>
</div>