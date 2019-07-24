<h2 align="center">
    Bitcoin Package for Laravel
</h2>

<p align="center">
    <a href="https://packagist.org/packages/chendujin/bitcoin"><img src="https://poser.pugx.org/chendujin/bitcoin/v/stable?format=flat-square" alt="Latest Stable Version"></a>
    <a href="https://packagist.org/packages/chendujin/bitcoin"><img src="https://poser.pugx.org/chendujin/bitcoin/v/unstable?format=flat-square" alt="Latest Unstable Version"></a>    
    <a href="https://packagist.org/packages/chendujin/bitcoin"><img src="https://poser.pugx.org/chendujin/bitcoin/license?format=flat-square" alt="License"></a>
    <a href="https://packagist.org/packages/chendujin/bitcoin"><img src="https://poser.pugx.org/chendujin/bitcoin/downloads" alt="Total Downloads"></a>
</p>

## Introduction

This is a simple Laravel Service Provider providing for <a href="http://cw.hubwiz.com/card/c/bitcoin-json-rpc-api/">Generic JSON RPC</a>

Installation
------------

To install the PHP client library using Composer:

```bash
composer require chendujin/bitcoin
```

### Laravel 5.5+

If you're using Laravel 5.5 or above, the package will automatically register the `Bitcoin` provider and facade.

### Laravel 5.4 and below

Add `Chendujin\Bitcoin\BitcoinServiceProvider` to the `providers` array in your `config/app.php`:

```php
'providers' => [
    // Other service providers...

    Chendujin\Bitcoin\BitcoinServiceProvider::class,
],
```

If you want to use the facade interface, you can `use` the facade class when needed:

```php
use Chendujin\Bitcoin\Facade\Bitcoin;
```

Or add an alias in your `config/app.php`:

```php
'aliases' => [
    ...
    'Bitcoin' => Chendujin\Bitcoin\Facade\Bitcoin::class,
],
```

Configuration
-------------

You can use `artisan vendor:publish` to copy the distribution configuration file to your app's config directory:

```bash
php artisan vendor:publish --provider="Chendujin\Bitcoin\BitcoinServiceProvider"
```

Then update `config/bitcoin.php` with your credentials. Alternatively, you can update your `.env` file with the following:

```dotenv
BTC_USER=xyy
BTC_SECRET=xyy
BTC_HOST=http://localhost
BTC_PORT=8332
```

Usage
-----
   
To use the Ethereum Client Library you can use the facade, or request the instance from the service container:

```php
try{
        $ret = \Chendujin\Bitcoin\Facade\Bitcoin::getnewaddress('123456');
        print_r($ret);
    }catch (Exception $e){
        echo $e->getMessage();
    }
```

Or

```php
$bitcoin = app('Bitcoin');

$result=$bitcoin->getnewaddress('123456');
```
