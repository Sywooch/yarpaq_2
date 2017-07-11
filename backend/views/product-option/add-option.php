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
$this->params['breadcrumbs'][] = Yii::t('app', 'Add Option');

?>

<div class="add-option">

    <?php $form = ActiveForm::begin(['action' => ['product-option/add-option', 'product_id' => $product->id], 'options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($productOption, 'option_id')->dropDownList(ArrayHelper::map(Option::find()->all(), 'id', 'name'))->label(false); ?>

    <?= Html::submitButton(Yii::t('app', 'Create'), ['class' => 'btn btn-success']); ?>

    <?php ActiveForm::end(); ?>
</div>
