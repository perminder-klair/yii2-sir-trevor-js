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
    public $debug = false;

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
    public $blockTypes = ["Heading", "Text", "List", "Quote", "Image", "Video", "Textimage"];

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
     * other blocks options
     * example:
     * 'otherBlockOptions' => [
     *  'Redactor' => 'onBlockRender: function () { this.$("#redactor-editor").redactor({ buttonSource: true }); }',
     * ]
     * @var null
     */
    public $otherBlockOptions = null;

    /**
     * Enable or Disable Scroll of Editor on Init of a block
     * @var bool
     */
    public $disableScroll = false;

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();

        if (is_bool($this->debug)) {
            if ($this->debug === true) {
                $this->debug = 'true';
            } else {
                $this->debug = 'false';
            }
        }

        if (is_bool($this->disableScroll)) {
            if ($this->disableScroll === true) {
                $this->disableScroll = 'true';
            } else {
                $this->disableScroll = 'false';
            }
        }

        $this->options['class'] = $this->el;

        Yii::setAlias('@sirtrevorjs', dirname(__FILE__));
        $this->registerAsset();
    }

    public function run()
    {
        return $this->renderInput();
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
    public function getOtherBlocksOptions()
    {
        $options = '';
        if (!is_null($this->otherBlockOptions)) {
            //return 'SirTrevor.setBlockOptions("' . $blockName . '", {' . $this->textAreaOptions . '});' . PHP_EOL;
            if (is_array($this->otherBlockOptions)) {
                foreach ($this->otherBlockOptions as $key => $value) {
                    $options .= 'SirTrevor.setBlockOptions("' . $key . '", {' . $value . '});' . PHP_EOL;
                }
            }
        }

        return $options;
    }

    /**
     * @return null
     */
    public function getBlockOptions()
    {
        if (is_null($this->blockOptions)) {
            $this->blockOptions = Json::encode(
                [
                    'el' => new JsExpression("$('.{$this->el}')"),
                    'blockTypes' => $this->blockTypes,
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
            $this->initJs = 'SirTrevor.config.debug = ' . $this->debug . ';' . PHP_EOL;
            $this->initJs .= 'SirTrevor.config.language = "' . $this->language . '";' . PHP_EOL;
            $this->initJs .= 'SirTrevor.config.disableScroll = ' . $this->disableScroll . ';' . PHP_EOL;
            $this->initJs .= 'SirTrevor.setDefaults({ uploadUrl: "' . $this->getImageUploadUrl() . '" });' . PHP_EOL;
            $this->initJs .= $this->getOtherBlocksOptions();
            $this->initJs .= "window.editor = new SirTrevor.Editor(" . $this->getBlockOptions() . ");" . PHP_EOL;
        }

        $asset = SirTrevorAsset::register($view);
        $asset->language = $this->language;
        $asset->debug = $this->debug;

        $view->registerJs('$(function(){' . $this->initJs . '});' . PHP_EOL);
    }
}
