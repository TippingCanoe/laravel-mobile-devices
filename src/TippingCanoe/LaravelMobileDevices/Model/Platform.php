<?php namespace TippingCanoe\LaravelMobileDevices\Model {

	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Database\Query\Builder;


	/**
	 * Class Platform
	 *
	 * Represents a hardware device platform.
	 *
	 */
	class Platform extends Model {

		protected $table = 'platform';

		protected $fillable = [
			'name'
		];

		public $timestamps = false;

		/**
		 * @return \Illuminate\Database\Eloquent\Relations\HasMany
		 */
		public function devices() {
			return $this->hasMany('TippingCanoe\LaravelMobileDevices\Model\Device');
		}

		/**
		 * Restrict the query based on the supplied device.
		 *
		 * @param Builder $query
		 * @param int $device
		 * @return mixed
		 */
		public function scopeForDeviceId(Builder $query, $device) {
			return $this->forDeviceIds($device);
		}

		/**
		 * Restrict the query based on the supplied devices.
		 *
		 * @param Builder $query
		 * @param array $devices
		 * @return Builder|static
		 */
		public function scopeForDeviceIds(Builder $query, $devices) {

			if(!is_array($devices))
				$devices = (array)$devices;

			return $query
				->join('device', 'device.platform_id', '=', 'platform.id')
				->whereIn('device.id', $devices)
			;

		}

	}

}