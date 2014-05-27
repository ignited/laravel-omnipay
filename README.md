Omnipay for Laravel 4
==============

[![Total Downloads](https://img.shields.io/packagist/dt/ignited/laravel-omnipay.svg)](https://packagist.org/packages/ignited/laravel-omnipay)
[![Latest Version](http://img.shields.io/packagist/v/ignited/laravel-omnipay.svg)](https://github.com/ignited/laravel-omnipay/releases)
[![Dependency Status](https://www.versioneye.com/php/ignited:laravel-omnipay/badge.svg)](https://www.versioneye.com/php/ignited:laravel-omnipay)

Integrates the [Omnipay](https://github.com/adrianmacneil/omnipay) PHP library with Laravel 4 via a ServiceProvider to make Configuring multiple payment tunnels a breeze!

### Composer Configuration

Include the laravel-omnipay package as a dependency in your `composer.json`:

    "ignited/laravel-omnipay": "1.*"
    
**Note:** You don't need to include the `omnipay/common` in your composer.json - it is a requirement of the `laravel-omnipay` package.

Omnipay recently went refactoring that made it so that each package is now a seperate repository. The `omnipay/common` package includes the core framework. You will then need to include each gateway as you require. For example:

    "omnipay/eway": "*"
    
Alternatively you can include every gateway by requring:

    "omnipay/omnipay": "*"

**Note:** this requires a large amount of composer work as it needs to fetch each seperate repository. This is not recommended.

### Installation

Run `composer install` to download the dependencies.

Add a ServiceProvider to your providers array in `app/config/app.php`:

```php
'providers' => array(
	
	'Ignited\LaravelOmnipay\LaravelOmnipayServiceProvider',

)
```

Add the `Omnipay` facade to your facades array:

	'Omnipay' => 'Ignited\LaravelOmnipay\Facades\OmnipayFacade',
	
Finally, publish the configuration files via `php artisan config:publish ignited/laravel-omnipay`.

### Configuration

Once you have published the configuration files, you can add your gateway options to the config file in `app/config/packages/ignited/laravel-omnipay/config.php`.

### Usage

```php
$cardInput = array(
	'number' => '4444333322221111',
	'firstName' => 'MR. WALTER WHITE',
	'expiryMonth' => '03',
	'expiryYear' => '16',
	'cvv' => '333',
);

$card = Omnipay::creditCard($cardInput);
$response = Omnipay::purchase([
	'amount' => '100.00',
	'returnUrl' => 'http://bobjones.com/payment/return',
	'cancelUrl' => 'http://bobjones.com/payment/cancel',
	'card' => $cardInput
])->send();

dd($response->getMessage());
```
    
This will use the gateway specified in the config as `default`.

However, you can also specify a gateway to use.

```php
Omnipay::setGateway('eway');

$response = Omnipay::purchase([
	'amount' => '100.00',
	'card' => $cardInput
])->send();

dd($response->getMessage());
```
    
In addition you can take an instance of the gateway.

```php
$gateway = Omnipay::gateway('eway');
```
