<?php

namespace dbfernandes\cropper;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * @author dbfernandes@gmail.com (forked from Ercan Bilgin <bilginnet@gmail.com>)
 */
class CropperAsset extends AssetBundle
{
    public $sourcePath = '@dbfernandes/cropper/assets';
    public $jsOptions = ['position' => View::POS_END];
    public $css = [
        'cropper.css',
    ];
    public $js = [
        'cropper.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
