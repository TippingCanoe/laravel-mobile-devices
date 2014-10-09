<?php namespace TippingCanoe\LaravelMobileDevices\Repository {

	use TippingCanoe\LaravelMobileDevices\Repository\Device as DeviceRepository;
	use TippingCanoe\LaravelMobileDevices\Model\Device as DeviceModel;


	class DbDevice implements DeviceRepository {

		/**
		 * @param $id
		 * @return null|Device
		 */
		public function getById($id) {
			return DeviceModel::find($id);
		}

		/**
		 * @param string $hardwareId
		 * @return \TippingCanoe\LaravelMobileDevices\Model\Device
		 */
		public function getByHardwareId($hardwareId) {
			return DeviceModel::withHardwareId($hardwareId)->first();
		}

		/**
		 * @param array $data
		 * @return null|Device
		 */
		public function createOrUpdate($data) {

			// Null out push token if it's falsey.
			if(array_key_exists('push_token', $data) && !$data['push_token'])
				$data['push_token'] = null;

			$device = DeviceModel
				::where('hardware_id', '=', $data['hardware_id'])
				->first()
			;

			if($device)
				$device->update($data);
			else
				$device = DeviceModel::create($data);

			return $device;

		}

	}

}