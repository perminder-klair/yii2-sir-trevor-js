Sir Trevor Editor for Yii2
==========================
Sir Trevor Editor for Yii2

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
<?= $form->field($model, 'content')->widget(\kato\sirtrevorjs\SirTrevor::classname()); ?>``