<?php

namespace kato\sirtrevorjs;

use Yii;
use yii\helpers\Html;
use yii\helpers\Json;
use kato\sirtrevorjs\assets\SirTrevorAsset;
use yii\web\JsExpression;

class SirTrevor extends \yii\widgets\InputWidget
{
    /**
     * debug mode off
     * @var bool
     */
    public $debug = 'false';

    /**
     * default language english
     * @var string
     */
    public $language = 'en';

    /**
     * element class
     * @var string
     */
    public $el = 'sir-trevor';

    /**
     * @var array
     */
    public $blockTypes = ["Heading", "Text", "List", "Quote", "Image", "Video"];

    /**
     * @var null
     */
    public $imageUploadUrl = null;

    /**
     * @var null
     */
    public $initJs = null;

    /**
     * must be an array of options
     * @var null
     */
    public $blockOptions = null;

    /**
     * textarea options
     * example: 'onBlockRender: function () { console.log("Text block rendered"); }'
     * @var null
     */
    public $textAreaOptions = null;

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();

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

    /**
     * @return string
     */
    public function getImageUploadUrl()
    {
        if (is_null($this->imageUploadUrl)) {
            $this->imageUploadUrl = Yii::$app->urlManager->createUrl(['site/upload']);
        }
        return $this->imageUploadUrl;
    }

    /**
     * Extends text area
     * @return string
     */
    public function getTextAreaOptions()
    {
        if (!is_null($this->textAreaOptions)) {
            return 'SirTrevor.setBlockOptions("Text", {' . $this->textAreaOptions . '});' . PHP_EOL;
        }

        return '';
    }

    /**
     * @return null
     */
    public function getBlockOptions()
    {
        if (is_null($this->blockOptions)) {
            $this->blockOptions = Json::encode(
                [
                    'el'          => new JsExpression("$('.{$this->el}')"),
                    'blockTypes'  => $this->blockTypes,
                    'defaultType' => false
                ]
            );
        }
        return $this->blockOptions;
    }

    /**
     * register the all files
     */
    protected function registerAsset()
    {
        $view = $this->getView();

        if (is_null($this->initJs)) {
            $this->initJs = 'SirTrevor.DEBUG = ' . $this->debug . ';' . PHP_EOL;
            $this->initJs .= 'SirTrevor.LANGUAGE = "' . $this->language . '";' . PHP_EOL;
            $this->initJs .= 'SirTrevor.setDefaults({ uploadUrl: "' . $this->getImageUploadUrl() . '" });' . PHP_EOL;
            $this->initJs .= $this->getTextAreaOptions();
            $this->initJs .= "window.editor = new SirTrevor.Editor(" . $this->getBlockOptions() . ");" . PHP_EOL;
        }

        SirTrevorAsset::register($view)->language = $this->language;

        $view->registerJs('$(function(){' . $this->initJs . '});' . PHP_EOL);
    }
}
