Omnipay for Laravel & Lumen
==============

[![Total Downloads](https://img.shields.io/packagist/dt/ignited/laravel-omnipay.svg)](https://packagist.org/packages/ignited/laravel-omnipay)
[![Latest Version](http://img.shields.io/packagist/v/ignited/laravel-omnipay.svg)](https://github.com/ignited/laravel-omnipay/releases)

Integrates the [Omnipay](https://github.com/adrianmacneil/omnipay) PHP library with Laravel to make Configuring multiple payment tunnels a breeze!

## Installation

Include the laravel-omnipay package as a dependency in your `composer.json`:

    composer require ignited/laravel-omnipay "3.*"
    
**Note:** You don't need to include the `omnipay/common` in your composer.json - it has already been included `laravel-omnipay`.

### Install Required Providers

Now just include each gateway as you require, to included PayPal for example:

    composer require omnipay/paypal "3.*"
    
Alternatively you can include every gateway by the following:

    composer require omnipay/omnipay "3.*"

**Note:** this requires a large amount of composer work as it needs to fetch each seperate repository. This is not recommended.

## Configuration

You can publish the configuration files using the `vendor:publish` command.

```
php artisan vendor:publish --provider="Ignited\LaravelOmnipay\LaravelOmnipayServiceProvider" --tag=config
```

Once you have published the configuration files, you can add your gateway options to the config file in `config/laravel-omnipay.php`.

#### PayPal Express Example
Here is an example of how to configure password, username and, signature with paypal express checkout driver

```php
...
'gateways' => [
    'paypal' => [
        'driver'  => 'PayPal_Express',
        'options' => [
            'username'  => 'coolusername',
            'password'  => 'strongpassword',
            'signature' => '',
            'solutionType' => '',
            'landingPage'    => '',
            'headerImageUrl' => '',
            'brandName' =>  'Your app name',
            'testMode' => true
        ]
    ],
]
...
```


## Usage

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
Omnipay::setGateway('paypal');

$response = Omnipay::purchase([
	'amount' => '100.00',
	'card'   => $cardInput
])->send();

dd($response->getMessage());
```
    
In addition you can make an instance of the gateway.

```php
$gateway = Omnipay::gateway('paypal');
```

## Installation on Other Frameworks
### Lumen

For `Lumen` add the following in your bootstrap/app.php
```php
$app->register(Ignited\LaravelOmnipay\LumenOmnipayServiceProvider::class);
```

Copy the laravel-omnipay.php file from the config directory to config/laravel-omnipay.php

And also add the following to bootstrap/app.php
```php
$app->configure('laravel-omnipay');
```

## Guzzle

If you are using Guzzle 6 you need to require the following package.

    composer require php-http/guzzle6-adapter

Guzzle 7 now implements a PSR http client compliant adapter. So there is no need to include this.

## License
This package is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
