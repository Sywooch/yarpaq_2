<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/reset.css',
        'css/font/stylesheet.css?v=1.0',
        'css/rangeSlider.css',
        'js/zoom/dist/xzoom.css',
        'js/slick/slick.css',
        'js/slick/slick-theme.css',
        'css/main.css?v1.6.9',
        'css/responsive.css?v=1.4.5',
        'css/common.css'
    ];
    public $js = [
        //'js/jquery-latest.js',

    ];
    public $depends = [
        //'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
    ];
}
