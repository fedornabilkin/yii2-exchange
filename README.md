Credit exchange
===============
The exchange of credits on the basis of Yii2

This extension uses the module [yii2-user](https://github.com/dektrium/yii2-user).

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist fedornabilkin/yii2-exchange "*"
```

or add

```
"fedornabilkin/yii2-exchange": "*"
```

to the require section of your `composer.json` file.

Migrations
-----

`php yii migrate --migrationPath=@fedornabilkin/exchange/migrations`


Usage
-----

Your project's User model must implement
the `interfaces/ExchangeUserInterface`,
since the user's actions on the exchange will initiate a call
to the `creditAction(), creditSale(), creditBuy()` methods.

