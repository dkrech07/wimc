<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        "https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css",
        "//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css",
    ];
    public $js = [
        'js/points.js',
        'https://code.jquery.com/ui/1.13.1/jquery-ui.js',
        'js/jquery.ui.autocomplete.html.js',
        'js/autocomplete.js',
        'js/yandex-map.js',
        'js/nearestPopup.js',
        'js/cookie.js',
        'js/contacts-form.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
    ];
}
