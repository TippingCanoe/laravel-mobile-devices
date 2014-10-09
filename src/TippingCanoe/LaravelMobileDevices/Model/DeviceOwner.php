<?php namespace TippingCanoe\LaravelMobileDevices\Model {


	interface DeviceOwner {

		/**
		 * @return \Illuminate\Database\Eloquent\Relations\MorphMany
		 */
		public function devices();

	}

}