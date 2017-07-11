<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Product */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
        'modelClass' => 'Product',
    ]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Products'), 'url' => ['product/index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['product/update', 'id' => $model->id]];
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
    <?= $this->render('_options_form', [
        'product' => $model,
    ]) ?>

</div>
