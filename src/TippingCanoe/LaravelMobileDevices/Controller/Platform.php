<?php namespace TippingCanoe\LaravelMobileDevices\Controller {

	use Illuminate\Http\JsonResponse;
	use Illuminate\Routing\Controller;
	use Symfony\Component\HttpKernel\Exception\HttpException;
	use TippingCanoe\LaravelMobileDevices\Repository\Platform as PlatformRepository;
	use TippingCanoe\LaravelMobileDevices\Model\Platform as PlatformModel;
	use TippingCanoe\LaravelMobileDevices\Serializer\Platform as PlatformSerializer;


	class Platform extends Controller {

		/** @var \TippingCanoe\LaravelMobileDevices\Repository\Platform */
		protected $platformRepository;

		public function __construct(
			PlatformRepository $platformRepository
		) {
			$this->platformRepository = $platformRepository;
		}

		public function index() {
			$platforms = $this->platformRepository->all();
			return $this->serialize($platforms);
		}

		public function show($id) {
			$platform = $this->getPlatformById($id);
			return $this->serialize($platform);
		}

		//
		//
		//

		/**
		 * Returns a JSON response of a Platform, ready to be output.
		 *
		 * @param PlatformModel|PlatformModel[] $data
		 * @return JsonResponse
		 */
		protected function serialize($data) {
			$serializer = PlatformSerializer::make($data);
			return new JsonResponse($serializer);
		}

		/**
		 * @param $id
		 * @return null|\TippingCanoe\LaravelMobileDevices\Model\Platform
		 * @throws \Symfony\Component\HttpKernel\Exception\HttpException
		 */
		protected function getPlatformById($id) {

			if(!$platform = $this->platformRepository->getById($id))
				throw new HttpException(404, sprintf('Platform with id %s not found.', $id));

			return $platform;

		}

	}

}