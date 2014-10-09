<?php namespace TippingCanoe\LaravelMobileDevices\Serializer {

	use TippingCanoe\LaravelSerializer\Base;


	class Device extends Base {

		protected $visible = [
			'id',
			'platform',
			'hardware_id',
			'version',
			'push_token',
			'sound',
			'timezone',
			'push_from',
			'push_to',
			'disabled',
			'invalid'
		];

		protected $includeType = true;

		public function getPlatformAttribute() {
			return new Platform($this->data->platform);
		}

	}

}