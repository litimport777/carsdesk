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
        //'css/site.css',
		'css/grid.css',
		'css/search.css',
		'css/camera.css',
		'booking/css/booking.css',
		'css/style.css',
    ];
    public $js = [
		'js/jquery-migrate-1.2.1.js',
		'js/camera.js',
		'js/jquery.equalheights.js',
		'search-css/search.js',
		'booking/js/booking.js',
		'booking/js/jquery.placeholder.js',
		'js/jquery.mobile.customized.min.js',
		'js/wow/wow.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
    ];
}
