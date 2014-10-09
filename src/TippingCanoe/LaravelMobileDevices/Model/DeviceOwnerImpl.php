<?php namespace TippingCanoe\LaravelMobileDevices\Model {


	trait DeviceOwnerImpl {

		/**
		 * @return \Illuminate\Database\Eloquent\Relations\MorphMany
		 */
		public function devices() {
			return $this->morphMany('TippingCanoe\LaravelMobileDevices\Model\Device', 'owner');
		}

	}

}