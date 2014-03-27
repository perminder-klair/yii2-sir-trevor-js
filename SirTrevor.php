<?php

namespace kato\sirtrevorjs;

use Yii;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Json;
use kato\sirtrevorjs\assets\SirTrevorAsset;

class SirTrevor extends \yii\widgets\InputWidget
{
    public $debug = 'true';
    public $language = 'en';
    public $blockTypes = ["Heading","Text","List","Quote","Image","Video","Tweet"];
    public $imageUploadUrl = 'site/upload';

    public $init;
    public $options;
    public $el = 'sir-trevor';

    public function init(){
        parent::init();

        Yii::setAlias('@sirtrevorjs', dirname(__FILE__));
        $this->registerAsset();
    }

    public function run()
    {
        return Html::tag('textarea', '', ['name' => $this->attribute,'class' => $this->el]);
    }

    private function registerAsset(){
        $view = $this->getView();
        SirTrevorAsset::register($view)->language = $this->language;

        $this->options = "{";
        $this->options .= "el: $('." . $this->el . "'),";
        $this->options .= "blockTypes: " . Json::encode($this->blockTypes);
        $this->options .= "}";

        $this->init = 'SirTrevor.DEBUG = ' . $this->debug . ';';
        $this->init .= 'SirTrevor.LANGUAGE = "' . $this->language . '";';
        $this->init .= 'SirTrevor.setDefaults({ uploadUrl: "' . Yii::$app->urlManager->createUrl([$this->imageUploadUrl]) . '" });';
        $this->init .= "window.editor = new SirTrevor.Editor(" . $this->options . ");";

        $view->registerJs('$(function(){' . $this->init . '});', View::POS_END, 'sir-trevor-options');
    }
}
