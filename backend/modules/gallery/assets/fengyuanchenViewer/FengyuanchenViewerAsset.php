<?php

/**
 * Created by PhpStorm.
 * User: bvanleeuwen
 * Date: 21/06/2017
 * Time: 14:28
 */

namespace backend\modules\gallery\assets\fengyuanchenViewer;

use \yii\web\AssetBundle as BaseAssetBundle;

class FengyuanchenViewerAsset extends BaseAssetBundle {

    public $sourcePath = '@backend/modules/gallery/assets/fengyuanchenViewer/';
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
    public $js = [
        'dist/viewer.js',
        'src/runViewer.js'
    ];
    public $css = [
        'dist/viewer.css'
    ];
    public $publishOptions = [
        'forceCopy' => true,
    ];

}
