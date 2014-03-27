<?php

namespace kato\sirtrevorjs;

use Yii;
use kato\sirtrevorjs\assets\SirTrevorAsset;

class SirTrevor extends \yii\base\widget
{
    public $debug = false;
    public $language = 'en';
    public $element;
    public $model;

    public $assetMode = 'complete';

    public function init(){
        parent::init();

        Yii::setAlias('@sirtrevorjs', dirname(__FILE__));

        $this->registerAsset();
    }

    private function registerAsset(){
        $view = $this->getView();
        SirTrevorAsset::register($view);
    }

    public function run()
    {
        return "Hello!";
    }
}
