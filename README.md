Omnipay for Laravel 4
==============

Integrates the [Omnipay](https://github.com/adrianmacneil/omnipay) PHP library with Laravel 4 via a ServiceProvider to make Configuring multiple payment tunnels a breeze!

*Note:* for Omnipay 2.0 see version `1.1` and onwards or `master`.

### Installation

Include the laravel-omnipay package as a dependency in your `composer.json`:

    "ignited/laravel-omnipay": "~1.0"
    
**Note:** You don't need to include the `omnipay/omnipay` in your composer.json - it is a requirement of the `laravel-omnipay` package.

Run `composer install` to download the dependencies.

Add a ServiceProvider to your providers array in `app/config/app.php`:

	'providers' => array(
		
		'Ignited\LaravelOmnipay\LaravelOmnipayServiceProvider',
	
	)

Add the `Omnipay` facade to your facades array:

	'Omnipay' => 'Ignited\LaravelOmnipay\Facades\OmnipayFacade',
	
Finally, publish the configuration files via `php artisan config:publish ignited/laravel-omnipay`.

### Configuration

Once you have published the configuration files, you can add your gateway options to the config file in `app/config/packages/ignited/laravel-omnipay/config.php`.

### Usage

    $cardInput = array(
        'number' => '4444333322221111',
        'firstName'   => 'MR B BOB BROWN',
        'expiryMonth'  => '03',
        'expiryYear'   => '16',
        'cvv'    => '333',
    );

    $card = Omnipay::creditCard($cardInput);
    $response = Omnipay::purchase([
        'amount'=>'100.00',
        'returnUrl' => 'http://bobjones.com/payment/return',
        'cancelUrl' => 'http://bobjones.com/payment/cancel',
        'card'=>$cardInput
    ])->send();

    dd($response->getMessage());
    
This will use the gateway specified in the config as `default`.

However, you can also specify a gateway to use.

    Omnipay::setGateway('eway');
    
    $response = Omnipay::purchase([
        'amount'=>'100.00',
        'card'=>$cardInput
    ])->send();

    dd($response->getMessage());
    
In addition you can take an instance of the gateway.

	$gateway = Omnipay::gateway('eway');
