<?php

namespace ser6io\yii2bs5widgets\searchmodalwidget\assets;

use yii\web\AssetBundle;

/**
 * Widget asset bundle.
 *
 */
class SearchModalWidgetAsset extends AssetBundle
{
    public $sourcePath = '@vendor/ser6-io/yii2-bs5-widgets/src/searchmodalwidget/assets/src';
   
    public $js = [
        'js/renderers.js',
        'js/searchmodal.js',
    ];
    public $depends = [
        'yii\bootstrap5\BootstrapPluginAsset',
    ];
}
