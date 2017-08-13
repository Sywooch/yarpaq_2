<?php $this->title = $name; ?>
<div class="page_404">
    <div>
        <h2>404</h2>
        <h3><?= Yii::t('app', 'axtardığınız səhifə tapılmadı');?></h3>
        <p>
            <?= Yii::t('app', 'Return to <a href="{home_page_link}">{home_page_title}</a>', [
                'home_page_link' => \common\models\Language::getCurrent()->urlPrefix,
                'home_page_title' => Yii::t('app', 'HOME PAGE')
            ]);?>
        </p>
    </div>
</div>