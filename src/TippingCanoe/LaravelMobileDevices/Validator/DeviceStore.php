<?php namespace TippingCanoe\LaravelMobileDevices\Validator {

	use TippingCanoe\Validator\Base;


	class DeviceStore extends Base {

		protected $rules = [
			'platform_id' => 'required|exists:platform,id',
			'hardware_id' => 'required',
			'version' => 'required|numeric',
			'sound' => 'integer',
			'timezone' => 'regex:/^.*\/.*$/',
			'push_from' => 'integer',
			'push_to' => 'integer'
		];

		protected $autoPopulate = true;

	}

}