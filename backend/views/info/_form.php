<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;

/* @var $this yii\web\View */
/* @var $model common\models\info\Info */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="info-form">

    <?php $form = ActiveForm::begin([
        'enableClientValidation' => false,
        'enableAjaxValidation' => false,
    ]); ?>

    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <?php $i=1; foreach ($languages as $language) { ?>
                <li class="<?php echo $i==1 ? 'active' : '' ?>"><a href="#tab_<?php echo $i; ?>" data-toggle="tab" aria-expanded="<?php echo $i==1 ? 'true' : 'false' ?>"><?php echo $language->label; ?></a></li>
                <?php $i++; } ?>
        </ul>
        <div class="tab-content">
            <?php
            $i=1;
            foreach ($languages as $language) {
                foreach ($contents as $_c) {
                    if ($_c->lang_id == $language->id) {
                        $content = $_c;
                        break;
                    }
                }
                ?>
                <div class="tab-pane <?php echo $i==1 ? 'active' : ''; ?>" id="tab_<?php echo $language->id; ?>">

                    <?= $form->field($content, 'title')->textInput(['name' => 'InfoContent_'.$language->id.'[title]', 'data-name-link' => 'name_'.$language->id, 'maxlength' => true, 'class' => 'form-control titleField', 'id' => 'content_'.$language->id.'_title']) ?>
                    <?= $form->field($content, 'name')->textInput(['name' => 'InfoContent_'.$language->id.'[name]', 'data-name' => 'name_'.$language->id, 'maxlength' => true, 'class' => 'form-control nameField', 'id' => 'content_'.$language->id.'_name']) ?>
                    <?= $form->field($content, 'body')->widget(CKEditor::className(), [
                        'options' => [
                            'name' => 'InfoContent_'.$language->id.'[body]',
                            'maxlength' => true,
                            'id' => 'content_'.$language->id.'_body'
                        ],
                        'editorOptions' => ElFinder::ckeditorOptions('elfinder', [
                            //'preset' => 'basic',
                            'height' => 280
                        ]),
                    ]) ?>
                    <?= $form->field($content, 'seo_keywords')->textarea(['name' => 'InfoContent_'.$language->id.'[seo_keywords]', 'id' => 'content_'.$language->id.'_seo_keywords']) ?>
                    <?= $form->field($content, 'seo_description')->textarea(['name' => 'InfoContent_'.$language->id.'[seo_description]', 'id' => 'content_'.$language->id.'_seo_description']) ?>
                </div>
                <!-- /.tab-pane -->
                <?php $i++; } ?>
        </div>
        <!-- /.tab-content -->

    </div>

    <div class="box box-solid">

        <div class="box-body">
            <?= $form->field($model, 'status')->dropDownList([
                0 => 'Hidden',
                1 => 'Active'
            ]); ?>

            <?php
            $templates = \common\models\Template::find()->all();
            $templates_data = [];

            foreach ($templates as $template) {
                $templates_data[ $template->id ] = $template->name;
            }
            echo $form->field($model, 'template_id')->dropDownList($templates_data);
            ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>