Sir Trevor Editor for Yii2
==========================
Sir Trevor Editor for Yii2

![Sir Trevor in action](https://raw.github.com/madebymany/sir-trevor-js/master/examples/sir-trevor.gif)

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist perminder-klair/yii2-sir-trevor-js "*"
```

or add

```
"perminder-klair/yii2-sir-trevor-js": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
<?= $form->field($model, 'content')->widget(\kato\sirtrevorjs\SirTrevor::classname()); ?>
```

To Use Converter
----------------
Thanks to drmabuse!

To echo out html content, in Yii2 active record do as done is following example:

```php
public function renderSirTrevor()
{
    $convertor = new \kato\sirtrevorjs\SirTrevorConverter();
    return $convertor->toHtml($this->content);
}
```

Then in view: 
```php 
echo $model->renderSirTrevor() 
```

## Yii 1

This widget may be used in Yii 1 applications.

1. Follow [instructions on how to include Yii 2 in Yii 1 applications](http://www.yiiframework.com/doc-2.0/guide-tutorial-yii-integration.html#using-yii-2-with-yii-1)
2. Include the widget as follows:

```php
<?php $this->widget('\kato\sirtrevorjs\yii1compat\ESirTrevor', array(
    'model' => $model,
    'attribute' => 'content',
)); ?>
```
