<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\product\Discount;
use kartik\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $product common\models\Product */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
        'modelClass' => 'Product',
    ]) . $product->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Products'), 'url' => ['product/index']];
$this->params['breadcrumbs'][] = ['label' => $product->title, 'url' => ['product/update', 'id' => $product->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Options');

?>
<?php if (Yii::$app->request->getQueryParam('alert') == 'success') { ?>
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-check"></i> Saved!</h4>
        This product was successfully saved.
    </div>
<?php } ?>

<div class="product-update">

    <div class="product-form">

        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li><a href="<?php echo Url::to(['product/update', 'id' => $product->id]); ?>#tab_basic"><?= Yii::t('app', 'Basic'); ?></a></li>
                <li><a href="<?php echo Url::to(['product/update', 'id' => $product->id]); ?>#tab_advanced"><?= Yii::t('app', 'Advanced'); ?></a></li>
                <li><a href="<?php echo Url::to(['product-option/index', 'id' => $product->id]); ?>"><?= Yii::t('app', 'Options')?></a></li>
                <li class="active"><a href="#" data-toggle="tab" aria-expanded="false"><?= Yii::t('app', 'Discount'); ?></a></li>
            </ul>
            <div class="tab-content">
                <?php $form = ActiveForm::begin(); ?>

                <?= $form->field($discount, 'value')->textInput(['maxlength' => true]) ?>

                <?= $form->field($discount, 'period')->dropDownList([
                    0 => Yii::t('app', 'Constant'),
                    1 => Yii::t('app', 'Range')
                ]); ?>

                <?= $form->field($discount, 'start_date')->widget(DateTimePicker::className(), [
                    'class' => 'date-field',
                    'pluginOptions' => [
                        'format' => 'yyyy-mm-dd HH:ii:00'
                    ]
                ]); ?>

                <?= $form->field($discount, 'end_date')->widget(DateTimePicker::className(), [
                    'pluginOptions' => [
                        'format' => 'yyyy-mm-dd HH:ii:00'
                    ]
                ]); ?>

                <?= Html::submitButton($product->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $product->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

                <?php ActiveForm::end(); ?>

                <?php $form = ActiveForm::begin([
                    'action' => Url::to(['discount/delete', 'product_id' => $product->id])
                ]); ?>

                <br><br>
                <?= Html::submitButton( Yii::t('app', 'Delete'), ['class' => 'btn btn-danger']) ?>

                <?php ActiveForm::end(); ?>
            </div>
            <!-- /.tab-content -->
        </div>

    </div>


</div>
