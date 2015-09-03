<?php namespace Ignited\LaravelOmnipay;

class LumenOmnipayServiceProvider extends BaseServiceProvider {

	public function boot()
	{
		$this->mergeConfigFrom(realpath(__DIR__.'/../../config/config.php'), 'laravel-omnipay');
	}

}