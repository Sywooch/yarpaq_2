<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\category\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Categories');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-index">

    <div class="tree">

        <!-- Templates -->
        <div class="list-group hide tpl"></div>
        <span class="list-group-item hide tpl">
            <a class="bind-a" href="" data-toggle="collapse" data-children-url="">
                <i class="glyphicon glyphicon-chevron-right"></i><span class="bind-header"></span>
            </a>

            <span class="actions">
                <a class="label bg-light-blue bind-edit" href="">Edit</a>
                <a class="label bg-light-blue bind-add" href="">Add</a>
                <a class="label bg-light-blue bind-view" href="">View</a>
                <a class="label bg-light-blue bind-move-up" href="">▲</a>
                <a class="label bg-light-blue bind-move-down" href="">▼</a>
                <a class="label bg-red bind-delete" href="" data-confirm="Are you sure you want to delete this item?">Delete</a>
            </span>
        </span>
        <!-- Templates -->




        <div class="list-group list-group-root well">

            <?php
            $categories = $root->getChildren()->with('content')->all();
            foreach ($categories as $category) { ?>

            <span class="list-group-item">
                <a class="bind-a" href="#item-<?php echo $category->id; ?>" data-toggle="collapse" data-children-url="<?php echo Url::toRoute(['category/get-children-data', 'id' => $category->id]); ?>">
                    <i class="glyphicon glyphicon-chevron-right"></i><span class="bind-header"><?php echo $category->content->title; ?></span>
                </a>

                <span class="actions">
                    <a class="label bg-light-blue bind-edit"        href="<?php echo Url::toRoute(['update', 'id' => $category->id]); ?>">Edit</a>
                    <a class="label bg-light-blue bind-add"         href="<?php echo Url::toRoute(['create', 'parent_id' => $category->id]); ?>">Add</a>
                    <a class="label bg-light-blue bind-view"        href="<?php echo $category->url; ?>" target="_blank">View</a>
                    <a class="label bg-light-blue bind-move-up"     href="<?php echo Url::toRoute(['move-up', 'id' => $category->id]); ?>">▲</a>
                    <a class="label bg-light-blue bind-move-down"   href="<?php echo Url::toRoute(['move-down', 'id' => $category->id]); ?>">▼</a>

                    <a class="label bg-red bind-delete" href="<?= Url::toRoute(['category/delete', 'id' => $category->id]) ?>" data-confirm="Are you sure you want to delete this item?">Delete</a>
                </span>
            </span>

            <?php } ?>
        </div>

    </div>

</div>