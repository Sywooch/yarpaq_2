<?php
/**
 * @var $parents Array
 * @var $currentPageTitle String
 */
?>
<div class="breadcrumbs">
    <ul itemscope itemtype="http://schema.org/BreadcrumbList">
        <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
            <a
                itemscope itemtype="http://schema.org/Thing" itemprop="item"
                href="<?= \common\models\Language::getCurrent()->urlPrefix; ?>/">

                <span itemprop="name"><?= Yii::t('app', 'Home'); ?></span>
            </a>
            <meta itemprop="position" content="1">
        </li>

        <?php if (isset($parents) && count($parents) > 1) { ?>
            <?php $i=1; foreach (array_slice($parents, 1) as $parent) { $i++; ?>
        <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
            <a
                itemscope itemtype="http://schema.org/Thing" itemprop="item"
                href="<?= $parent->url; ?>">
                <span itemprop="name"><?= $parent->title; ?></span>
            </a>
            <meta itemprop="position" content="<?= $i; ?>">
        </li>
            <?php } ?>
        <?php } ?>

        <li>
            <span><?= $currentPageTitle; ?></span>
        </li>
    </ul>
</div>