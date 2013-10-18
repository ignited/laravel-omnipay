<?php namespace Ignited\LaravelOmnipay;

use Illuminate\Support\ServiceProvider;
use Omnipay\Common\GatewayFactory;

class LaravelOmnipayServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	public function boot()
	{
		$this->package('ignited/laravel-omnipay', 'ignited/laravel-omnipay');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->registerManager();
	}

	/**
	 * Register the Omnipay manager
	 */
	public function registerManager()
	{
		$this->app['omnipay'] = $this->app->share(function($app)
		{
			$factory = new GatewayFactory;
			$manager = new LaravelOmnipayManager($app, $factory);

			return $manager;	
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('omnipay');
	}

}