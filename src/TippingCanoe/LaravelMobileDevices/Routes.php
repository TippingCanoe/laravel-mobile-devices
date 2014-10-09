<?php namespace TippingCanoe\LaravelMobileDevices;

use Illuminate\Support\Facades\Route;


class Routes {

	public static function all() {
		static::allDevice();
		static::allPlatform();
	}

	public static function allDevice($prefix = 'device') {
		Route::group(['prefix' => $prefix], function () {
			static::deviceStore();
			static::deviceUpdate();
			static::deviceShow();
		});
	}

	public static function deviceStore() {
		Route::post('', 'TippingCanoe\LaravelMobileDevices\Controller\Device@store');
	}

	public static function deviceUpdate() {
		Route::post('{id}', 'TippingCanoe\LaravelMobileDevices\Controller\Device@update');
	}

	public static function deviceShow() {
		Route::get('{device_id}', 'TippingCanoe\LaravelMobileDevices\Controller\Device@show');
	}

	public static function allPlatform($prefix = 'platform') {
		Route::group(['prefix' => $prefix], function () {
			static::platformIndex();
			static::platformShow();
		});
	}

	public static function platformIndex() {
		Route::get('', 'TippingCanoe\LaravelMobileDevices\Controller\Platform@index');
	}

	public static function platformShow() {
		Route::get('{id}', 'TippingCanoe\LaravelMobileDevices\Controller\Platform@show');
	}

}





