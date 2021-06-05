<?php

namespace app\assets;

use yii\web\AssetBundle;

class FA5Asset extends \yii\web\AssetBundle
{

    public $sourcePath = '@vendor/bower-asset/font-awesome';
    public $css = [
        'css/all.min.css',
    ];

    public $publishOptions = [
        'only' => [
            'css/*',
            'js/*',
            'webfonts/*',
            'sprites/*',
            'svgs/*',
        ],
    ];
}
