<?php

use yii\widgets\ActiveForm;
use common\models\option\Option;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = Yii::t('app', 'Add option {modelClass}: ', [
        'modelClass' => 'Product',
    ]) . $product->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Products'), 'url' => ['product/index']];
$this->params['breadcrumbs'][] = ['label' => $product->title, 'url' => ['product/update', 'id' => $product->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Delete');

?>

<div class="add-option">

    <?php $form = ActiveForm::begin(['action' => [
        'product-option/delete',
        'product_id'    => $product->id,
        'option_id'     => $option->id
    ], 'options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= Yii::t('app', 'Delete') . ': '. $option->name; ?><br><br>

    <input type="hidden" name="product_id" value="<?= $product->id; ?>">
    <input type="hidden" name="option_id" value="<?= $option->id; ?>">

    <?= Html::submitButton(Yii::t('app', 'Confirm'), ['class' => 'btn btn-danger']); ?>

    <?php ActiveForm::end(); ?>
</div>
