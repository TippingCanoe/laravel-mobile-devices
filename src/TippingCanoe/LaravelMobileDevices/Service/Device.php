<?php namespace TippingCanoe\LaravelMobileDevices\Service {

	use TippingCanoe\LaravelMobileDevices\Repository\Device as DeviceRepository;
	use Illuminate\Events\Dispatcher as EventDispatcher;
	use TippingCanoe\LaravelMobileDevices\Model\Device as DeviceModel;
	use TippingCanoe\LaravelMobileDevices\Model\DeviceOwner;


	class Device {

		/** @var \TippingCanoe\LaravelMobileDevices\Repository\Device */
		protected $deviceRepository;

		/** @var \Illuminate\Events\Dispatcher */
		protected $events;

		/**
		 * @param DeviceRepository $deviceRepository
		 * @param \Illuminate\Events\Dispatcher $events
		 */
		public function __construct(
			DeviceRepository $deviceRepository,
			EventDispatcher $events
		) {
			$this->deviceRepository = $deviceRepository;
			$this->events = $events;
		}

		/**
		 * @param array $attributes
		 * @param \TippingCanoe\LaravelMobileDevices\Model\DeviceOwner|\Illuminate\Database\Eloquent\Model $owner
		 * @return \TippingCanoe\LaravelMobileDevices\Model\Device
		 */
		public function store(array $attributes, DeviceOwner $owner = null) {

			$metaInstance = new DeviceModel();

			$device = $this->deviceRepository->createOrUpdate(array_only($attributes, $metaInstance->getFillable()));
			$this->associate($device, $owner);

			$this->events->fire('device.stored', [
				'device' => $device,
				'attributes' => $attributes
			]);

			return $device;

		}

		/**
		 * @param DeviceModel $device
		 */
		public function disassociate(DeviceModel $device) {
			$this->associate($device);
		}

		/**
		 * @param DeviceModel $device
		 * @param DeviceOwner $owner
		 */
		public function associate(DeviceModel $device, DeviceOwner $owner = null) {
			$device->setOwner($owner);
			$device->save();
		}

		/**
		 * @param DeviceModel $device
		 * @param array $attributes
		 * @param \TippingCanoe\LaravelMobileDevices\Model\DeviceOwner $owner
		 * @return bool
		 */
		public function update(DeviceModel $device, array $attributes, DeviceOwner $owner = null) {

			if($this->checkAccess($device, $owner)) {

				$metaInstance = new DeviceModel();

				$device->update(array_only($attributes, $metaInstance->getFillable()));

				$this->events->fire('device.updated', [
					'device' => $device,
					'attributes' => $attributes
				]);

				return true;

			}

			return false;

		}

		/**
		 * @param int|string $id
		 * @return \TippingCanoe\LaravelMobileDevices\Model\Device
		 */
		public function get($id) {
			return $this->deviceRepository->getById($id);
		}

		/**
		 * @param string $hardwareId
		 * @return \TippingCanoe\LaravelMobileDevices\Model\Device
		 */
		public function getByHardwareId($hardwareId) {
			return $this->deviceRepository->getByHardwareId($hardwareId);
		}

		/**
		 * Returns true if the parameters indicate access to the device.
		 *
		 * @param DeviceModel $device
		 * @param DeviceOwner $owner
		 * @return bool
		 */
		public function checkAccess(DeviceModel $device, DeviceOwner $owner = null) {

			// If the device has an owner specified, we need to check.
			if($device->owner_id && $device->owner_type) {

				if(
					$device->owner->getKey() == $owner->getKey()
					&& get_class($device->owner) == get_class($owner->getKey())
				)
					return true;

			}
			// If the device has no owner, we can skip the check.
			else {

				// If no owner was supplied, bypass the check.
				if(!$owner)
					return true;

			}

			return false;

		}

	}

}