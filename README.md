Admin controll panel for SkeekS CMS
===================================

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist skeeks/cms-backend-admin "*"
```

or add

```
"skeeks/cms-backend-admin": "*"
```


```
"repositories": [
    {
        "type": "git",
        "url":  "https://github.com/skeeks-cms/cms-backend-admin.git"
    }
]
```

Configuration app
----------

```php

'components' => [

    'admin' =>
    [
        'class' => '\skeeks\cms\modules\admin\components\settings\AdminSettings',
        'allowedIPs' => ['91.219.167.*', '111.*']
    ],

    'urlManager' => [
        'rules' => [
            'cms-admin' => [
                "class" => 'skeeks\cms\modules\admin\components\UrlRule',
                'controllerPrefix' => '~sx'
            ],
        ]
    ]
],

'modules' => [

    'admin' =>
    [
        'class' => '\skeeks\cms\admin\Module'
    ],
],

```

___

> [![skeeks!](https://skeeks.com/img/logo/logo-no-title-80px.png)](https://skeeks.com)  
<i>SkeekS CMS (Yii2) — fast, simple, effective!</i>  
[skeeks.com](https://skeeks.com) | [cms.skeeks.com](https://cms.skeeks.com)


