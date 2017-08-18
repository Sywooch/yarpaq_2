<div class="page_success">
    <div>
        <img src="/img/success_icon.svg" alt="">
        <h2><?= Yii::t('app', 'Congratulations'); ?>!</h2>
        <p><?= Yii::t('app', 'Your order was successfully paid'); ?></p>
        <div class="links">
            <a href="<?= \common\models\Language::getCurrent()->urlPrefix; ?>/" class="continue"><?= Yii::t('app', 'Continue shopping'); ?></a>
        </div>
    </div>
</div>