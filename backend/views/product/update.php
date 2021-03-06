<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Product */

$this->title = Yii::t('app', 'Updating Product', [
    'modelClass' => 'Product',
]) . ': ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update Product');

?>
<?php if (Yii::$app->request->getQueryParam('alert') == 'success') { ?>
<div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4><i class="icon fa fa-check"></i> Saved!</h4>
    This product was successfully saved.
</div>
<?php } ?>

<div class="product-update">

    <h2><?= $this->title; ?></h2>

    <?= $this->render('_form', [
        'model' => $model,
        'zones' => $zones
    ]) ?>

</div>
