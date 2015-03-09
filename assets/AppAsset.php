<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
//        'css/site.css',
        'mm-css/css.css',
        'mm-css/style.css',
        'http://fonts.googleapis.com/css?family=Lato:100,300,400,700,900',
    ];
    public $js = [
        'mm-js/jquery.easydropdown.js',
        'mm-js/easing.js',
        'mm-js/easyResponsiveTabs.js',
        'mm-js/responsiveslides.min.js',
        'mm-js/required.part.js',
        'mm-js/order.form.js'
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}