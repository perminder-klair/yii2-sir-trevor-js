<?php

namespace kato\sirtrevorjs\yii1compat;

use Yii;

/**
 * Makes sure that registered assets gets registered in Yii 1 Client Manager using Yii 1 Asset Manager
 *
 * Class ESirTrevorView
 */
class ESirTrevorView extends \yii\web\View
{
    /**
     * Set this based on asset bundle's sourcePath
     */
    public $assetPath;

    /**
     * @var bool whether we should copy the asset file or directory even if it is already published before.
     */
    public $forceCopyAssets = false;

    /**
     * @var
     */
    private $_assetsUrl;

    /**
     * Returns the url to the published folder that contains the assets for this extension.
     * @return string the url.
     */
    protected function getAssetsUrl()
    {
        if (!isset($this->_assetsUrl)) {
            //$assetPath = Yii::getPathOfAlias($this->assetPathAlias);
            //if (!$assetPath) {
            //    throw new CException("Asset path alias $this->assetPathAlias could not be resolved");
            //}
            $assetPath = $this->assetPath;
            $this->_assetsUrl = Yii::app()->assetManager->publish($assetPath, false, -1, $this->forceCopyAssets);
        }
        return $this->_assetsUrl;
    }

    /**
     * @param string $url
     * @param array $options Ignored
     * @param null $key Ignored
     */
    public function registerCssFile($url, $options = [], $key = null)
    {

        Yii::log('Registering ' . $url, 'info', __METHOD__);

        // Register in parent in order to trigger any errors with the parameters
        parent::registerCssFile($url, $options, $key);

        // Register using Yii1 client script
        $clientScript = Yii::app()->getClientScript();
        $url = $this->getAssetsUrl() . $url;
        $clientScript->registerCssFile($url);
    }

    public function registerJsFile($url, $options = [], $key = null)
    {
        Yii::log('Registering ' . $url, 'info', __METHOD__);

        // Register in parent in order to trigger any errors with the parameters
        parent::registerJsFile($url, $options, $key);

        // Register using Yii1 client script
        $clientScript = Yii::app()->getClientScript();
        $url = $this->getAssetsUrl() . $url;
        $clientScript->registerScriptFile($url);

    }

    public function registerJs($js, $position = self::POS_READY, $key = null)
    {

        Yii::log('Registering ' . $js, 'info', __METHOD__);

        // Register in parent in order to trigger any errors with the parameters
        parent::registerJs($js, $position, $key);

        // Register using Yii1 client script
        $clientScript = Yii::app()->getClientScript();
        $clientScript->registerScript(uniqid(), $js, $position);

    }
} 