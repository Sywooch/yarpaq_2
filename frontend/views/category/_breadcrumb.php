<?php $parents = $category->getParents(true)->all(); ?>

<div class="breadcrumbs">
    <ul>
        <li>
            <a href="<?= $parents[0]->url; ?>"><?= Yii::t('app', 'Home'); ?></a>
        </li>

        <?php if (count($parents) > 1) { ?>
            <?php foreach (array_slice($parents, 1) as $parent) { ?>
        <li>
            <a href="<?= $parent->url; ?>"><?= $parent->title; ?></a>
        </li>
            <?php } ?>
        <?php } ?>
        <li>
            <span><?= $category->title; ?></span>
        </li>
    </ul>
</div>