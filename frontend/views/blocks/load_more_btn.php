<?php if ($pagination->pageCount > 1 && $pagination->page+1 < $pagination->pageCount) { ?>

<a
    class="show_more_btn"

    href="<?= $next_page_url ?>"
    style="margin-bottom: 20px;">
    <?= Yii::t('app', 'Show more'); ?>
</a>

<?php } ?>