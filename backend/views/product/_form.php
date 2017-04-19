<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\web\JsExpression;
use kartik\select2\Select2;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use kartik\file\FileInput;
use yii\helpers\FileHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Product */
/* @var $form yii\widgets\ActiveForm */

//$this->registerJs("CKEDITOR.plugins.addExternal('pbckcode', '/ckeditor_plugins/pbckcode/plugin.js', '');");
//$this->registerJs("CKEDITOR.plugins.addExternal('popup', '/ckeditor_plugins/popup/plugin.js', '');");
//$this->registerJs("CKEDITOR.plugins.addExternal('filebrowser', '/ckeditor_plugins/filebrowser/plugin.js', '');");
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_basic" data-toggle="tab" aria-expanded="true">Basic</a></li>
            <li><a href="#tab_advanced" data-toggle="tab" aria-expanded="false">Advanced</a></li>
            <li><a href="#tab_options" data-toggle="tab" aria-expanded="false">Options</a></li>
        </ul>
        <div class="tab-content">

            <div class="tab-pane active" id="tab_basic">

                <!-- Product description -->

                <div class="row">
                    <div class="col-md-8">
                        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'description')->widget(CKEditor::className(), [
                            'editorOptions' => ElFinder::ckeditorOptions('elfinder', [
                                'preset' => 'basic',
                                'height' => 280
                            ]),
                        ]) ?>
                    </div>

                    <div class="col-md-4">


                        <?= $form->field($model, 'model')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'condition_id')->dropDownList([
                            1 => 'New',
                            2 => 'Used'
                        ]) ?>


                        <div class="row">

                            <!-- Price -->
                            <div class="col-xs-6">
                                <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>
                            </div>

                            <div class="col-xs-6">
                                <?= $form->field($model, 'currency_id')->dropDownList(\backend\models\Currency::getDropDownData()) ?>
                            </div>
                        </div>

                        <!-- Quantity -->
                        <div class="row">
                            <div class="col-xs-6">
                                <?= $form->field($model, 'quantity')->textInput() ?>
                            </div>
                            <div class="col-xs-6">
                                <?= $form->field($model, 'stock_status_id')->dropDownList(\common\models\StockStatus::getDropDownData()) ?>
                            </div>
                        </div>


                        <!-- Location info -->
                        <?= $form->field($model, 'location')->textInput(['maxlength' => true]) ?>

                        <!-- Manufacturer -->
                        <?php
                        $man_list_url = \yii\helpers\Url::to(['manufacturer/model-list']);
                        // Get the initial manufacturer
                        $manufacturer = empty($model->manufacturer_id) ? '' : \backend\models\Manufacturer::findOne($model->manufacturer_id)->title;

                        echo $form->field($model, 'manufacturer_id')->widget(Select2::classname(), [
                            'initValueText' => $manufacturer,
                            'options' => ['placeholder' => 'Select manufacturer ...'],
                            'pluginOptions' => [
                                'allowClear' => true,

                                'minimumInputLength' => 2,

                                'language' => [
                                    'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                                ],
                                'ajax' => [
                                    'url' => $man_list_url,
                                    'dataType' => 'json',
                                    'data' => new JsExpression('function(params) { return {q:params.term}; }')
                                ],

                                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                'templateResult' => new JsExpression('function(city) { return city.text; }'),
                                'templateSelection' => new JsExpression('function (city) { return city.text; }'),
                            ],

                        ]);
                        ?>

                    </div>
                </div>


                <div class="row" style="margin-bottom: 20px;">

                    <!-- Gallery -->
                    <div class="col-xs-12">
                        <label class="control-label" for="product-weight">Images & Video</label>

                        <script type="text/javascript">
                            var gallery_sort = [];
                        </script>
                        <?php

                        $pluginOptions = [
                            'allowedFileExtensions' => ['jpg', 'gif', 'png', 'mp4'],
                            'showUpload' => false,

                            'error' => 'This field is required',
                            'initialPreviewAsData' => true,
                            'deleteUrl' => Url::to(['product/image-delete']),
                            'overwriteInitial' => false,
                            'maxFileSize' => 10000,
                            'initialCaption' => "Upload images",
                            'initialPreview' => [],
                            'initialPreviewConfig' => []
                        ];
                        $gallery_sort = [];

                        foreach ($model->gallery as $image) {
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

                        echo FileInput::widget([
                            'name' => 'gallery[]',
                            'options' => [
                                'accept' => ['image/*', 'video/*'],
                                'multiple' => true
                            ],
                            'pluginOptions' => $pluginOptions,
                        ]); ?>

                        <input type="hidden" name="gallery_sort" value="<?php echo implode(',', $gallery_sort); ?>">

                    </div>
                    <!-- END of gallery -->
                </div>

                <div class="row">

                    <div class="col-xs-3">
                        <?= $form->field($model, 'weight')->textInput(['maxlength' => true]) ?>
                    </div>

                    <div class="col-xs-3">
                        <?= $form->field($model, 'length')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-xs-3">
                        <?= $form->field($model, 'width')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-xs-3">
                        <?= $form->field($model, 'height')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>

            </div>

            <div class="tab-pane" id="tab_advanced">

                <div class="row">
                    <div class="col-xs-6">
                        <?= $form->field($model, 'sku')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-xs-6">
                        <?= $form->field($model, 'upc')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-6">
                        <?= $form->field($model, 'ean')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-xs-6">
                        <?= $form->field($model, 'jan')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-6">
                        <?= $form->field($model, 'isbn')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-xs-6">
                        <?= $form->field($model, 'mpn')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>

                <?= $form->field($model, 'status_id')->dropDownList([
                    0 => 'Hidden',
                    1 => 'Active'
                ]); ?>

                <?php
                $users_list_url = \yii\helpers\Url::to(['user/user-list']);

                echo $form->field($model, 'user_id')->widget(Select2::classname(), [
                    'data' => [],
                    'options' => ['placeholder' => 'Select an user ...'],
                    'pluginOptions' => [
                        'allowClear' => true,

                        'minimumInputLength' => 2,

                        'language' => [
                            'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                        ],
                        'ajax' => [
                            'url' => $users_list_url,
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],

                        'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                        'templateResult' => new JsExpression('function(city) { return city.text; }'),
                        'templateSelection' => new JsExpression('function (city) { return city.text; }'),
                    ],

                ]);
                ?>

            </div>

            <div class="tab-pane" id="tab_options">

            </div>
        </div>
        <!-- /.tab-content -->
    </div>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
