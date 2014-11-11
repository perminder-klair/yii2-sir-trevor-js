<?php

namespace kato\sirtrevorjs\yii1compat;

use Yii;
use CHtml;
use yii\helpers\Html;
use yii\helpers\Json;
use kato\sirtrevorjs\assets\SirTrevorAsset;
use kato\sirtrevorjs\yii1compat\ESirTrevorView;
use yii\web\JsExpression;

/**
 * Class ESirTrevor
 *
 * An almost identical class compared to SirTrevor, except for adaptations that makes it possible
 * to use in Yii 1 themes together with the ESirTrevorView component.
 */
class ESirTrevor extends \CInputWidget
{

    protected $_view;
    public $options = array();

    public function getView()
    {
        if (is_null($this->_view)) {
            // ESirTrevorView includes yii1 bridge methods
            $this->_view = new ESirTrevorView();
        }
        return $this->_view;
    }

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

        Yii::setAlias('@sirtrevorjs', dirname(__FILE__) . DIRECTORY_SEPARATOR . '..');
        $this->registerAsset();

        echo $this->renderInput();
    }

    /**
     * Render the text area input
     */
    protected function renderInput()
    {
        if ($this->hasModel()) {
            $input = CHtml::activeTextArea($this->model, $this->attribute, $this->options);
        } else {
            $input = CHtml::textArea($this->name, $this->value, $this->options);
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

        // Registering assets through the ESirTrevorView yii1 bridge methods
        $assetBundle = new SirTrevorAsset();
        $assetBundle->depends = []; // To prevent triggering inclusion of yii2 jquery asset bundle
        $assetBundle->language = $this->language;
        $this->view->assetPath = $assetBundle->sourcePath;
        $assetBundle->registerAssetFiles($view);

        // For yii1 compatibility we need to refrain from using View::POS_LOAD or View::POS_READY since that would attempt to include the yii2 jquery asset bundle
        $view->registerJs(
            '(function($){
                "use strict";
                $(function(){
                        ' . $this->initJs . '
                });
            })(jQuery);',
            $view::POS_END
        );

    }
}
