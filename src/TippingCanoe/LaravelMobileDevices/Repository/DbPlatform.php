<?php namespace TippingCanoe\LaravelMobileDevices\Repository {

	use TippingCanoe\LaravelMobileDevices\Repository\Platform as PlatformRepository;
	use TippingCanoe\LaravelMobileDevices\Model\Platform as PlatformModel;


	class DbPlatform implements PlatformRepository {

		/**
		 * @param $id
		 * @return Platform
		 */
		public function getById($id) {
			return PlatformModel::find($id);
		}

		/**
		 * @return \Illuminate\Database\Eloquent\Collection
		 */
		public function all() {
			return PlatformModel::all();
		}

	}

}