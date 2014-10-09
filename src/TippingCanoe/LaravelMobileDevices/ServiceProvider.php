<?php namespace TippingCanoe\LaravelMobileDevices {

	use Illuminate\Support\ServiceProvider as Base;


	class ServiceProvider extends Base {

		/**
		 * Register the service provider.
		 *
		 * @return void
		 */
		public function register() {

			$this->app->bind('TippingCanoe\LaravelMobileDevices\Repository\Device', 'TippingCanoe\LaravelMobileDevices\Repository\DbDevice');
			$this->app->bind('TippingCanoe\LaravelMobileDevices\Repository\Platform', 'TippingCanoe\LaravelMobileDevices\Repository\DbPlatform');
			$this->app->bind('Illuminate\Auth\AuthManager', 'auth');
			$this->app->bind('Illuminate\Events\Dispatcher', 'events');

		}

		/**
		 * During framework boot.
		 */
		public function boot() {
			$this->package('tippingcanoe/laravel-mobile-devices');
		}

	}

}