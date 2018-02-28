Tags
====
Tags

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist jakharbek/yii2-tags "*"
```

or add

```
"jakharbek/yii2-tags": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :



You need to connect i18n for translations

```php
 'jakhar-tags' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@vendor/jakharbek/yii2-tags/src/messages',
                    'sourceLanguage' => 'en',
                    'fileMap' => [
                        'jakhar-tags'       => 'main.php',
                    ],
                ],
```

and migrate the database

```php
yii migrate --migrationPath=@vendor/jakharbek/yii2-tags/src/migrations
```



Update (Active Record) - Single
-----

example with Posts elements

You must connect behavior to your database model (Active Record)
```php
   
  use jakharbek\tags\behaviors\TagsModelBehavior;
  

 'tag_model'=> [
                        'class' => TagsModelBehavior::className(),
                        'attribute' => 'categoriesform',
                        'separator' => ',',
                        ],
```

after

Вы должны настроить связи по примеру Постов

```php
    public function getTags()
    {
        return $this->hasMany(Tags::className(), ['tag_id' => 'tag_id'])->viaTable('poststags', ['post_id' => 'post_id']);
    }
    public function getPoststags()
    {
        return $this->hasMany(Poststags::className(), ['post_id' => 'post_id']);
    }
```

потом вам нужно создать свойство для формы для обмена данных например
```php
            private $_tagsform;
            
            
            ...
            
            
            public function getTagsform(){
                return $this->_tagsform;
            }
            public function setTagsform($value){
                return $this->_tagsform = $value;
            }
```
если у вас уже создана можете использовать своё

View
----
```php
use jakharbek\tags\widgets\TagsWidget;


...


echo TagsWidget::widget([
        'model_db' => $model,
        'nameform' => 'Posts[tagsform]'
        ]);

``` 