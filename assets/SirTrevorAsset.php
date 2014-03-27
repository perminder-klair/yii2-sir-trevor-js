<?php

namespace kato\sirtrevorjs\assets;

use Yii;
use yii\web\AssetBundle;

class SirTrevorAsset extends AssetBundle {

    public $sourcePath = '@sirtrevorjs/bower_components';

    public $css = [
        'sir-trevor-js/sir-trevor-icons.css',
        'sir-trevor-js/sir-trevor.css'
    ];

    public $js = [
        "underscore/underscore.js",
        "Eventable/eventable.js",
        "sir-trevor-js/sir-trevor.js",
        "sir-trevor-js/locales/de.js"
    ];

    public $depends = [
        'yii\web\JqueryAsset',
        'yii\web\YiiAsset'
    ];

    public $publishOptions = [
        'forceCopy' => true
    ];
}