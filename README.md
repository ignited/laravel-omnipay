Omnipay for Laravel 5/6/7/8 & Lumen
==============

[![Total Downloads](https://img.shields.io/packagist/dt/ignited/laravel-omnipay.svg)](https://packagist.org/packages/ignited/laravel-omnipay)
[![Latest Version](http://img.shields.io/packagist/v/ignited/laravel-omnipay.svg)](https://github.com/ignited/laravel-omnipay/releases)

Integrates the [Omnipay](https://github.com/adrianmacneil/omnipay) PHP library with Laravel 5 via a ServiceProvider to make Configuring multiple payment tunnels a breeze!

### Laravel 4 Support

For Laravel 4 see the [version 1.x](https://github.com/ignited/laravel-omnipay/tree/1.1.0) tree

### Omnipay 2.3/2.5
 
Version `2.0` and onwards has been updated to use Omnipay 2.3.

Version `2.2` and onwards is using Omnipay 2.5

Version `2.3` and onwards supports Laravel 5.4

### Omnipay 3 Support

Version `3.0` and onwards supports Omnipay 3.0 and Laravel 5.3, 5.4, 5.5, 5.6, 5.7

Version `3.1` and onwards supports Omnipay 3.0 and Laravel 5.3, 5.4, 5.5, 5.6, 5.7, 6.0

Version `3.2` and onwards supports Omnipay 3.0 and Laravel 5.3, 5.4, 5.5, 5.6, 5.7, 6.0, 7.0

Version `3.3` and onwards supports Omnipay 3.0 and Laravel 5.3, 5.4, 5.5, 5.6, 5.7, 6.0, 7.0, 8.0

### Composer Configuration

Include the laravel-omnipay package as a dependency in your `composer.json`:

    composer require ignited/laravel-omnipay "3.*"
    
**Note:** You don't need to include the `omnipay/common` in your composer.json - it is a requirement of the `laravel-omnipay` package.

Omnipay recently went refactoring that made it so that each package is now a seperate repository. The `omnipay/common` package includes the core framework. You will then need to include each gateway as you require. For example:

    composer require omnipay/eway "3.*"
    
Alternatively you can include every gateway by requring:

    composer require omnipay/omnipay "3.*"

**Note:** this requires a large amount of composer work as it needs to fetch each seperate repository. This is not recommended.

### Guzzle 6

If you are using Guzzle 6 you need to require the following package.

    composer require php-http/guzzle6-adapter

Guzzle 7 now implements a PSR http client compliant adapter. So there is no need to include this.

#### Laravel 5

Add a ServiceProvider to your providers array in `config/app.php`:

```php
'providers' => [

	Ignited\LaravelOmnipay\LaravelOmnipayServiceProvider::class

]
```

Add the `Omnipay` facade to your facades array:

```php
	'Omnipay' => Ignited\LaravelOmnipay\Facades\OmnipayFacade::class
```

Finally, publish the configuration files:

```
php artisan vendor:publish --provider="Ignited\LaravelOmnipay\LaravelOmnipayServiceProvider" --tag=config
```

#### Lumen

For `Lumen` add the following in your bootstrap/app.php
```php
$app->register(Ignited\LaravelOmnipay\LumenOmnipayServiceProvider::class);
```

Copy the laravel-omnipay.php file from the config directory to config/laravel-omnipay.php

And also add the following to bootstrap/app.php
```php
$app->configure('laravel-omnipay');
```

### Configuration

Once you have published the configuration files, you can add your gateway options to the config file in `config/laravel-omnipay.php`.

#### PayPal Express Example
Here is an example of how to configure password, username and, signature with paypal express checkout driver

```php
...
'gateways' => [
    'paypal' => [
        'driver'  => 'PayPal_Express',
        'options' => [
            'username'  => env( 'OMNIPAY_PAYPAL_EXPRESS_USERNAME', '' ),
            'password'  => env( 'OMNIPAY_PAYPAL_EXPRESS_PASSWORD', '' ),
            'signature' => env( 'OMNIPAY_PAYPAL_EXPRESS_SIGNATURE', '' ),
            'solutionType' => env( 'OMNIPAY_PAYPAL_EXPRESS_SOLUTION_TYPE', '' ),
            'landingPage'    => env( 'OMNIPAY_PAYPAL_EXPRESS_LANDING_PAGE', '' ),
            'headerImageUrl' => env( 'OMNIPAY_PAYPAL_EXPRESS_HEADER_IMAGE_URL', '' ),
            'brandName' =>  'Your app name',
            'testMode' => env( 'OMNIPAY_PAYPAL_TEST_MODE', true )
        ]
    ],
]
...
```


### Usage

```php
$cardInput = [
	'number'      => '4444333322221111',
	'firstName'   => 'MR. WALTER WHITE',
	'expiryMonth' => '03',
	'expiryYear'  => '16',
	'cvv'         => '333',
];

$card = Omnipay::creditCard($cardInput);
$response = Omnipay::purchase([
	'amount'    => '100.00',
	'returnUrl' => 'http://bobjones.com/payment/return',
	'cancelUrl' => 'http://bobjones.com/payment/cancel',
	'card'      => $cardInput
])->send();

dd($response->getMessage());
```
    
This will use the gateway specified in the config as `default`.

However, you can also specify a gateway to use.

```php
Omnipay::setGateway('eway');

$response = Omnipay::purchase([
	'amount' => '100.00',
	'card'   => $cardInput
])->send();

dd($response->getMessage());
```
    
In addition you can take an instance of the gateway.

```php
$gateway = Omnipay::gateway('eway');
```
