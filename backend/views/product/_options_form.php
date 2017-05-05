<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/**
 * @var $product \common\models\Product
 */

?>

<div class="product-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li><a href="<?php echo Url::to(['product/update', 'id' => $product->id]); ?>#tab_basic">Basic</a></li>
            <li><a href="<?php echo Url::to(['product/update', 'id' => $product->id]); ?>#tab_advanced">Advanced</a></li>
            <li class="active"><a href="#tab_basic" data-toggle="tab" aria-expanded="false">Options</a></li>
        </ul>
        <div class="tab-content">


            <div class="box-group" id="accordion">

                <!-- Product options -->
                <?php
                foreach ($product->options as $product_option) {
                    /**
                     * @var $product_option \common\models\option\ProductOption
                     */

                    $option = $product_option->option;
                    $option_available_values =  ArrayHelper::map($option->values, 'id', 'name');

                    ?>

                    <div class="panel box">
                        <div class="box-header with-border">
                            <h4 class="box-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $option->id; ?>">
                                    <?= $option->content->name; ?>
                                </a>
                            </h4>
                        </div>
                        <div id="collapse<?= $option->id; ?>" class="panel-collapse collapse">
                            <div class="box-body">
                                <table class="table table-hover">
                                    <tr>
                                        <th>Option Value</th>
                                        <th>Quantity</th>
                                        <th>Price prefix</th>
                                        <th>Price</th>
                                    </tr>

                                    <?php
                                    foreach ($product_option->values as $value) {
                                        /**
                                         * @var $value
                                         */ ?>
                                        <tr>
                                            <td>
                                                <div class="form-group">
                                                    <?= $form->field($value, 'option_value_id')->dropDownList($option_available_values)->label(false); ?>
                                                </div>
                                            </td>
                                            <td><?= $form->field($value, 'quantity')->textInput()->label(false); ?></td>
                                            <td>
                                                <?= $form->field($value, 'price_prefix')->dropDownList(['+' => '+', '-' => '-'])->label(false); ?>
                                            </td>
                                            <td>
                                                <?= $form->field($value, 'price')->textInput()->label(false); ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </div>
                        </div>
                    </div>

                <?php } ?>

            </div>

        </div>
        <!-- /.tab-content -->
    </div>


    <div class="form-group">
        <?= Html::submitButton($product->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $product->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
