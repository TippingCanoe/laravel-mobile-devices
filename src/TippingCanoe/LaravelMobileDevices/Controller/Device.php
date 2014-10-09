<?php namespace TippingCanoe\LaravelMobileDevices\Controller {

	use Illuminate\Routing\Controller;
	use TippingCanoe\LaravelMobileDevices\Model\DeviceOwner;
	use TippingCanoe\LaravelMobileDevices\Service\Device as DeviceService;
	use TippingCanoe\LaravelMobileDevices\Validator\DeviceStore;
	use TippingCanoe\LaravelMobileDevices\Validator\DeviceUpdate;
	use TippingCanoe\LaravelMobileDevices\Model\Device as DeviceModel;
	use TippingCanoe\LaravelMobileDevices\Serializer\Device as DeviceSerializer;
	use Symfony\Component\HttpKernel\Exception\HttpException;
	use Illuminate\Http\JsonResponse;
	use Illuminate\Auth\AuthManager;


	class Device extends Controller {

		/** @var \TippingCanoe\LaravelMobileDevices\Service\Device */
		protected $deviceService;

		/** @var \Illuminate\Auth\AuthManager */
		protected $auth;

		/**
		 * @param \TippingCanoe\LaravelMobileDevices\Service\Device $deviceService
		 * @param AuthManager $auth
		 */
		public function __construct(
			DeviceService $deviceService,
			AuthManager $auth
		) {
			$this->deviceService = $deviceService;
			$this->auth = $auth;
		}

		/**
		 * @return \Illuminate\Http\JsonResponse
		 */
		public function store() {

			$deviceData = new DeviceStore();
			$deviceData->assertValid();

			$device = $this->deviceService->store($deviceData->values, $this->getOwner());

			return $this->serialize($device);

		}

		/**
		 * @param int $id
		 * @return \Illuminate\Http\JsonResponse
		 */
		public function update($id) {

			$device = $this->getDeviceById($id);

			$deviceData = new DeviceUpdate();
			$deviceData->assertValid();

			$this->deviceService->update($device, $deviceData->values, $this->getOwner());

			return $this->serialize($device);

		}

		/**
		 * @param $hardwareId
		 * @return \Illuminate\Http\JsonResponse
		 */
		public function show($hardwareId) {
			$device = $this->getDeviceByHardwareId($hardwareId, $this->getOwner());
			return $this->serialize($device);
		}

		//
		//
		//

		/**
		 * Returns a JSON response of a Device, ready to be output.
		 *
		 * @param DeviceModel|DeviceModel[] $data
		 * @return JsonResponse
		 */
		protected function serialize($data) {
			$serializer = DeviceSerializer::make($data);
			return new JsonResponse($serializer);
		}

		/**
		 * Returns the current user if it is a DeviceOwner instance or null.
		 *
		 * @throws \Symfony\Component\HttpKernel\Exception\HttpException
		 * @return DeviceOwner|null
		 */
		protected function getOwner() {

			$owner = $this->auth->user();

			if(
				is_null($owner)
				|| (
					is_object($owner)
					&& $owner instanceof DeviceOwner
				)
			) {
				return $owner;
			}
			else {
				throw new HttpException(400, sprintf('The currently authenticated context cannot own devices.'));
			}

		}

		/**
		 * @param string $hardwareId
		 * @param \TippingCanoe\LaravelMobileDevices\Model\DeviceOwner $owner
		 * @throws \Symfony\Component\HttpKernel\Exception\HttpException
		 * @return null|\TippingCanoe\LaravelMobileDevices\Model\Device
		 */
		protected function getDeviceByHardwareId($hardwareId, DeviceOwner $owner = null) {

			if(!$device = $this->deviceService->getByHardwareId($hardwareId))
				throw new HttpException(404, sprintf('Device with hardware id %s not found.', $hardwareId));

			$this->assertDeviceAccess($device, $owner);

			return $device;

		}

		/**
		 * @param int|string $id
		 * @param \TippingCanoe\LaravelMobileDevices\Model\DeviceOwner $owner
		 * @throws \Symfony\Component\HttpKernel\Exception\HttpException
		 * @return null|\TippingCanoe\LaravelMobileDevices\Model\Device
		 */
		protected function getDeviceById($id, DeviceOwner $owner = null) {

			if(!$device = $this->deviceService->get($id))
				throw new HttpException(404, sprintf('Device with id %s not found.', $id));

			$this->assertDeviceAccess($device, $owner);

			return $device;

		}

		/**
		 * Ensures the current request context has access to the device.
		 *
		 * @param DeviceModel $device
		 * @param DeviceOwner $owner
		 * @throws \Symfony\Component\HttpKernel\Exception\HttpException
		 */
		protected function assertDeviceAccess(DeviceModel $device, DeviceOwner $owner = null) {
			if(!$this->deviceService->checkAccess($device, $owner))
				throw new HttpException(403, sprintf('You do not have permission to view this device.'));
		}

	}

}