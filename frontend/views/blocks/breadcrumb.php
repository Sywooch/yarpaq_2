<?php
/**
 * @var $parents Array
 * @var $currentPageTitle String
 */
?>
<div class="breadcrumbs">
    <ul>
        <li>
            <a href="<?= \common\models\Language::getCurrent()->urlPrefix; ?>"><?= Yii::t('app', 'Home'); ?></a>
        </li>

        <?php if (isset($parents) && count($parents) > 1) { ?>
            <?php foreach (array_slice($parents, 1) as $parent) { ?>
        <li>
            <a href="<?= $parent->url; ?>"><?= $parent->title; ?></a>
        </li>
            <?php } ?>
        <?php } ?>

        <li>
            <span><?= $currentPageTitle; ?></span>
        </li>
    </ul>
</div>