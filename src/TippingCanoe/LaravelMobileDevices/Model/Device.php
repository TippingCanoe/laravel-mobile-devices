<?php namespace TippingCanoe\LaravelMobileDevices\Model {

	use Carbon\Carbon;
	use Illuminate\Database\Eloquent\Builder;
	use Illuminate\Database\Eloquent\Model;


	/**
	 * Class Device
	 *
	 * Represents a hardware device.
	 *
	 */
	class Device extends Model {

		protected $table = 'device';

		protected $fillable = [
			'platform_id',
			'hardware_id',
			'version',
			'push_token',
			'sound',
			'timezone',
			'push_from',
			'push_to'
		];

		/**
		 * The platform for the device.
		 *
		 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
		 */
		public function platform() {
			return $this->belongsTo('TippingCanoe\LaravelMobileDevices\Model\Platform');
		}

		/**
		 * If set, returns the DeviceOwner instance for this device.
		 *
		 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
		 */
		public function owner() {
			return $this->morphTo();
		}

		/**
		 * Strongly typed setter to shear eloquent attribute assignment.
		 *
		 * @param DeviceOwner $owner
		 */
		public function setOwner(DeviceOwner $owner = null) {
			$this->owner_type = $owner ? get_class($owner) : $owner;
			$this->owner_id = $owner ? $owner->getKey() : $owner;
		}

		/**
		 * Restrict the query to the device with the supplied push_token.
		 *
		 * @param \Illuminate\Database\Eloquent\Builder $query
		 * @param $pushToken
		 * @internal param $token
		 * @return mixed
		 */
		public function scopeWithPushToken(Builder $query, $pushToken) {
			return $query->where('push_token', '=', $pushToken);
		}

		/**
		 * Restrict the query to the device with the supplied hardware_id
		 *
		 * @param \Illuminate\Database\Eloquent\Builder $query
		 * @param $hardwareId
		 * @return mixed
		 */
		public function scopeWithHardwareId(Builder $query, $hardwareId) {
			return $query->where('hardware_id', '=', $hardwareId);
		}

		//
		// Disabled Functionality
		//
		public function getDisabledAttribute() {
			return (boolean)$this->disabled_at;
		}
		public function getEnabledAttribute() {
			return !(boolean)$this->disabled_at;
		}
		public function disable() {
			$this->disabled_at = Carbon::now();
		}
		public function enable() {
			$this->disabled_at = null;
		}

		//
		// Invalid Functionality
		//
		public function getInvalidAttribute() {
			return (boolean)$this->invalidated_at;
		}
		public function getValidAttribute() {
			return !(boolean)$this->invalidated_at;
		}
		public function invalidate() {
			$this->invalidated_at = Carbon::now();
		}
		public function revalidate() {
			$this->invalidated_at = null;
		}

	}

}