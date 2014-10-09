<?php namespace TippingCanoe\LaravelMobileDevices\Repository {


	interface Platform {

		public function getById($id);
		public function all();

	}

}