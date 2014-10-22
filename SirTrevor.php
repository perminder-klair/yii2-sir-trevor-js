<?php

namespace kato\sirtrevorjs;

use Yii;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Json;
use kato\sirtrevorjs\assets\SirTrevorAsset;

class SirTrevor extends \yii\widgets\InputWidget
{
    public $debug = 'false';
    public $language = 'en';
    public $el = 'sir-trevor';
    public $blockTypes = ["Heading", "Text", "List", "Quote", "Image", "Video"];
    public $imageUploadUrl = null;

    public $initJs = null;
    public $blockOptions = null;

    public function init()
    {
        parent::init();

        if (is_null($this->imageUploadUrl)) {
            $this->imageUploadUrl = Yii::$app->urlManager->createUrl(['site/upload']);
        }

        if (is_null($this->blockOptions)) {
            $this->blockOptions = "{";
            $this->blockOptions .= "el: $('." . $this->el . "'),";
            $this->blockOptions .= "blockTypes: " . Json::encode($this->blockTypes);
            $this->blockOptions .= "}";
        }

        if (is_null($this->initJs)) {
            $this->initJs = 'SirTrevor.DEBUG = ' . $this->debug . ';';
            $this->initJs .= 'SirTrevor.LANGUAGE = "' . $this->language . '";';
            $this->initJs .= 'SirTrevor.setDefaults({ uploadUrl: "' . $this->imageUploadUrl . '" });';
            $this->initJs .= "window.editor = new SirTrevor.Editor(" . $this->blockOptions . ");";
        }

        $this->options['class'] = $this->el;

        Yii::setAlias('@sirtrevorjs', dirname(__FILE__));
        $this->registerAsset();

        echo $this->renderInput();
    }

    /**
     * Render the text area input
     */
    protected function renderInput()
    {
        if ($this->hasModel()) {
            $input = Html::activeTextArea($this->model, $this->attribute, $this->options);
        } else {
            $input = Html::textArea($this->name, $this->value, $this->options);
        }

        return $input;
    }

    protected function registerAsset()
    {
        $view = $this->getView();
        SirTrevorAsset::register($view)->language = $this->language;

        $view->registerJs('$(function(){' . $this->initJs . '});');
    }
}
