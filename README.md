
# Twitter Map

Tweets nearby on the map

## Requirements

* PHP 7
* Composer
* MySQL 5.5

## Installing

Install dependencies

```
composer install
```

Edit the file `config/db.php` with real data, for example:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yii2basic',
    'username' => 'root',
    'password' => '1234',
    'charset' => 'utf8mb64',
];
```

Run migrations

```
php yii migrate/fresh
```

Copy .env.example file at the root directory of your application

```
cp .env.example .env
```

Then add the variables to it

```
TWITTER_OAUTH_ACCESS_TOKEN=YOUR_ACCESS_TOKEN
TWITTER_OAUTH_ACCESS_TOKEN_SECRET=YOUR_ACCESS_TOKEN_SECRET
TWITTER_CONSUMER_KEY=YOUR_CONSUMER_KEY
TWITTER_CONSUMER_SECRET=YOUR_CONSUMER_SECRET
```

## Use Twitter API Keys

You should use API keys from a Twitter app generated on https://apps.twitter.com

To use existing Twitter API Keys:
1. Go to your Twitter application's settings at [Twitter's developer site](https://apps.twitter.com).
2. Find your application and go to the settings tab.
3. Add callback url:  your-domain.com/user/auth.
4. Click update settings.# Twitter Map
