<div class="leave_feedback_page">
    <div>
        <div class="header_block">
            <h2><?= Yii::t('app', 'Rate and Review'); ?></h2>
        </div>

        <div class="review_block">
            <form action="" id="review_form" method="post">

                <span class="product_name">
                    <b><?= $product->title; ?></b>
                </span>

                <div class="review_stars" data-rank="0">
                    <i></i><i></i><i></i><i></i><i></i>
                </div>

                <input type="hidden" name="LeaveFeedbackForm[stars]" id="stars_input">

                <div class="review_container">
                    <p>
                        <label for="review_input"><?= Yii::t('app', 'Write a review'); ?>:</label>
                    </p>

                    <textarea name="LeaveFeedbackForm[comment]" id="review_input"></textarea>
                </div>

                <div class="review_buttons">
                    <a href="<?= \yii\helpers\Url::to(['user/order', 'id' => $order_id]); ?>" class="review_cancel_button review_button"><?= Yii::t('app', 'Go back'); ?></a>
                    <a href="#" class="review_confirm_button review_button"><?= Yii::t('app', 'Confirm'); ?></a>
                </div>

                <input id="form-token" type="hidden" name="<?=Yii::$app->request->csrfParam?>"
                       value="<?=Yii::$app->request->csrfToken?>"/>

            </form>

        </div>
    </div>
</div>