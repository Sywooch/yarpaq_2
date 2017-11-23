<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\category\Category;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\FileHelper;
use kartik\file\FileInput;
use yii\web\JsExpression;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model common\models\category\Category */
/* @var $parent common\models\category\Category */
/* @var $content common\models\category\CategoryContent */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="page-form">

    <?php $form = ActiveForm::begin([
        'enableClientValidation' => false,
        'enableAjaxValidation' => false,
        'options' => ['enctype' => 'multipart/form-data']
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

                    <?= $form->field($content, 'title')->textInput(['name' => 'CategoryContent_'.$language->id.'[title]', 'data-name-link' => 'name_'.$language->id, 'maxlength' => true, 'class' => 'form-control titleField', 'id' => 'content_'.$language->id.'_title']) ?>

                    <?php if ($parent) { ?>
                    <label>Full url preview</label>
                    <p class="nameField_path" data-slashUrls="1" data-name="name_<?php echo $language->id; ?>">
                        <?php echo $parent->getUrlByLanguage($language); ?><strong></strong>
                    </p>
                    <?php } ?>

                    <?= $form->field($content, 'name')->textInput(['name' => 'CategoryContent_'.$language->id.'[name]', 'data-name' => 'name_'.$language->id, 'maxlength' => true, 'class' => 'form-control nameField', 'id' => 'content_'.$language->id.'_name']) ?>
                    <?= $form->field($content, 'seo_header')->textInput(['name' => 'CategoryContent_'.$language->id.'[seo_header]', 'id' => 'content_'.$language->id.'_seo_header']) ?>
                    <?= $form->field($content, 'seo_keywords')->textarea(['name' => 'CategoryContent_'.$language->id.'[seo_keywords]', 'id' => 'content_'.$language->id.'_seo_keywords']) ?>
                    <?= $form->field($content, 'seo_description')->textarea(['name' => 'CategoryContent_'.$language->id.'[seo_description]', 'id' => 'content_'.$language->id.'_seo_description']) ?>
                </div>
                <!-- /.tab-pane -->
                <?php $i++; } ?>
        </div>
        <!-- /.tab-content -->

    </div>

    <div class="box box-solid">

        <div class="box-body">
            <?= $form->field($model, 'status')->dropDownList([
                0 => Yii::t('app', 'Disabled'),
                1 => Yii::t('app', 'Enabled')
            ]); ?>

            <?php
            $templates = \common\models\Template::find()->all();
            $templates_data = [];

            foreach ($templates as $template) {
                $templates_data[ $template->id ] = $template->name;
            }
            echo $form->field($model, 'template_id')->dropDownList($templates_data);

            echo $form->field($model, 'isTop')->checkbox();

            // Category BEGIN

            $initCategory = empty($model->parent_id) ? '' : Category::find()->andWhere(['id' => $model->parent_id])->one();
            $initValueText = $initCategory ? $initCategory->fullName : '';

            echo $form->field($model, 'parent_id')->widget(Select2::classname(), [
                'initValueText' => $initValueText,
                'pluginOptions' => [
                    'allowClear' => true,
                    'minimumInputLength' => 3,
                    'ajax' => [
                        'url' => Url::to(['category/list?full=true']),
                        'dataType' => 'json',
                        'data' => new JsExpression('function(params) { return {q:params.term}; }')
                    ],
                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                    'templateResult' => new JsExpression('function(city) { return city.text; }'),
                    'templateSelection' => new JsExpression('function (city) { return city.text; }'),
                    'tags' => true,
                    'tokenSeparators' => [','],
                    'maximumInputLength' => 10,
                ],
            ])->label(Yii::t('app', 'Category'));

            // Category END

            ?>
            <div class="row">

                <!-- Gallery -->
                <div class="col-xs-12">

                    <script type="text/javascript">
                        var gallery_sort = [];
                    </script>
                    <?php

                    $pluginOptions = [
                        'allowedFileExtensions' => ['jpg', 'gif', 'png', 'svg'],


                        'initialPreviewAsData' => true,
                        'deleteUrl' => Url::to(['category/image-delete']),
                        'overwriteInitial' => false,
                        'maxFileSize' => 10000,
                        'initialCaption' => Yii::t('app', "Upload images"),
                        'initialPreview' => [],
                        'initialPreviewConfig' => [],

                        'showCaption' => false,
                        'showRemove' => false,
                        'showUpload' => false,
                        'browseClass' => 'btn btn-primary btn-block',
                        'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                        'browseLabel' =>  Yii::t('app', 'Select')
                    ];
                    $gallery_sort = [];

                    foreach ($model->gallery as $image) {

                        if (!is_file($image->path)) continue;

                        $pluginOptions['initialPreview'][] = $image->url;
                        $mimetype = FileHelper::getMimeType( $image->path );
                        $pluginOptions['initialPreviewConfig'][] = [
                            'type' => substr($mimetype, 0, strpos($mimetype, '/')),
                            'filetype' => $mimetype,
                            'caption' => $image->src_name,
                            'width' => "120px",
                            'key' => $image->id
                        ];
                        $gallery_sort[] = $image->id;

                        echo '<script type="text/javascript"> gallery_sort.push('.$image->id.'); </script>';
                    }

                    echo $form->field($model, 'galleryFiles[]')->widget(FileInput::className(), [
                        'model' => $model,
                        'options' => [
                            'accept' => ['image/*', 'video/*'],
                            'multiple' => true
                        ],
                        'pluginOptions' => $pluginOptions,
                    ])->label(Yii::t('app', 'Icon')); ?>

                    <input type="hidden" name="gallery_sort" value="<?php echo implode(',', $gallery_sort); ?>">

                </div>
                <!-- END of gallery -->
            </div>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
