<?php

namespace kato\sirtrevorjs\assets;

use Yii;
use yii\web\AssetBundle;

class SirTrevorAsset extends AssetBundle {

    public $language;
    public $debug = false;
    public $sourcePath = '@sirtrevorjs/bower_components';

    public $publishOptions = [
        'forceCopy' => true
    ];

    public function registerAssetFiles($view)
    {
        $language = $this->language ? $this->language : Yii::$app->language;

        if ($language !== 'en') {
            $this->js[] = 'sir-trevor-js/locales/' . $language . '.js';
        }

        if ($this->debug !== 'true') {
            $this->js[] = 'sir-trevor-js/sir-trevor.js';
        } else {
            $this->js[] = 'sir-trevor-js/sir-trevor.debug.js';
        }

        parent::registerAssetFiles($view);
    }

    public $css = [
        'sir-trevor-js/sir-trevor-icons.css',
        'sir-trevor-js/sir-trevor.css',
    ];

    public $js = [
        "es5-shim/es5-shim.js",
        "es6-shim/es6-shim.js",
    ];

    public $depends = [
        'yii\web\JqueryAsset',
        'yii\web\YiiAsset',
    ];
}