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

    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li><a href="<?php echo Url::to(['product/update', 'id' => $product->id]); ?>#tab_basic"><?= Yii::t('app', 'Basic'); ?></a></li>
            <li><a href="<?php echo Url::to(['product/update', 'id' => $product->id]); ?>#tab_advanced"><?= Yii::t('app', 'Advanced'); ?></a></li>
            <li class="active"><a href="#" data-toggle="tab" aria-expanded="false"><?= Yii::t('app', 'Options'); ?></a></li>
            <li><a href="<?php echo Url::to(['discount/index', 'id' => $product->id]); ?>"><?= Yii::t('app', 'Discount')?></a></li>

        </ul>
        <div class="tab-content">

            <div class="row">
                <div class="col-xs-12">
                    <?php
                    $i=0;
                    foreach ($product->productOptions as $product_option) {
                        $i++;
                        $option = $product_option->option;
                        ?>
                    <a
                        data-toggle="tab"
                        href="#collapse<?= $product_option->id; ?>"
                        class="btn btn-default"><?= $option->content->name; ?></a>
                    <?php } ?>

                    <a href="add-option?product_id=<?= $product->id; ?>" class="btn btn-success pull-right"><?= Yii::t('app', 'Add option'); ?></a>
                </div>
            </div>
            <br><br>
            <div class="row">
                <div class="tab-content col-xs-12">
                    <!-- Product options -->
                    <?php
                    $i=0;
                    foreach ($product->productOptions as $product_option) {
                        $i++;
                        /**
                         * @var $product_option \common\models\option\ProductOption
                         */

                        $option = $product_option->option;
                        $option_available_values =  ArrayHelper::map($option->values, 'id', 'name');
                        ?>

                        <div id="collapse<?= $product_option->id; ?>" class="tab-pane <?php if ($i==1) { echo 'active';} ?>">

                            <?php $form = ActiveForm::begin(['action' => ['product-option/update', 'id' => $product->id], 'options' => ['enctype' => 'multipart/form-data']]); ?>

                            <table class="table table-hover values_group">
                                <tr>
                                    <th><?= Yii::t('app', 'Option Value'); ?></th>
                                    <th><?= Yii::t('app', 'Quantity'); ?></th>
                                    <th><?= Yii::t('app', 'Price prefix'); ?></th>
                                    <th><?= Yii::t('app', 'Price'); ?></th>
                                </tr>

                                <?php
                                foreach ($product_option->values as $value) {
                                    /**
                                     * @var $value
                                     */ ?>
                                    <tr class="value_row">
                                        <td>
                                            <?= $value->optionValue->name; ?>
                                        </td>
                                        <td><?= $form->field($value, '['.$value->id.']quantity')->textInput()->label(false); ?></td>
                                        <td>
                                            <?= $form->field($value, '['.$value->id.']price_prefix')->dropDownList(['+' => '+', '-' => '-'])->label(false); ?>
                                        </td>
                                        <td>
                                            <?= $form->field($value, '['.$value->id.']price')->textInput()->label(false); ?>
                                        </td>
                                        <td>
                                            <label class="btn btn-warning deleteOptionValueBtn" for="deleteValue<?=$value->id;?>">
                                                <i class="fa fa-times" aria-hidden="true"></i>
                                            </label>
                                            <input type="checkbox" name="delete_value_id[]" value="<?=$value->id;?>" id="deleteValue<?=$value->id;?>" class="hide">
                                            <?= $form->field($product_option, 'id')->hiddenInput(['name' => 'ProductOptionValue['.$value->id.'][product_option_id]'])->label(false); ?>
                                        </td>
                                    </tr>
                                <?php } ?>

                                <tr class="hide optionValueTpl value_row">
                                    <td>
                                        <select name="option_value_id[]" class="form-control">
                                            <?php foreach ($option_available_values as $id => $val) { ?>
                                                <option value="<?=$id;?>"><?=$val;?></option>
                                            <?php } ?>
                                        </select>

                                        <div class="help-block"></div>
                                    </td>
                                    <td>
                                        <input name="quantity[]" type="text" value="" class="form-control">
                                    </td>
                                    <td>
                                        <select name="price_prefix[]" class="form-control">
                                            <option>+</option>
                                            <option>-</option>
                                        </select>

                                        <div class="help-block"></div>
                                    </td>
                                    <td>
                                        <input name="price[]" type="text" value="0.0000" class="form-control">
                                    </td>
                                    <td>
                                        <div class="btn btn-warning deleteOptionValueBtn immediate">
                                            <i class="fa fa-times" aria-hidden="true"></i>
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            <button type="button" class="btn btn-default col-xs-12 addOptionValueBtn"><?= Yii::t('app', 'Add value'); ?></button>
                            <br><br>
                            <div class="form-group">
                                <input type="hidden" name="product_option_id" value="<?=$product_option->id;?>">

                                <?= Html::submitButton($product->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $product->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                                <?= Html::a(
                                        Yii::t('app', 'Delete'),
                                        ['delete', 'product_id' => $product->id, 'option_id' => $option->id],
                                        ['class' => 'btn btn-danger pull-right']);
                                ?>
                            </div>

                            <?php ActiveForm::end(); ?>
                        </div>

                    <?php } ?>
                </div>
            </div>

        </div>
        <!-- /.tab-content -->
    </div>

</div>