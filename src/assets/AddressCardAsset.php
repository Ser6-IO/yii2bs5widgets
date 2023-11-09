<?php

namespace ser6io\yii2bs5widgets\assets;

use yii\web\AssetBundle;

/**
 * Widget asset bundle.
 *
 */
class AddressCardAsset extends AssetBundle
{
    public $sourcePath = '@vendor/ser6-io/yii2-bs5-widgets/src/assets/src';
   
    public $js = [
        'js/renderers.js',
    ];
    public $depends = [
        'yii\bootstrap5\BootstrapPluginAsset',
        'yii\web\JqueryAsset'
    ];
}
