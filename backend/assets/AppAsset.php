<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/tree.css'
    ];
    public $js = [
        'js/tree.js',
        'js/page.js',
        'js/gallery.js',
        'js/common.js?v=1.0.1',
        'js/order.js',
        'js/discount.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
