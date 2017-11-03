<?php if ($pagination->pageCount > 1) { ?>

<a
    class="show_more_btn"

    href="<?= $pagination->getLinks()[\yii\data\Pagination::LINK_NEXT] ?>"
    style="margin-bottom: 20px;">
    <?= Yii::t('app', 'Show more'); ?>
</a>

<?php } ?>