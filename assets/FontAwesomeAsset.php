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
class FontAwesomeAsset extends AssetBundle
{
    public $sourcePath = '@bower/font-awesome';
    public $js = [
        'https://unpkg.com/dropzone@5/dist/min/dropzone.min.js',
    ];
    public $css = [
        'css/font-awesome.min.css',
        'https://unpkg.com/dropzone@5/dist/min/dropzone.min.css',
    ];
}
