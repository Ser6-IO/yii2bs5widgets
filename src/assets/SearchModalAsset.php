<?php

namespace ser6io\yii2bs5widgets\assets;

use yii\web\AssetBundle;

/**
 * Widget asset bundle.
 *
 */
class SearchModalAsset extends AssetBundle
{
    public $sourcePath = '@vendor/ser6-io/yii2-bs5-widgets/src/assets/src';
   
    public $js = [
        'js/searchmodal.js',
    ];
    public $depends = [
        'ser6io\yii2bs5widgets\assets\AddressCardAsset',
    ];
}
