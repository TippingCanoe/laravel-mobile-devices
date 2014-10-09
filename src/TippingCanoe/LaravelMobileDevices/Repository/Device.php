<?php namespace TippingCanoe\LaravelMobileDevices\Repository {


	interface Device {

		/**
		 * @param int $id
		 * @return \TippingCanoe\LaravelMobileDevices\Model\Device
		 */
		public function getById($id);

		/**
		 * @param string $hardwareId
		 * @return \TippingCanoe\LaravelMobileDevices\Model\Device
		 */
		public function getByHardwareId($hardwareId);

		/**
		 * @param array $data
		 * @return \TippingCanoe\LaravelMobileDevices\Model\Device
		 */
		public function createOrUpdate($data);

	}

}