<?php
if ($pagination->page > 0) {
    \Yii::$app->view->registerMetaTag([
        'name' => 'robots',
        'content' => 'noindex, follow'
    ]);
}
echo \frontend\components\CustomLinkPager::widget([
    'pagination'    => $pagination,
    'options'       => [
        'class' => 'pagination'
    ]
]);