<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\backend\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AdminAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web/admin-theme';

    public $css = [
        '/admin-theme/vendor/bootstrap/css/bootstrap.min.css',
        '/admin-theme/vendor/themify-icons/themify-icons.css',
        '/admin-theme/css/admin.css',
    ];
    public $js = [
        '/admin-theme/vendor/bootstrap/js/bootstrap.min.js',
        '/admin-theme/vendor/detectmobilebrowser/detectmobilebrowser.js',
        '/admin-theme/js/admin.js?v=01092020',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
