<?php namespace TippingCanoe\LaravelMobileDevices\Validator {

	use TippingCanoe\Validator\Base;


	class DeviceUpdate extends Base {

		protected $rules = [
			'platform_id' => 'exists:platform,id',
			'hardware_id' => 'size:1',
			'version' => 'numeric',
			'push_token' => 'size:1',
			'sound' => 'integer',
			'timezone' => 'regex:/^.*\/.*$/',
			'push_from' => 'integer',
			'push_to' => 'integer'
		];

		protected $autoPopulate = true;

	}

}