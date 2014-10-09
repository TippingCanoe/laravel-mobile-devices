<?php namespace TippingCanoe\LaravelMobileDevices\Serializer {

	use TippingCanoe\LaravelSerializer\Base;


	class Platform extends Base {

		protected $visible = [
			'id',
			'name'
		];

		protected $includeType = true;

	}

}