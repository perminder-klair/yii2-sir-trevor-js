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

    public function run()
    {
        return '<form>
    <div class="errors"></div>
    <textarea class="sir-trevor" name="content"></textarea>
    <input type="submit" value="Submit">
  </form>';
    }

    private function registerAsset(){
        $view = $this->getView();
        SirTrevorAsset::register($view);

        $js = "$(function(){
      SirTrevor.DEBUG = true;
      SirTrevor.LANGUAGE = 'en';

      SirTrevor.setBlockOptions('Text', {
        onBlockRender: function() {
          console.log('Text block rendered');
        }
      });

      window.editor = new SirTrevor.Editor({
        el: $('.sir-trevor'),
        blockTypes: [
          'Heading',
          'Text',
          'List',
          'Quote',
          'Image',
          'Video',
          'Tweet'
        ]
      });

      $('form').bind('submit', function(){
        return false;
      });

    });";


        $view->registerJs($js);
    }
}
