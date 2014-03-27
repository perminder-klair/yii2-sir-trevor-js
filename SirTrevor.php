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
    public $blockTypes = ["Heading","Text","List","Quote","Image","Video"];
    public $imageUploadUrl = 'site/upload';

    public $init = null;
    public $blockOptions = null;
    public $el = 'sir-trevor';

    public function init(){
        parent::init();

        if (is_null($this->blockOptions)) {
            $this->blockOptions = "{";
            $this->blockOptions .= "el: $('." . $this->el . "'),";
            $this->blockOptions .= "blockTypes: " . Json::encode($this->blockTypes);
            $this->blockOptions .= "}";
        }

        if (is_null($this->init)) {
            $this->init = 'SirTrevor.DEBUG = ' . $this->debug . ';';
            $this->init .= 'SirTrevor.LANGUAGE = "' . $this->language . '";';
            $this->init .= 'SirTrevor.setDefaults({ uploadUrl: "' . Yii::$app->urlManager->createUrl([$this->imageUploadUrl]) . '" });';
            $this->init .= "window.editor = new SirTrevor.Editor(" . $this->blockOptions . ");";
        }

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

        $view->registerJs('$(function(){' . $this->init . '});');
    }
}
