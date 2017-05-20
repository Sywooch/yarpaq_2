<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use common\models\User;
use yii\helpers\Url;
use yii\web\JsExpression;

$order = $model;

/* @var $this yii\web\View */
/* @var $order common\models\order\Order */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-4">
            <p class="lead"><?= Yii::t('app', 'Customer info'); ?></p>

            <?php

            $url = Url::to(['user/user-list']);

            // Get the initial user fullname and email
            $user_fullname = '';
            if (!empty($order->user_id)) {
                $user = User::findOne($order->user_id);
                $user_fullname = $user->fullname . ' ('.$user->email.')';
            }

            echo $form->field($order, 'user_id')->widget(Select2::classname(), [
                'initValueText' => $user_fullname, // set the initial display text
                'options' => [
                    'placeholder' => 'Search for a user ...',
                    'data-info-url' => Url::to(['user/info'])
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                    'minimumInputLength' => 3,
                    'language' => [
                        'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                    ],
                    'ajax' => [
                        'url' => $url,
                        'dataType' => 'json',
                        'data' => new JsExpression('function(params) { return {q:params.term}; }')
                    ],
                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                    'templateResult' => new JsExpression('function(user) { return user.text; }'),
                    'templateSelection' => new JsExpression('function (user) { return user.text; }'),
                ],

                'pluginEvents' => [
                    "change" => "function(e) { onChangeOrderUser(e); }",
                ]
            ]);

            ?>

            <?= $form->field($order, 'firstname')->textInput(['maxlength' => true]) ?>

            <?= $form->field($order, 'lastname')->textInput(['maxlength' => true]) ?>

            <?= $form->field($order, 'email')->textInput(['maxlength' => true]) ?>

            <?= $form->field($order, 'phone1')->textInput(['maxlength' => true]) ?>

            <?= $form->field($order, 'phone2')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-md-8">
            <p class="lead"><?= Yii::t('app', 'Products'); ?></p>

        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <p class="lead"><?= Yii::t('app', 'Payment info'); ?></p>

            <?= $form->field($order, 'payment_firstname')->textInput(['maxlength' => true]) ?>

            <?= $form->field($order, 'payment_lastname')->textInput(['maxlength' => true]) ?>

            <?= $form->field($order, 'payment_company')->textInput(['maxlength' => true]) ?>

            <?= $form->field($order, 'payment_address')->textInput(['maxlength' => true]) ?>

            <?= $form->field($order, 'payment_city')->textInput(['maxlength' => true]) ?>

            <?= $form->field($order, 'payment_postcode')->textInput(['maxlength' => true]) ?>

            <?= $form->field($order, 'payment_country')->textInput(['maxlength' => true]) ?>

            <?= $form->field($order, 'payment_country_id')->textInput() ?>

            <?= $form->field($order, 'payment_zone')->textInput(['maxlength' => true]) ?>

            <?= $form->field($order, 'payment_zone_id')->textInput() ?>

            <?= $form->field($order, 'payment_address_format')->textarea(['rows' => 6]) ?>

            <?= $form->field($order, 'payment_method')->textInput(['maxlength' => true]) ?>

            <?= $form->field($order, 'payment_code')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <p class="lead"><?= Yii::t('app', 'Shipping info'); ?></p>

            <?= $form->field($order, 'shipping_firstname')->textInput(['maxlength' => true]) ?>

            <?= $form->field($order, 'shipping_lastname')->textInput(['maxlength' => true]) ?>

            <?= $form->field($order, 'shipping_company')->textInput(['maxlength' => true]) ?>

            <?= $form->field($order, 'shipping_address')->textInput(['maxlength' => true]) ?>

            <?= $form->field($order, 'shipping_city')->textInput(['maxlength' => true]) ?>

            <?= $form->field($order, 'shipping_postcode')->textInput(['maxlength' => true]) ?>

            <?= $form->field($order, 'shipping_country')->textInput(['maxlength' => true]) ?>

            <?= $form->field($order, 'shipping_country_id')->textInput() ?>

            <?= $form->field($order, 'shipping_zone')->textInput(['maxlength' => true]) ?>

            <?= $form->field($order, 'shipping_zone_id')->textInput() ?>

            <?= $form->field($order, 'shipping_address_format')->textarea(['rows' => 6]) ?>

            <?= $form->field($order, 'shipping_method')->textInput(['maxlength' => true]) ?>

            <?= $form->field($order, 'shipping_code')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-md-4">
            <p class="lead"><?= Yii::t('app', 'Totals'); ?></p>

            <?= $form->field($order, 'comment')->textarea(['rows' => 6]) ?>

            <?= $form->field($order, 'total')->textInput(['maxlength' => true]) ?>

            <?= $form->field($order, 'order_status_id')->textInput(); ?>

            <?= $form->field($order, 'language_id')->textInput() ?>

            <?= $form->field($order, 'currency_id')->textInput() ?>

            <?= $form->field($order, 'currency_code')->textInput(['maxlength' => true]) ?>

            <?= $form->field($order, 'currency_value')->textInput(['maxlength' => true]) ?>

        </div>
    </div>



    <div class="form-group">
        <?= Html::submitButton($order->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $order->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
